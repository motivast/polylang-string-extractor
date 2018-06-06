<?php
/**
 * Class to test core init class.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/core
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractorTests\Core;

use PHPUnit\Framework\TestCase;

use Mockery;

use PolylangStringExtractor\Core\Init;

/**
 * Class to test core init class.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/core
 * @author     Motivast <support@motivast.com>
 */
class Init_Test extends TestCase {

	/**
	 * Test if init is settings variables
	 */
	public function test_init_is_settings_variables() {

		$init = new Init();

		$this->assertEquals( 'polylang_string_extractor', $init['id'] );
		$this->assertEquals( 'Polylang String Extractor', $init['name'] );
		$this->assertEquals( 'polylang_string_extractor_strings', $init['strings_option_name'] );
		$this->assertEquals( '1.0.0', $init['version'] );
	}

	/**
	 * Test if init is loading dependencies
	 *
	 * @runInSeparateProcess
	 *
	 * Isolate in separate process because we are already mocking
	 * load_plugin_textdomain in other tests and we do not want break them.
	 */
	public function test_init_is_loading_dependencies() {

		$init = new Init();

		$this->mock_load_plugin_textdomain();

		$init->load();

		$this->assertInstanceOf( '\PolylangStringExtractor\Core\i18n', $init['i18n'] );
		$this->assertInstanceOf( '\PolylangStringExtractor\Core\Loader', $init['loader'] );

		$this->assertInstanceOf( '\PolylangStringExtractor\Activation', $init['activation'] );
		$this->assertInstanceOf( '\PolylangStringExtractor\Scanner', $init['scanner'] );
		$this->assertInstanceOf( '\PolylangStringExtractor\Polylang', $init['polylang'] );
	}

	/**
	 * Test if init is calling run on dependencies
	 *
	 * @runInSeparateProcess
	 *
	 * Isolate in separate process because we are already mocking
	 * load_plugin_textdomain in other tests and we do not want break them.
	 */
	public function test_init_is_calling_run_on_dependencies() {

		$init = new Init();

		$this->mock_load_plugin_textdomain();

		$init->load();

		$init['loader'] = Mockery::mock( '\PolylangStringExtractor\Core\Loader' )
			->shouldReceive( 'run' )
			->once()
			->getMock();

		$init['activation'] = Mockery::mock( '\PolylangStringExtractor\Activation' )
			->shouldReceive( 'run' )
			->once()
			->getMock();

		$init['polylang'] = Mockery::mock( '\PolylangStringExtractor\Polylang' )
			->shouldReceive( 'run' )
			->once()
			->getMock();

		$init->run();
	}

	/**
	 * Mock load_plugin_textdomain which is called during set_locale method
	 */
	public function mock_load_plugin_textdomain() {

		/**
		 * Mock load_plugin_textdomain function
		 */
		\WP_Mock::userFunction(
			'load_plugin_textdomain', array(
				'times' => 1,
				'args'  => array(
					'polylang_string_extractor',
					false,
					'polylang-string-extractor/languages',
				),
			)
		);
	}
}
