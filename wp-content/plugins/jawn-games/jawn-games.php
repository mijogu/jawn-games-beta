<?php
/**
 * Plugin Name:       Jawn Games API
 * Plugin URI:        https://jawngames.com
 * Description:       Handle the backend of the Jawn Games app.
 * Version:           0.1
 * Author:            Darn Good
 * Author URI:        https://darngood.io/
 * Text Domain:       jawn-games
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once (plugin_dir_path( __FILE__ ) . 'models/jg_sport.php');
require_once (plugin_dir_path( __FILE__ ) . 'models/jg_league.php');
require_once (plugin_dir_path( __FILE__ ) . 'models/jg_game.php');

// TODO throw error if ACF not installed / activated

if ( class_exists('ACF') ) {
    // Save ACF fields automatically
    add_filter( 'acf/settings/save_json', function() {
        return dirname(__FILE__) . '/acf-json';
    });

    // Load ACF fields automatically
    add_filter( 'acf/settings/load_json', function( $paths ) {
        $paths[] = dirname( __FILE__ ) . '/acf-json';
        return $paths;
    });
}


// Used with the WP Rest User plugin.
// Callback after user registers.
add_action('wp_rest_user_user_register', 'jg_user_registered');
function jg_user_registered($user) {
        $user->remove_role( 'subscriber' );
        $user->add_role('author');
}

add_filter('jwt_auth_token_before_dispatch', 'jg_add_user_role_response', 10, 2);
function jg_add_user_role_response($data, $user){
    // refactor the response into token & user
    $acf = get_fields("user_$user->ID");
    // $user['acf'] = $acf;
    $data = array(
        'token' => $data,
        'user' => $user,
        'acf' => $acf
    );
    // $data['user'] = $user;
    return $data;
}



// Register shortcodes
// function jg_shortcodes_init(){
//     add_shortcode( 'jawn_new_game', 'jg_new_game_handler' );
// }
// add_action('init', 'jg_shortcodes_init');

// function jg_new_game_handler($atts, $content, $tag) {
//     return '<p>New game form.</p>';
// }


