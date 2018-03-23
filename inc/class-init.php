<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 */

namespace PolylangStringExtractor;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class Init extends Container {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @var      string $id The string used to uniquely identify this theme.
		 */
		$this['id'] = 'polylang_string_extractor';

		/**
		 * The unique name of this plugin.
		 *
		 * @since    1.0.0
		 * @var      string $name The string used to display theme name.
		 */
		$this['name'] = 'Polylang string extractor';

		/**
		 * Option name for translations
		 *
		 * @since    1.0.0
		 * @var      string $name The string used for option name.
		 */
		$this['strings_option_name'] = sprintf( '%s_strings', $this['id'] );

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @var      string    $version    The current version of the plugin.
		 */
		$this['version'] = '1.0.0';

		/**
		 * Load translations before anything. Some plugins like acf do not attach
		 * into any hook so translations does not has a chance to work.
		 */
		$this->set_locale();

		$this->load_core_dependencies();
		$this->load_dependencies();

	}

	/**
	 * Define the locale for this theme for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$this['i18n'] = new I18n( $this );
		$this['i18n']->load_theme_textdomain();

	}

	/**
	 * Load the required core dependencies for this theme.
	 *
	 * Include the following files that make up the theme:
	 *
	 * - Loader. Orchestrates the hooks of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_core_dependencies() {

		$this['loader'] = new Loader( $this );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - YourClass. What this class is doing?
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this['activation'] = new Activation( $this );
		$this['scanner']    = new Scanner( $this );
		$this['polylang']   = new Polylang( $this );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this['loader']->run();
	}
}
