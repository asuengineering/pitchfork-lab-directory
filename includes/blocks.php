<?php
/**
 * ACF block registration.
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a Pitchfork Lab Directory block category.
 *
 * @param array                 $categories Existing block categories.
 * @param WP_Block_Editor_Context|null $editor_context Editor context.
 * @return array
 */
function pfld_block_categories( $categories, $editor_context = null ) {
	foreach ( $categories as $category ) {
		if ( isset( $category['slug'] ) && 'pitchfork-lab-directory' === $category['slug'] ) {
			return $categories;
		}
	}

	$category = array(
		'slug'  => 'pitchfork-lab-directory',
		'title' => __( 'Pitchfork Lab Directory', 'pitchfork-lab-directory' ),
	);

	array_unshift( $categories, $category );

	return $categories;
}
add_filter( 'block_categories_all', 'pfld_block_categories', 10, 2 );

/**
 * Register ACF blocks.
 */
function pfld_register_acf_blocks() {
	register_block_type( PFLD_PLUGIN_DIR . 'acf-block-templates/research-lab-directory' );
}
add_action( 'acf/init', 'pfld_register_acf_blocks' );
