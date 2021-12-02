<?php
/**
 * Plugin Name: Lightning G3 Three Column Unit
 * Plugin URI: https://github.com/drill-lancer/lightning-g3-three-column-unit
 * Description: Lightning G3 Three Column Unit
 * Version: 1.0.0
 * Author:  DRILL LANCER
 * Author URI: https://www.drill-lancer.com
 * Text Domain: lightning-g3-three-column-unit
 * License: GPL 2.0 or Later
 * Domain Path: /languages
 *
 * @package Lightning Customize Unit
 */

defined( 'ABSPATH' ) || exit;


if ( 'lightning' === get_template() || 'lightning-pro' === get_template() ) {
	$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
	define( 'LTCU_VERSION', $data['version'] );

	define( 'LTCU_PATH', plugin_dir_path( __FILE__ ) );
	load_plugin_textdomain( 'lightning-g3-three-column-unit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	require_once LTCU_PATH . '/inc/lightning-g3-three-column-unit/lightning-g3-three-column-unit-config.php';
} else {
	return;
}


