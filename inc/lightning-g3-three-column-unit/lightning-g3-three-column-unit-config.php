<?php
/**
 * Lightning 3 Column Unit Configuration
 *
 * @package Lightning Customize Unit
 */

if ( 'lightning' === get_template() || 'lightning-pro' === get_template() ) {
	if ( ! class_exists( 'Lightning_G3_Three_Column_Unit_Admin' ) ) {
		require plugin_dir_path( __FILE__ ) . 'package/class-lightning-g3-three-column-unit-admin.php';
	}

	if ( ! class_exists( 'Lightning_G3_Three_Column_Unit_Condition' ) ) {
		require plugin_dir_path( __FILE__ ) . 'package/class-lightning-g3-three-column-unit-condition.php';
	}

	if ( ! class_exists( 'Lightning_G3_Three_Column_Unit_Control' ) ) {
		require plugin_dir_path( __FILE__ ) . 'package/class-lightning-g3-three-column-unit-control.php';
	}

	if ( ! class_exists( 'Lightning_G3_Three_Column_Unit_Widget_Area' ) ) {
		require plugin_dir_path( __FILE__ ) . 'package/class-lightning-g3-three-column-unit-widget-area.php';
	}

	if ( ! class_exists( 'Lightning_G3_Three_Column_Unit_Style' ) ) {
		require plugin_dir_path( __FILE__ ) . 'package/class-lightning-g3-three-column-unit-style.php';
	}
}
