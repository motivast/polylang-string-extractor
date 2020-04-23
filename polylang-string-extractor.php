<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://motivast.com
 * @since             1.0.0
 * @package           Polylang_String_Extractor
 *
 * @wordpress-plugin
 * Plugin Name:       Polylang String Extractor
 * Plugin URI:        polylang-string-extractor
 * Description:       Polylang String Extractor is a plugin provided for extract translatable strings from WordPress functions to Polylang.
 * Version:           1.0.0
 * Author:            Motivast
 * Author URI:        http://motivast.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       polylang_string_extractor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'POLYLANG_STRING_EXTRACTOR_VERSION' ) )
	define( 'POLYLANG_STRING_EXTRACTOR_VERSION', '1.0.0' );

/**
 * Load autoloader to not bother to requiring classes.
 */
if( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
}

require_once plugin_dir_path( __FILE__ ) . 'inc/autoloader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function polylang_string_extractor() {

	static $plugin;

	if ( isset( $plugin ) && $plugin instanceof \PolylangStringExtractor\Core\Init ) {
		return $plugin;
	}

	$plugin = new \PolylangStringExtractor\Core\Init();
	$plugin->load();
	$plugin->run();

}

polylang_string_extractor();
