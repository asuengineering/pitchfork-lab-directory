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
 * Ensure a Pitchfork Blocks category is available without duplicating it.
 *
 * @param array                        $categories Existing block categories.
 * @param WP_Block_Editor_Context|null $editor_context Editor context.
 * @return array
 */
function pfld_ensure_pitchfork_blocks_category( $categories, $editor_context = null ) {
	foreach ( $categories as $category ) {
		if ( isset( $category['slug'] ) && 'pitchfork-blocks' === $category['slug'] ) {
			return $categories;
		}
	}

	$categories[] = array(
		'slug'  => 'pitchfork-blocks',
		'title' => __( 'Pitchfork Blocks', 'pitchfork-lab-directory' ),
	);

	return $categories;
}
add_filter( 'block_categories_all', 'pfld_ensure_pitchfork_blocks_category', 10, 2 );

/**
 * Register ACF blocks.
 */
function pfld_register_acf_blocks() {
	register_block_type( PFLD_PLUGIN_DIR . 'acf-block-templates/research-lab-directory' );
}
add_action( 'acf/init', 'pfld_register_acf_blocks' );
