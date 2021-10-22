<?php

namespace LoginWP\Core;

class Helpers
{
    public static function get_rule_by_id($id)
    {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                'SELECT * FROM ' . PTR_LOGINWP_DB_TABLE . " WHERE id = %d",
                absint($id)
            ),
            'ARRAY_A'
        );
    }

    public static function get_other_users_rule()
    {
        global $wpdb;

        return $wpdb->get_row('SELECT rul_url, rul_url_logout FROM ' . PTR_LOGINWP_DB_TABLE . " WHERE rul_type = 'all'", 'ARRAY_A');
    }

    public static function get_after_registration_rule()
    {
        global $wpdb;

        return $wpdb->get_var('SELECT rul_url FROM ' . PTR_LOGINWP_DB_TABLE . " WHERE rul_type = 'register'");
    }

    public static function username_list()
    {
        global $wpdb;

        $rul_userresults = $wpdb->get_results('SELECT user_login FROM ' . $wpdb->users . ' ORDER BY user_login', 'ARRAY_N');

        return array_reduce($rul_userresults, function ($carry, $item) {

            $carry[$item[0]] = $item[0];

            return $carry;
        });
    }

    public static function user_role_list()
    {
        global $wp_roles;

        $roles = array();

        foreach ($wp_roles->role_names as $key => $value) {
            $roles[$key] = $value;
        }

        return $roles;
    }

    public static function capability_list()
    {
        global $wp_roles;

        $caps = array();

        // Builds the array of level names by combing through each of the roles and listing their levels
        foreach ($wp_roles->roles as $wp_role) {
            if (isset($wp_role['capabilities']) && is_array($wp_role['capabilities'])) {
                $caps = array_merge($caps, array_keys($wp_role['capabilities']));
            }
        }

        $caps = array_unique($caps);

        // Sort the level names in alphabetical order
        sort($caps);

        // make array value key also
        $caps = array_combine($caps, $caps);

        return $caps;
    }

    /*
        This extra function is necessary to support the use case where someone was previously logged in
        Thanks to http://wordpress.org/support/topic/97314 for this function
    */
    public static function redirect_current_user_can($capability, $current_user)
    {
        global $wpdb;

        $roles        = get_option($wpdb->prefix . 'user_roles');
        $user_roles   = $current_user->{$wpdb->prefix . 'capabilities'};
        $user_roles   = array_keys($user_roles, true);
        $role         = $user_roles[0];
        $capabilities = $roles[$role]['capabilities'];

        if (in_array($capability, array_keys($capabilities, true))) {
            // check array keys of capabilities for match against requested capability
            return true;
        }

        return false;
    }

    /*
        A generic function to return the value mapped to a particular variable
    */
    public static function rul_get_variable($variable, $user)
    {
        $variable_value = apply_filters('rul_replace_variable', false, $variable, $user);

        if ( ! $variable_value) {
            // Return the permalink of the post ID
            if (0 === strpos($variable, 'postid-')) {
                $post_id   = str_replace('postid-', '', $variable);
                $permalink = get_permalink($post_id);
                if ($permalink) {
                    $variable_value = $permalink;
                }
            } else {
                switch ($variable) {
                    // Returns the current user's username (only use this if you know they're logged in)
                    case 'username':
                        $variable_value = rawurlencode($user->user_login);
                        break;
                    // Returns the current user's author slug aka nickname as used in URLs
                    // sanitize_title should not be required here since it was already done on insert
                    case 'userslug':
                    case 'user_slug':
                        $variable_value = $user->user_nicename;
                        break;
                    case 'siteurl':
                        $variable_value = network_site_url();
                        break;
                    case 'homeurl':
                    case 'website_url':
                        $variable_value = network_home_url();
                        break;
                    // Returns the login referrer in order to redirect back to the same page
                    // Note that this will not work if the referrer is the same as the login processor (otherwise in a standard setup you'd redirect to the login form)
                    case 'http_referer':
                        $referer        = wp_get_referer();
                        $variable_value = (false != $referer) ? $referer : '';
                        break;
                    default:
                        $variable_value = '';
                        break;
                }
            }
        }

        return $variable_value;
    }

    /**
     * Replaces the syntax [variable]variable_name[/variable] with whatever has been mapped to the variable_name in the rul_get_variable function
     */
    public static function rul_replace_variable($string, $user)
    {
        preg_match_all("/\[variable\](.*?)\[\/variable\]/i", $string, $out);

        preg_match_all("/\{\{(.*?)\}\}/is", $string, $out2);

        if ( ! empty($out[0])) {
            foreach ($out[0] as $instance => $full_match) {
                $replaced_variable = self::rul_get_variable($out[1][$instance], $user);
                $string            = str_replace($full_match, $replaced_variable, $string);
            }
        }

        if ( ! empty($out2[0])) {
            foreach ($out2[0] as $instance => $full_match) {
                $replaced_variable = self::rul_get_variable($out2[1][$instance], $user);
                $string            = str_replace($full_match, $replaced_variable, $string);
            }
        }

        return $string;
    }

    public static function rul_trigger_allowed_host($url)
    {
        $url_parsed = parse_url($url);
        if (isset($url_parsed['host'])) {
            $rul_allowed_hosts[] = $url_parsed['host'];
            add_filter('allowed_redirect_hosts', function ($hosts) use ($rul_allowed_hosts) {
                return array_merge($hosts, $rul_allowed_hosts);
            });
        }
    }

    /*
        Grabs settings from the database as of version 2.5.0 of this plugin.
        Defaults are defined here, but the settings values should be edited in the WordPress admin panel.
        If no setting is asked for, then it returns an array of all settings; otherwise it returns a specific setting
    */
    public static function redirectFunctionCollection_get_settings($setting = false)
    {
        $rul_settings = array();

        // Allow a POST or GET "redirect_to" variable to take precedence over settings within the plugin
        $rul_settings['rul_allow_post_redirect_override'] = '0';

        // Allow a POST or GET logout "redirect_to" variable to take precedence over settings within the plugin
        $rul_settings['rul_allow_post_redirect_override_logout'] = '0';

        $db_data = get_option('rul_settings', []);

        // Merge the default settings with the settings form the database
        // Limit the settings in case there are ones from the database that are old
        foreach ($rul_settings as $key => $value) {
            if (isset($db_data[$key])) {
                $rul_settings[$key] = $db_data[$key];
            }
        }

        if ( ! $setting) return $rul_settings;

        if ($setting && isset($rul_settings[$setting])) return $rul_settings[$setting];

        return false;
    }

    public static function login_redirect_logic_callback($redirect_to, $requested_redirect_to, $user)
    {
        global $wpdb;

        $rul_custom_redirect = apply_filters('rul_before_user', false, $redirect_to, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule for this user
        $rul_user = $wpdb->get_var('SELECT rul_url FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'user\' AND rul_value = \'' . $user->user_login . '\' LIMIT 1');

        if ( ! empty($rul_user)) {
            $url = self::rul_replace_variable($rul_user, $user);
            if ( ! empty($url)) return $url;
        }

        $rul_custom_redirect = apply_filters('rul_before_role', false, $redirect_to, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule that matches this user's role
        $rul_roles = $wpdb->get_results('SELECT rul_value, rul_url FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'role\' ORDER BY rul_order, rul_value', OBJECT);

        if ( ! empty($rul_roles)) {

            foreach ($rul_roles as $rul_role) {

                if ( ! empty($rul_role->rul_url) && isset($user->{$wpdb->prefix . 'capabilities'}[$rul_role->rul_value])) {
                    $url = self::rul_replace_variable($rul_role->rul_url, $user);
                    if ( ! empty($url)) return $url;
                }
            }
        }

        $rul_custom_redirect = apply_filters('rul_before_capability', false, $redirect_to, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule that matches this user's capability
        $rul_levels = $wpdb->get_results('SELECT rul_value, rul_url FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'level\' ORDER BY rul_order, rul_value', OBJECT);

        if ($rul_levels) {

            foreach ($rul_levels as $rul_level) {
                if ( ! empty($rul_level->rul_url) && self::redirect_current_user_can($rul_level->rul_value, $user)) {
                    $url = self::rul_replace_variable($rul_level->rul_url, $user);
                    if ( ! empty($url)) return $url;
                }
            }
        }

        $rul_custom_redirect = apply_filters('rul_before_fallback', false, $redirect_to, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        $rul_all = $wpdb->get_var('SELECT rul_url FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'all\' LIMIT 1');

        if ($rul_all) {

            $url = self::rul_replace_variable($rul_all, $user);

            if ( ! empty($url)) return $url;
        }

        return $redirect_to;
    }

    // Get the logout redirect URL according to defined rules
    // Functionality for user-, role-, and capability-specific redirect rules is available
    // Note that only the "all other users" redirect URL is currently implemented in the UI
    public static function logout_redirect_logic_callback($user, $requested_redirect_to)
    {
        global $wpdb;

        $rul_custom_redirect = apply_filters('rul_before_user_logout', false, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule for this user
        $rul_user = $wpdb->get_var('SELECT rul_url_logout FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'user\' AND rul_value = \'' . $user->user_login . '\' LIMIT 1');

        if ($rul_user) {
            $url = self::rul_replace_variable($rul_user, $user);
            if ( ! empty($url)) return $url;
        }

        $rul_custom_redirect = apply_filters('rul_before_role_logout', false, $requested_redirect_to, $user);

        if ( ! empty($rul_custom_redirect)) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule that matches this user's role
        $rul_roles = $wpdb->get_results('SELECT rul_value, rul_url_logout FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'role\' ORDER BY rul_order, rul_value', OBJECT);

        if ($rul_roles) {

            foreach ($rul_roles as $rul_role) {
                if ('' != $rul_role->rul_url_logout && isset($user->{$wpdb->prefix . 'capabilities'}[$rul_role->rul_value])) {
                    $url = self::rul_replace_variable($rul_role->rul_url_logout, $user);

                    if ( ! empty($url)) return $url;
                }
            }
        }

        $rul_custom_redirect = apply_filters('rul_before_capability_logout', false, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // Check for a redirect rule that matches this user's capability
        $rul_levels = $wpdb->get_results('SELECT rul_value, rul_url_logout FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'level\' ORDER BY rul_order, rul_value', OBJECT);

        if ($rul_levels) {
            foreach ($rul_levels as $rul_level) {
                if ('' != $rul_level->rul_url_logout && self::redirect_current_user_can($rul_level->rul_value, $user)) {
                    $url = self::rul_replace_variable($rul_level->rul_url_logout, $user);

                    if ( ! empty($url)) return $url;
                }
            }
        }

        $rul_custom_redirect = apply_filters('rul_before_fallback_logout', false, $requested_redirect_to, $user);

        if ($rul_custom_redirect) return self::rul_replace_variable($rul_custom_redirect, $user);

        // If none of the above matched, look for a rule to apply to all users
        $rul_all = $wpdb->get_var('SELECT rul_url_logout FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'all\' LIMIT 1');

        if ($rul_all) {

            $url = self::rul_replace_variable($rul_all, $user);

            if ( ! empty($url)) return $url;
        }

        return false;
    }
}