<?php
/**
 * Advanced Custom Fields registrations.
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register local ACF field groups.
 */
function pfld_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_pfld_research_lab_details',
			'title'                 => __( 'Research Lab Details', 'pitchfork-lab-directory' ),
			'fields'                => array(
				array(
					'key'           => 'field_pfld_external_url',
					'label'         => __( 'External URL', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_external_url',
					'type'          => 'url',
					'instructions'  => __( 'Primary destination for this lab when rendered in the directory block.', 'pitchfork-lab-directory' ),
					'required'      => 0,
					'default_value' => '',
					'placeholder'   => 'https://',
				),
				array(
					'key'           => 'field_pfld_recruiting_students',
					'label'         => __( 'Recruiting Students', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_recruiting_students',
					'type'          => 'true_false',
					'instructions'  => __( 'Use as a filtering facet in the directory block.', 'pitchfork-lab-directory' ),
					'required'      => 0,
					'default_value' => 0,
					'ui'            => 1,
					'ui_on_text'    => __( 'Yes', 'pitchfork-lab-directory' ),
					'ui_off_text'   => __( 'No', 'pitchfork-lab-directory' ),
				),
				array(
					'key'          => 'field_pfld_pi_asurite',
					'label'        => __( 'Principal Investigator ASURITE ID', 'pitchfork-lab-directory' ),
					'name'         => 'pfld_pi_asurite',
					'type'         => 'text',
					'instructions' => __( 'Stored for a future Pitchfork People / ASU Search integration.', 'pitchfork-lab-directory' ),
					'required'     => 0,
					'maxlength'    => 64,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'research-lab',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_pfld_research_lab_directory_block',
			'title'                 => __( 'Research Lab Directory Block', 'pitchfork-lab-directory' ),
			'fields'                => array(
				array(
					'key'           => 'field_pfld_show_research_area_filters',
					'label'         => __( 'Show Research Area filters', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_show_research_area_filters',
					'type'          => 'true_false',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'           => 'field_pfld_show_recruiting_filter',
					'label'         => __( 'Show Recruiting Students filter', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_show_recruiting_filter',
					'type'          => 'true_false',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'           => 'field_pfld_show_search',
					'label'         => __( 'Show Search field', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_show_search',
					'type'          => 'true_false',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'           => 'field_pfld_default_sort',
					'label'         => __( 'Default sort order', 'pitchfork-lab-directory' ),
					'name'          => 'pfld_default_sort',
					'type'          => 'select',
					'instructions'  => __( 'Additional sorting options can be added in a future release.', 'pitchfork-lab-directory' ),
					'choices'       => array(
						'alpha_asc' => __( 'Alphabetical by title', 'pitchfork-lab-directory' ),
					),
					'default_value' => 'alpha_asc',
					'allow_null'    => 0,
					'multiple'      => 0,
					'ui'            => 0,
					'return_format' => 'value',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/research-lab-directory',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'description'           => __( 'Controls for the Research Lab Directory listing block.', 'pitchfork-lab-directory' ),
			'show_in_rest'          => 0,
		)
	);
}
add_action( 'acf/init', 'pfld_register_acf_field_groups' );
