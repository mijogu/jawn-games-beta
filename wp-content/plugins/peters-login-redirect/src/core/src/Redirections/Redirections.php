<?php

namespace LoginWP\Core\Redirections;

use LoginWP\Core\Helpers;

class Redirections
{
    public function __construct()
    {
        add_filter('login_redirect', [__CLASS__, 'login_redirect_callback'], 999999999, 3);
        add_filter('registration_redirect', [__CLASS__, 'registration_redirect_callback'], 10, 2);
        add_filter('logout_redirect', [__CLASS__, 'logout_redirect'], 999999999, 3);
    }

    public static function login_redirect_callback($redirect_to, $requested_redirect_to, $user)
    {
        $post_redirect_to_override = Helpers::redirectFunctionCollection_get_settings('rul_allow_post_redirect_override');

        if ( ! isset($user->user_login)) return $redirect_to;

        $requested_redirect_to = ! empty($requested_redirect_to) ? $requested_redirect_to : loginwp_var($_REQUEST, 'redirect_to', '');
        $requested_redirect_to = wp_validate_redirect($requested_redirect_to);

        if ('1' == $post_redirect_to_override && ! empty($requested_redirect_to) && $requested_redirect_to != admin_url()) {

            do_action('loginwp_after_login_redirect', $requested_redirect_to, $user);

            return $requested_redirect_to;
        }

        $rul_url = Helpers::login_redirect_logic_callback($redirect_to, $requested_redirect_to, $user);

        if ( ! empty($rul_url)) {

            Helpers::rul_trigger_allowed_host($rul_url);

            do_action('loginwp_after_login_redirect', $rul_url, $user);

            return $rul_url;
        }

        do_action('loginwp_after_login_redirect', $redirect_to, $user);

        return $redirect_to;
    }

    public static function registration_redirect_callback($registration_redirect)
    {
        /*
            Some limitations:
                - Not yet possible: Username-customized page, since the WordPress hook is implemented pre-registration, not post-registration
        */
        $requested_redirect_to = ! empty($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';

        if ( ! empty($requested_redirect_to)) return wp_validate_redirect($requested_redirect_to);

        global $wpdb;

        $rul_url = $wpdb->get_var('SELECT rul_url FROM ' . PTR_LOGINWP_DB_TABLE . ' WHERE rul_type = \'register\' LIMIT 1');

        if ( ! empty($rul_url)) {

            $rul_url = Helpers::rul_replace_variable($rul_url, false);

            Helpers::rul_trigger_allowed_host($rul_url);

            return $rul_url;
        }

        return $registration_redirect;
    }

    public static function logout_redirect($redirect_to, $requested_redirect_to, $current_user)
    {
        $post_redirect_override_logout = Helpers::redirectFunctionCollection_get_settings('rul_allow_post_redirect_override_logout');

        $requested_redirect_to = ! empty($requested_redirect_to) ? $requested_redirect_to : loginwp_var($_REQUEST, 'redirect_to', '');

        if ('1' == $post_redirect_override_logout && ! empty($requested_redirect_to)) {
            return $requested_redirect_to;
        }

        $rul_url = Helpers::logout_redirect_logic_callback($current_user, $requested_redirect_to);

        if ( ! empty($rul_url)) {

            Helpers::rul_trigger_allowed_host($rul_url);

            return $rul_url;
        }

        return $redirect_to;
    }

    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}