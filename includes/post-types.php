<?php
/**
 * Custom post types and taxonomies.
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Research Lab post type.
 */
function pfld_register_research_lab_post_type() {
	$labels = array(
		'name'                  => _x( 'Research Labs', 'Post type general name', 'pitchfork-lab-directory' ),
		'singular_name'         => _x( 'Research Lab', 'Post type singular name', 'pitchfork-lab-directory' ),
		'menu_name'             => _x( 'Research Labs', 'Admin menu text', 'pitchfork-lab-directory' ),
		'name_admin_bar'        => _x( 'Research Lab', 'Add new on toolbar', 'pitchfork-lab-directory' ),
		'add_new'               => __( 'Add New', 'pitchfork-lab-directory' ),
		'add_new_item'          => __( 'Add New Research Lab', 'pitchfork-lab-directory' ),
		'new_item'              => __( 'New Research Lab', 'pitchfork-lab-directory' ),
		'edit_item'             => __( 'Edit Research Lab', 'pitchfork-lab-directory' ),
		'view_item'             => __( 'View Research Lab', 'pitchfork-lab-directory' ),
		'all_items'             => __( 'All Research Labs', 'pitchfork-lab-directory' ),
		'search_items'          => __( 'Search Research Labs', 'pitchfork-lab-directory' ),
		'not_found'             => __( 'No research labs found.', 'pitchfork-lab-directory' ),
		'not_found_in_trash'    => __( 'No research labs found in Trash.', 'pitchfork-lab-directory' ),
		'featured_image'        => __( 'Lab Image', 'pitchfork-lab-directory' ),
		'set_featured_image'    => __( 'Set lab image', 'pitchfork-lab-directory' ),
		'remove_featured_image' => __( 'Remove lab image', 'pitchfork-lab-directory' ),
		'use_featured_image'    => __( 'Use as lab image', 'pitchfork-lab-directory' ),
	);

	$args = array(
		'labels'              => $labels,
		'description'         => __( 'Research labs used by the Lab Directory block.', 'pitchfork-lab-directory' ),
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-groups',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'query_var'           => false,
		'rewrite'             => false,
		'show_in_rest'        => true,
	);

	register_post_type( 'research-lab', $args );
}
add_action( 'init', 'pfld_register_research_lab_post_type' );

/**
 * Register Research Area taxonomy.
 */
function pfld_register_research_area_taxonomy() {
	$labels = array(
		'name'              => _x( 'Research Areas', 'Taxonomy general name', 'pitchfork-lab-directory' ),
		'singular_name'     => _x( 'Research Area', 'Taxonomy singular name', 'pitchfork-lab-directory' ),
		'search_items'      => __( 'Search Research Areas', 'pitchfork-lab-directory' ),
		'all_items'         => __( 'All Research Areas', 'pitchfork-lab-directory' ),
		'parent_item'       => __( 'Parent Research Area', 'pitchfork-lab-directory' ),
		'parent_item_colon' => __( 'Parent Research Area:', 'pitchfork-lab-directory' ),
		'edit_item'         => __( 'Edit Research Area', 'pitchfork-lab-directory' ),
		'update_item'       => __( 'Update Research Area', 'pitchfork-lab-directory' ),
		'add_new_item'      => __( 'Add New Research Area', 'pitchfork-lab-directory' ),
		'new_item_name'     => __( 'New Research Area Name', 'pitchfork-lab-directory' ),
		'menu_name'         => __( 'Research Areas', 'pitchfork-lab-directory' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_in_rest'      => true,
		'query_var'         => false,
		'rewrite'           => false,
	);

	register_taxonomy( 'research-area', array( 'research-lab' ), $args );
}
add_action( 'init', 'pfld_register_research_area_taxonomy' );
