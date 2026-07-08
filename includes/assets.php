<?php
/**
 * Asset loading.
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a cache-busting version string for a plugin asset.
 *
 * @param string $relative_path Asset path relative to the plugin root.
 * @return string
 */
function pfld_asset_version( $relative_path ) {
	$path = PFLD_PLUGIN_DIR . ltrim( $relative_path, '/' );

	if ( file_exists( $path ) ) {
		return PFLD_VERSION . '.' . filemtime( $path );
	}

	return PFLD_VERSION;
}

/**
 * Enqueue assets needed by the directory block.
 */
function pfld_enqueue_research_lab_directory_assets() {
	wp_enqueue_style(
		'pfld-research-lab-directory',
		PFLD_PLUGIN_URL . 'assets/css/research-lab-directory.css',
		array(),
		pfld_asset_version( 'assets/css/research-lab-directory.css' )
	);

	if ( is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'pfld-research-lab-directory',
		PFLD_PLUGIN_URL . 'assets/js/research-lab-directory.js',
		array(),
		pfld_asset_version( 'assets/js/research-lab-directory.js' ),
		true
	);
}

/**
 * Enqueue directory block assets early when the current editor/front-end view needs them.
 */
function pfld_maybe_enqueue_research_lab_directory_assets() {
	if ( is_admin() ) {
		pfld_enqueue_research_lab_directory_assets();
		return;
	}

	if ( function_exists( 'has_block' ) && has_block( 'acf/research-lab-directory' ) ) {
		pfld_enqueue_research_lab_directory_assets();
	}
}
add_action( 'enqueue_block_assets', 'pfld_maybe_enqueue_research_lab_directory_assets' );
