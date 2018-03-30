<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this theme
 * so that it is ready for translation.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor\Core;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this themes
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class I18n {

	/**
	 * Plugin container.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object $plugin PolylangStringExtractor Plugin container
	 */
	private $plugin;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    object $plugin PolylangStringExtractor Plugin container.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Load the theme text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'polylang_string_extractor',
			false,
			str_replace( '_', '-', $this->plugin['id'] ) . '/languages'
		);
	}
}
