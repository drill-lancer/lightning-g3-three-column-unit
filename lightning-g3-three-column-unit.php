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
 * @package Lightning G3 Three Column Unit
 */

defined( 'ABSPATH' ) || exit;

// Composer のファイルを読み込み ( composer install --no-dev )
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// アップデーターの設定
$my_update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/drill-lancer/lightning-g3-three-column-unit',
	__FILE__,
	'lightning-g3-three-column-unit'
);
$my_update_checker->setBranch('master');
// $my_update_checker->getVcsApi()->enableReleaseAssets();


if ( 'lightning' === get_template() && 'g3' === get_option( 'lightning_theme_generation' ) ) {
	$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
	define( 'LTCU_VERSION', $data['version'] );

	define( 'LTCU_PATH', plugin_dir_path( __FILE__ ) );
	load_plugin_textdomain( 'lightning-g3-three-column-unit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	require_once LTCU_PATH . '/inc/lightning-g3-three-column-unit/config.php';
} else {
	return;
}


