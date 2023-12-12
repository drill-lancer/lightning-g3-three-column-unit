<?php
/**
 * Conditions of Lightning Three Column Unit Admin
 *
 * @package Lightning Three Column Unit
 */

namespace Lightning_G3_Three_Column_Unit;

/**
 * Conditions of Lightning Three Column Unit Admin
 */
class Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'customize_register', array( __CLASS__, 'resister_customize' ), 11 );
	}

	/**
	 * Default Option.
	 */
	public static function default_option() {
		$args = array(
			'main_width'                => '680',
			'side_width'                => '320',
			'column_margin'             => '40',
			'outer_container_margin'    => '40',
			'three-to-one-via-two'      => 'disable',
			'main_sidebar_control'      => 'wrap-down',
			'sub_sidebar_control'       => 'hide',
			'2col_sub_sidebar_position' => 'above-footer',
			'narrow_window_description' => 'hide',
		);
		return $args;
	}

	/**
	 * Register Customize
	 */
	public static function resister_customize() {

		global $wp_customize;

		$default_option = self::default_option();

		// Add Section.
		$wp_customize->add_section(
			'lightning_g3_three_column_unit_setting',
			array(
				'title'    => __( 'Lightning Three Column Unit', 'lightning-g3-three-column-unit' ),
				'priority' => 999,
			)
		);

		// Remove Customize.
		$wp_customize->remove_setting( 'ltg_sidebar_fix_setting_title' );
		$wp_customize->remove_control( 'ltg_sidebar_fix_setting_title' );
		$wp_customize->remove_setting( 'lightning_theme_options[sidebar_fix]' );
		$wp_customize->remove_control( 'lightning_theme_options[sidebar_fix]' );

		// Main Culumn Width.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[main_width]',
			array(
				'default'           => $default_option['main_width'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[main_width]',
			array(
				'label'    => __( 'Main Column Width Value ( px )', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[main_width]',
				'type'     => 'text',
			)
		);

		// Side Culumn Width.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[side_width]',
			array(
				'default'           => $default_option['side_width'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[side_width]',
			array(
				'label'    => __( 'Side Column Width ( px )', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[side_width]',
				'type'     => 'text',
			)
		);

		// Margin of Between Columns.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[column_margin]',
			array(
				'default'           => $default_option['column_margin'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[column_margin]',
			array(
				'label'    => __( 'Margin of Between Columns ( px )', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[column_margin]',
				'type'     => 'text',
			)
		);

		// Minumum Margin Sum for Out of Container.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[outer_container_margin]',
			array(
				'default'           => $default_option['outer_container_margin'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[outer_container_margin]',
			array(
				'label'    => __( 'Minumum Margin Sum for Out of Container ( px )', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[outer_container_margin]',
				'type'     => 'text',
			)
		);

		// When Three Column Layout is Choosed and Narrowing Window Size, Make Two Column Layout.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[three-to-one-via-two]',
			array(
				'default'           => $default_option['three-to-one-via-two'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[three-to-one-via-two]',
			array(
				'label'    => __( 'When Three Column Layout is Choosed and Narrowing Window Size, Make Two Column Layout', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[three-to-one-via-two]',
				'type'     => 'select',
				'choices'  => array(
					'disable' => __( 'Disable', 'lightning-g3-three-column-unit' ),
					'enable'  => __( 'Enable', 'lightning-g3-three-column-unit' ),
				),
			)
		);

		// Main Sidebar Control.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[main_sidebar_control]',
			array(
				'default'           => $default_option['main_sidebar_control'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[main_sidebar_control]',
			array(
				'label'    => __( 'Main Sidebar Control', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[main_sidebar_control]',
				'type'     => 'select',
				'choices'  => array(
					'wrap-down' => __( 'Wrap Down', 'lightning-g3-three-column-unit' ),
					'hide'      => __( 'Hide', 'lightning-g3-three-column-unit' ),
				),
			)
		);

		// Sub Sidebar Control.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[sub_sidebar_control]',
			array(
				'default'           => $default_option['sub_sidebar_control'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[sub_sidebar_control]',
			array(
				'label'    => __( 'Sub Sidebar Control', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[sub_sidebar_control]',
				'type'     => 'select',
				'choices'  => array(
					'wrap-down' => __( 'Wrap Down', 'lightning-g3-three-column-unit' ),
					'hide'      => __( 'Hide', 'lightning-g3-three-column-unit' ),
				),
			)
		);

		// Sub Sidebar Control.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]',
			array(
				'default'           => $default_option['2col_sub_sidebar_position'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]',
			array(
				'label'    => __( 'Sub Sidebar Position When Selected Layout is 3 Column Layout and Current Layout is 2 Column Layout', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]',
				'type'     => 'select',
				'choices'  => array(
					'above-footer'       => __( 'Above Footer', 'lightning-g3-three-column-unit' ),
					'under-main-sidebar' => __( 'Under Main Sidebar', 'lightning-g3-three-column-unit' ),
				),
			)
		);

		// Narrow Window Discription.
		$wp_customize->add_setting(
			'lightning_g3_three_column_unit_options[narrow_window_description]',
			array(
				'default'           => $default_option['narrow_window_description'],
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'lightning_g3_three_column_unit_options[narrow_window_description]',
			array(
				'label'    => __( 'Header Top Description Control on Narrow Window', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[narrow_window_description]',
				'type'     => 'select',
				'choices'  => array(
					'display' => __( 'Display', 'lightning-g3-three-column-unit' ),
					'hide'    => __( 'Hide', 'lightning-g3-three-column-unit' ),
				),
			)
		);
	}


}
