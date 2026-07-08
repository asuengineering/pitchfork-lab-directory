<?php
/**
 * Plugin Name: Pitchfork Lab Directory
 * Description: Research Lab content type and filterable ACF directory block for Pitchfork sites.
 * Version: 0.1.0
 * Author: ASU Engineering
 * Text Domain: pitchfork-lab-directory
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PFLD_VERSION', '0.1.0' );
define( 'PFLD_PLUGIN_FILE', __FILE__ );
define( 'PFLD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PFLD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once PFLD_PLUGIN_DIR . 'includes/post-types.php';
require_once PFLD_PLUGIN_DIR . 'includes/acf-fields.php';
require_once PFLD_PLUGIN_DIR . 'includes/assets.php';
require_once PFLD_PLUGIN_DIR . 'includes/blocks.php';

/**
 * Flush rewrite rules when the plugin is activated.
 */
function pfld_activate() {
	pfld_register_research_lab_post_type();
	pfld_register_research_area_taxonomy();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pfld_activate' );

/**
 * Flush rewrite rules when the plugin is deactivated.
 */
function pfld_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pfld_deactivate' );
