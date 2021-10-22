<?php 
/**
 * Registers the `jgleague` post type.
 */
function jgleague_init() {
	register_post_type( 'jgleague', array(
		'labels'                => array(
			'name'                  => __( 'Leagues', 'jawn_games' ),
			'singular_name'         => __( 'League', 'jawn_games' ),
			'all_items'             => __( 'All Leagues', 'jawn_games' ),
			'archives'              => __( 'League Archives', 'jawn_games' ),
			'attributes'            => __( 'League Attributes', 'jawn_games' ),
			'insert_into_item'      => __( 'Insert into League', 'jawn_games' ),
			'uploaded_to_this_item' => __( 'Uploaded to this League', 'jawn_games' ),
			'featured_image'        => _x( 'Featured Image', 'jgleague', 'jawn_games' ),
			'set_featured_image'    => _x( 'Set featured image', 'jgleague', 'jawn_games' ),
			'remove_featured_image' => _x( 'Remove featured image', 'jgleague', 'jawn_games' ),
			'use_featured_image'    => _x( 'Use as featured image', 'jgleague', 'jawn_games' ),
			'filter_items_list'     => __( 'Filter Leagues list', 'jawn_games' ),
			'items_list_navigation' => __( 'Leagues list navigation', 'jawn_games' ),
			'items_list'            => __( 'Leagues list', 'jawn_games' ),
			'new_item'              => __( 'New League', 'jawn_games' ),
			'add_new'               => __( 'Add New', 'jawn_games' ),
			'add_new_item'          => __( 'Add New League', 'jawn_games' ),
			'edit_item'             => __( 'Edit League', 'jawn_games' ),
			'view_item'             => __( 'View League', 'jawn_games' ),
			'view_items'            => __( 'View Leagues', 'jawn_games' ),
			'search_items'          => __( 'Search Leagues', 'jawn_games' ),
			'not_found'             => __( 'No Leagues found', 'jawn_games' ),
			'not_found_in_trash'    => __( 'No Leagues found in trash', 'jawn_games' ),
			'parent_item_colon'     => __( 'Parent League:', 'jawn_games' ),
			'menu_name'             => __( 'Leagues', 'jawn_games' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-thumbs-up',
		'show_in_rest'          => true,
		'rest_base'             => 'jgleague',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'jgleague_init' );

/**
 * Sets the post updated messages for the `jgleague` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `jgleague` post type.
 */
function jgleague_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['jgleague'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'League updated. <a target="_blank" href="%s">View League</a>', 'jawn_games' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'jawn_games' ),
		3  => __( 'Custom field deleted.', 'jawn_games' ),
		4  => __( 'League updated.', 'jawn_games' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'League restored to revision from %s', 'jawn_games' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'League published. <a href="%s">View League</a>', 'jawn_games' ), esc_url( $permalink ) ),
		7  => __( 'League saved.', 'jawn_games' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'League submitted. <a target="_blank" href="%s">Preview League</a>', 'jawn_games' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'League scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview League</a>', 'jawn_games' ),
		date_i18n( __( 'M j, Y @ G:i', 'jawn_games' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'League draft updated. <a target="_blank" href="%s">Preview League</a>', 'jawn_games' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'jgleague_updated_messages' );
