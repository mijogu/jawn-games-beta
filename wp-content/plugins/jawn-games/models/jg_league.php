<?php
if ( ! function_exists('init_leagues') ) {

	// Register Custom Post Type
	function init_leagues() {
	
		$labels = array(
			'name'                  => _x( 'Leagues', 'Post Type General Name', 'jawn_games' ),
			'singular_name'         => _x( 'League', 'Post Type Singular Name', 'jawn_games' ),
			'menu_name'             => __( 'Leagues', 'jawn_games' ),
			'name_admin_bar'        => __( 'League', 'jawn_games' ),
			'archives'              => __( 'Item Archives', 'jawn_games' ),
			'attributes'            => __( 'Item Attributes', 'jawn_games' ),
			'parent_item_colon'     => __( 'Parent Item:', 'jawn_games' ),
			'all_items'             => __( 'All Items', 'jawn_games' ),
			'add_new_item'          => __( 'Add New Item', 'jawn_games' ),
			'add_new'               => __( 'Add New', 'jawn_games' ),
			'new_item'              => __( 'New Item', 'jawn_games' ),
			'edit_item'             => __( 'Edit Item', 'jawn_games' ),
			'update_item'           => __( 'Update Item', 'jawn_games' ),
			'view_item'             => __( 'View Item', 'jawn_games' ),
			'view_items'            => __( 'View Items', 'jawn_games' ),
			'search_items'          => __( 'Search Item', 'jawn_games' ),
			'not_found'             => __( 'Not found', 'jawn_games' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'jawn_games' ),
			'featured_image'        => __( 'Featured Image', 'jawn_games' ),
			'set_featured_image'    => __( 'Set featured image', 'jawn_games' ),
			'remove_featured_image' => __( 'Remove featured image', 'jawn_games' ),
			'use_featured_image'    => __( 'Use as featured image', 'jawn_games' ),
			'insert_into_item'      => __( 'Insert into item', 'jawn_games' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'jawn_games' ),
			'items_list'            => __( 'Items list', 'jawn_games' ),
			'items_list_navigation' => __( 'Items list navigation', 'jawn_games' ),
			'filter_items_list'     => __( 'Filter items list', 'jawn_games' ),
		);
		$rewrite = array(
			'slug'                  => 'leagues',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'League', 'jawn_games' ),
			'description'           => __( 'It is a league.', 'jawn_games' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'custom-fields' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'leagues',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
			'rest_base'             => 'leagues',
		);
		register_post_type( 'jg_league', $args );
	
	}
	add_action( 'init', 'init_leagues', 0 );

	
	}
