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
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'custmoze_script' ) );
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
	 * Custmoze Script
	 */
	public static function custmoze_script() {
		$options = get_option( 'lightning_g3_three_column_unit_options' );
		$script = <<<EOT
		const lightning_g3_three_column_unit_options = {
			main_width: {$options['main_width']},
			side_width: {$options['side_width']},
			column_margin: {$options['column_margin']},
			outer_container_margin: {$options['outer_container_margin']},
			three_to_one_via_two: '{$options['three-to-one-via-two']}',
			main_sidebar_control: '{$options['main_sidebar_control']}',
			sub_sidebar_control: '{$options['sub_sidebar_control']}',
			2col_sub_sidebar_position: '{$options['2col_sub_sidebar_position']}',
			narrow_window_description: '{$options['narrow_window_description']}',
		};
		wp.customize.bind( 'ready', function() {
			wp.customize( 'lightning_g3_three_column_unit_options[main_width]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.main_width = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[side_width]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.side_width = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[column_margin]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.column_margin = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[outer_container_margin]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.outer_container_margin = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[three-to-one-via-two]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.three_to_one_via_two = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[main_sidebar_control]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.main_sidebar_control = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[sub_sidebar_control]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.sub_sidebar_control = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options.2col_sub_sidebar_position = to;
				} );
			} );
			wp.customize( 'lightning_g3_three_column_unit_options[narrow_window_description]', function( value ) {
				value.bind( function( to ) {
					lightning_g3_three_column_unit_options,narrow_window_description = to;
				} );
			} );
		} );

		wp.customize.bind( 'change', function() {
			if ( lightning_g3_three_column_unit_options.three_to_one_via_two === 'enable' ) {
				if ( lightning_g3_three_column_unit_options.sub_sidebar_control === 'wrap-down' ) {
					wp.customize.control( 'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]' ).activate();
				} else {
					wp.customize.control( 'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]' ).deactivate();
				}
			}
		} );
		EOT;

		wp_add_inline_script( 'customize-controls', $script );
	}

	/**
	 * Register Customize
	 */
	public static function resister_customize() {

		global $wp_customize;

		$default_option = self::default_option();
		$current_option = get_option( 'lightning_g3_three_column_unit_options' );
		require_once plugin_dir_path( __FILE__ ) . 'class-vk-custom-html-control.php';

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


		$wp_customize->add_setting(
			'width-setting',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new \VK_Custom_Html_Control(
				$wp_customize,
				'width-setting',
				array(
					'label'            => __( 'Width Setting', 'lightning-g3-three-column-unit' ),
					'section'          => 'lightning_g3_three_column_unit_setting',
					'type'             => 'text',
					'custom_title_sub' => '',
					'custom_html'      => '',
				)
			)
		);

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

		$wp_customize->add_setting(
			'sidebar-setting',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new \VK_Custom_Html_Control(
				$wp_customize,
				'sidebar-setting',
				array(
					'label'            => __( 'Sidebar Setting', 'lightning-g3-three-column-unit' ),
					'section'          => 'lightning_g3_three_column_unit_setting',
					'type'             => 'text',
					'custom_title_sub' => '',
					'custom_html'      => '',
				)
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

		$wp_customize->add_setting(
			'three-column-setting',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new \VK_Custom_Html_Control(
				$wp_customize,
				'three-column-setting',
				array(
					'label'            => __( 'Three Column Layout Setting', 'lightning-g3-three-column-unit' ),
					'section'          => 'lightning_g3_three_column_unit_setting',
					'type'             => 'text',
					'custom_title_sub' => '',
					'custom_html'      => '',
				)
			)
		);


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
				'label'    => __( 'Make Two Column Layout on Marrow Window', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[three-to-one-via-two]',
				'type'     => 'select',
				'choices'  => array(
					'disable' => __( 'Disable', 'lightning-g3-three-column-unit' ),
					'enable'  => __( 'Enable', 'lightning-g3-three-column-unit' ),
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
				'label'    => __( 'Wrapping position of sub sidebar', 'lightning-g3-three-column-unit' ),
				'section'  => 'lightning_g3_three_column_unit_setting',
				'settings' => 'lightning_g3_three_column_unit_options[2col_sub_sidebar_position]',
				'type'     => 'select',
				'choices'  => array(
					'above-footer'       => __( 'Above Footer', 'lightning-g3-three-column-unit' ),
					'under-main-sidebar' => __( 'Under Main Sidebar', 'lightning-g3-three-column-unit' ),
				),
			)
		);

		$wp_customize->add_setting(
			'header-top-setting',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new \VK_Custom_Html_Control(
				$wp_customize,
				'header-top-setting',
				array(
					'label'            => __( 'Header Top Setting', 'lightning-g3-three-column-unit' ),
					'section'          => 'lightning_g3_three_column_unit_setting',
					'type'             => 'text',
					'custom_title_sub' => '',
					'custom_html'      => '',
				)
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
				'label'    => __( 'Display Header Top Description on Narrow Window', 'lightning-g3-three-column-unit' ),
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
