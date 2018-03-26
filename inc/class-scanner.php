<?php
/**
 * Class provided for setup symfony forms
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor;

use Gettext\Translations;

use PolylangStringExtractor\Extractors\WPCode;

/**
 * Class provided for setup symfony forms
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class Scanner {

	/**
	 * Theme container.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
	}

	/**
	 * Scan files
	 *
	 * Scan all files in current theme and activated plugins for translations.
	 */
	public function scan() {

		$theme_strings   = $this->scan_current_theme();
		$plugins_strings = $this->scan_active_plugins();

		$strings = array_merge( $theme_strings, $plugins_strings );

		$option_name = sprintf( '%s_strings', $this->plugin['id'] );

		update_option( $option_name , $strings );
	}

	/**
	 * Scan current theme
	 *
	 * Scan all php files in current theme for translations.
	 *
	 * @return array Array of strings to translate
	 */
	private function scan_current_theme() {

		$theme = wp_get_theme();

		if ( ! ( $theme instanceof \WP_Theme ) ) {
			return array();
		}

		$textdomain = $theme->get( 'TextDomain' );

		if ( ! $textdomain ) {
			return array();
		}

		$theme_dir = get_template_directory();

		$php_files = $this->get_php_files( $theme_dir );

		$translations = new Translations();
		$translations->setDomain( $textdomain );

		foreach ( $php_files as $file ) {
			WPCode::fromFile( $file, $translations );
		}

		return $this->format_to_polylang( $translations );
	}

	/**
	 * Scan activated plugins
	 *
	 * Scan all php files in activated plugins for translations.
	 *
	 * @return array Array of strings to translate
	 */
	private function scan_active_plugins() {

		$all_translations = array();

		$plugins_dir = WP_PLUGIN_DIR;
		$active_plugins = get_option( 'active_plugins' );

		foreach ( $active_plugins as $plugin ) {

			$plugin_path = $plugins_dir . DIRECTORY_SEPARATOR . $plugin;
			$plugin_info = get_plugin_data( $plugin_path );

			if ( isset( $plugin_info['TextDomain'] ) && ! empty( $plugin_info['TextDomain'] ) ) {

				$php_files = $this->get_php_files( plugin_dir_path( $plugin_path ) );

				$translations = new Translations();
				$translations->setDomain( esc_html( $plugin_info['TextDomain'] ) );

				foreach ( $php_files as $file ) {
					WPCode::fromFile( $file, $translations );
				}

				$all_translations = array_merge( $all_translations, $this->format_to_polylang( $translations ) );
			}
		}

		return $all_translations;
	}

	/**
	 * Get array of php files from path
	 *
	 * @param string $path Path to looking for.
	 *
	 * @return array Array of php files
	 */
	private function get_php_files( $path ) {

		$flattened = array();

		// http://php.net/manual/en/class.recursivedirectoryiterator.php#97228.
		$directory = new \RecursiveDirectoryIterator( $path );
		$iterator = new \RecursiveIteratorIterator( $directory );

		$regex = new \RegexIterator( $iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH );

		/**
		 * Flatten multidimensional array from iterator
		 */
		array_walk_recursive( iterator_to_array( $regex ), function( $file ) use ( &$flattened ) {
			$flattened[] = $file;
		} );

		return $flattened;
	}

	/**
	 * Format translations
	 *
	 * Format translations object to polylang translation array
	 *
	 * @param Translations $translations Gettext translations object.
	 *
	 * @return array Array of translations in polylang format
	 */
	private function format_to_polylang( $translations ) {

		$strings = array();

		foreach ( $translations as $translation ) {

			$string = $translation->getOriginal();
			$domain = $translations->getDomain();

			$strings[ md5( $string ) ] = array(
				'name' => '',
				'string' => $string,

				/**
				 * Polylang use context value as group name in administration.
				 * This should be obviously called domain or textdomain.
				 */
				'context' => $domain,
				'multiline' => false,
			);
		}

		return $strings;
	}
}
