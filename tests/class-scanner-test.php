<?php
/**
 * Class provided for test scanner class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/extractors
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractorTests;

use Mockery;

use WP_Mock;
use WP_Mock\Tools\TestCase;

use PolylangStringExtractor\Scanner;

/**
 * Class provided for test scanner class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/extractors
 * @author     Motivast <support@motivast.com>
 */
class Scanner_Test extends TestCase {

	/**
	 * Setup mocks
	 */
	public function setUp() {
		WP_Mock::setUp();
	}

	/**
	 * Terminate mocks
	 */
	public function tearDown() {
		WP_Mock::tearDown();
	}

	/**
	 * Test if scanner class will scan directories for php files
	 */
	function test_scanner_will_scan_directories() {

		/**
		 * WP_Theme mock class
		 */
		require_once dirname( __FILE__ ) . '/sample/mock/class-wp-theme.php';

		/**
		 * WP_PLUGIN_DIR mock contant
		 */
		define( 'WP_PLUGIN_DIR', dirname( __FILE__ ) . '/sample/plugins' );

		/**
		 * Array of translation string from theme and plugins
		 */
		$strings = array();
		$test_string_domain = 'test';

		/**
		 * Plugin container mock
		 */
		$init = $this->mock_init();

		/**
		 * Mock WP_Theme object and wp_get_theme function
		 */
		$theme = new \WP_Theme();
		$theme_full_path = dirname( __FILE__ ) . '/sample/themes/test';

		\WP_Mock::wpFunction( 'wp_get_theme', array(
			'times' => 1,
			'return' => $theme,
		) );

		\WP_Mock::wpFunction( 'get_template_directory', array(
			'times' => 1,
			'return' => $theme_full_path,
		) );

		/**
		 * After scanning theme directory string array should have these values
		 */
		$test_theme_string_1 = 'Theme test string __';
		$test_theme_string_2 = 'Theme subdir test string __';

		$strings[ md5( $test_theme_string_1 ) ] = array(
			'name' => '',
			'string' => $test_theme_string_1,
			'context' => $test_string_domain,
			'multiline' => false,
		);

		$strings[ md5( $test_theme_string_2 ) ] = array(
			'name' => '',
			'string' => $test_theme_string_2,
			'context' => $test_string_domain,
			'multiline' => false,
		);

		/**
		 * Mock get_options function
		 */
		$plugin = 'test';
		$plugin_path = 'test/test.php';
		$plugin_full_path = WP_PLUGIN_DIR . '/' . $plugin_path;

		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'return' => array( $plugin_path ),
		) );

		/**
		 * Mock get_plugin_data function
		 */
		\WP_Mock::wpFunction( 'get_plugin_data', array(
			'times' => 1,
			'args' => $plugin_full_path,
			'return' => array(
				'TextDomain' => 'test',
			),
		) );

		/**
		 * Mock plugin_dir_path function
		 */
		\WP_Mock::wpFunction( 'plugin_dir_path', array(
			'times' => 1,
			'args' => $plugin_full_path,
			'return' => rtrim( dirname( $plugin_full_path ), '/\\' ) . '/',
		) );

		/**
		 * Mock esc_html function
		 */
		\WP_Mock::wpFunction( 'esc_html', array(
			'times' => 1,
			'args' => $plugin,
			'return' => $plugin,
		) );

		/**
		 * Mock update_option function
		 */
		$test_plugins_string_1 = 'Plugin test string __';
		$test_plugins_string_2 = 'Plugin subdir test string __';

		$strings[ md5( $test_plugins_string_1 ) ] = array(
			'name' => '',
			'string' => $test_plugins_string_1,
			'context' => $test_string_domain,
			'multiline' => false,
		);

		$strings[ md5( $test_plugins_string_2 ) ] = array(
			'name' => '',
			'string' => $test_plugins_string_2,
			'context' => $test_string_domain,
			'multiline' => false,
		);

		/**
		 * If everything go well we should call update_options with these
		 * arguments. Since scanner class do not have any public method to
		 * retrieve strings we can not make assertion.
		 */
		$this->mock_update_option( $init['strings_option_name'], array_reverse( $strings ) );

		$scanner = new Scanner( $init );
		$scanner->scan();
	}

	/**
	 * Test if scanner class will not scan current theme directories if
	 * wp_get_theme function will not return WP_Theme class instance.
	 */
	function test_scanner_will_not_scan_directories_if_wp_get_theme_do_not_return_wp_theme_class() {

		/**
		 * WP_Theme mock class
		 */
		require_once dirname( __FILE__ ) . '/sample/mock/class-wp-theme.php';

		/**
		 * Plugin container mock
		 */
		$init = $this->mock_init();

		/**
		 * Mock WP_Theme object and wp_get_theme function
		 */
		\WP_Mock::wpFunction( 'wp_get_theme', array(
			'times' => 1,
			'return' => null,
		) );

		/**
		 * Mock get active plugins
		 */
		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'return' => array(),
		) );

		/**
		 * If everything go well we should call update_options with these
		 * arguments. Since scanner class do not have any public method to
		 * retrieve strings we can not make assertion.
		 */
		$this->mock_update_option( $init['strings_option_name'], array() );

		$scanner = new Scanner( $init );
		$scanner->scan();
	}

	/**
	 * Test if scanner class will not scan current theme directories if
	 * wp_get_theme function will return WP_Theme class without textdomain.
	 */
	function test_scanner_will_not_scan_directories_if_wp_get_theme_will_return_theme_without_textdomain() {

		/**
		 * WP_Theme mock class
		 */
		require_once dirname( __FILE__ ) . '/sample/mock/class-wp-theme.php';

		/**
		 * Plugin container mock
		 */
		$init = $this->mock_init();

		/**
		 * Mock WP_Theme object and wp_get_theme function
		 */
		$theme = new \WP_Theme( false );

		\WP_Mock::wpFunction( 'wp_get_theme', array(
			'times' => 1,
			'return' => $theme,
		) );

		/**
		 * Mock get active plugins
		 */
		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'return' => array(),
		) );

		/**
		 * If everything go well we should call update_options with these
		 * arguments. Since scanner class do not have any public method to
		 * retrieve strings we can not make assertion.
		 */
		$this->mock_update_option( $init['strings_option_name'], array() );

		$scanner = new Scanner( $init );
		$scanner->scan();
	}

	/**
	 * Test if scanner class will not scan active plugin directories if
	 * get_plugin_data function will return plugin info array without textdomain.
	 */
	function test_scanner_will_not_scan_directories_if_get_plugin_data_will_return_plugin_without_textdomain() {

		/**
		 * Plugin container mock
		 */
		$init = $this->mock_init();

		/**
		 * Mock WP_Theme object and wp_get_theme function
		 */
		\WP_Mock::wpFunction( 'wp_get_theme', array(
			'times' => 1,
			'return' => false,
		) );

		/**
		 * Mock get_options function
		 */
		$plugin_path = 'test/test.php';
		$plugin_full_path = WP_PLUGIN_DIR . '/' . $plugin_path;

		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'return' => array( $plugin_path ),
		) );

		/**
		 * Mock get_plugin_data function
		 */
		\WP_Mock::wpFunction( 'get_plugin_data', array(
			'times' => 1,
			'args' => $plugin_full_path,
			'return' => array(), // Return plugin data without textdomain.
		) );

		/**
		 * If everything go well we should call update_options with these
		 * arguments. Since scanner class do not have any public method to
		 * retrieve strings we can not make assertion.
		 */
		$this->mock_update_option( $init['strings_option_name'], array() );

		$scanner = new Scanner( $init );
		$scanner->scan();
	}

	/**
	 * Mock Init class
	 *
	 * @return array
	 */
	private function mock_init() {

		return array(
			'strings_option_name' => 'polylang_string_extractor_strings',
		);
	}

	/**
	 * Mock update_option function
	 *
	 * @param string $option_name  Option name.
	 * @param mixed  $option_value Option value.
	 */
	private function mock_update_option( $option_name, $option_value ) {

		\WP_Mock::wpFunction( 'update_option', array(
			'times' => 1,
			'args' => array( $option_name, $option_value ),
			'return' => true,
		) );
	}
}
