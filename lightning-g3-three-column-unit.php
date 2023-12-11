<?php
/**
 * Plugin Name: Lightning G3 Three Column Unit
 * Plugin URI: https://github.com/drill-lancer/lightning-g3-three-column-unit
 * Description: Lightning G3 Three Column Unit
 * Author:  DRILL LANCER
 * Author URI: https://www.drill-lancer.com
 * Text Domain: lightning-g3-three-column-unit
 * License: GPL 2.0 or Later
 * Domain Path: /languages
 * Requires at least: 5.7
 * Requires PHP: 7.3
 * Version: 1.0.0
 *
 * @package Lightning G3 Three Column Unit
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
use Lightning_G3_Three_Column_Unit\Admin;
use Lightning_G3_Three_Column_Unit\Condition;
use Lightning_G3_Three_Column_Unit\Control;
use Lightning_G3_Three_Column_Unit\Style;
use Lightning_G3_Three_Column_Unit\Widget_Area;

defined( 'ABSPATH' ) || exit;

// Composer のファイルを読み込み ( composer install --no-dev )
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// アップデーターの設定
$my_update_checker = PucFactory::buildUpdateChecker(
	'https://github.com/drill-lancer/lightning-g3-three-column-unit',
	__FILE__,
	'lightning-g3-three-column-unit'
);
$my_update_checker->getVcsApi()->enableReleaseAssets();


if ( 'lightning' === get_template() && 'g3' === get_option( 'lightning_theme_generation' ) ) {
	$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
	define( 'LTCU_VERSION', $data['version'] );
	define( 'LTCU_URL', plugin_dir_url( __FILE__ ) );
	define( 'LTCU_PATH', plugin_dir_path( __FILE__ ) );
	load_plugin_textdomain( 'lightning-g3-three-column-unit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	$modules_path = plugin_dir_path( __FILE__ ) . 'modules/';
	require_once $modules_path . 'class-admin.php';
	require_once $modules_path . 'class-condition.php';
	require_once $modules_path . 'class-control.php';
	require_once $modules_path . 'class-style.php';
	require_once $modules_path . 'class-widget-area.php';
	new Admin();
	new Condition();
	new Control();
	new Style();
	new Widget_Area();
}
