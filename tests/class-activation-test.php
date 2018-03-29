<?php
/**
 * Class provided for test activation class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractorTests;

use PHPUnit\Framework\TestCase;

use Mockery;

use PolylangStringExtractor\Activation;

/**
 * Class provided for test activation class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests
 * @author     Motivast <support@motivast.com>
 */
class Activation_Test extends TestCase {

	/**
	 * Test if activation class will add hook for plugin activation
	 */
	function test_activation_will_add_activation_hook() {

		$init = $this->mock_init();
		$init['loader'] = Mockery::mock( '\PolylangStringExtractor\Loader', [ $init ] );

		$activation = new Activation( $init );

		/**
		 * Expect that loader will call `add_action` method with
		 * `activate_...` hook and callback method.
		 */
		$plugin_slug 	 = str_replace( '_', '-', $init['id'] );
		$plugin_basename = sprintf( '%s/%s.php', $plugin_slug, $plugin_slug );
		$hook            = sprintf( 'activate_%s', $plugin_basename );

		$init['loader']
			->shouldReceive( 'add_action' )
			->with( $hook, $activation, 'activate' );

		$activation->run();
	}

	/**
	 * Test if activation class will call scan on activate call
	 */
	function test_activation_will_call_scan_on_activate_call() {

		$init = $this->mock_init();
		$init['scanner'] = Mockery::mock( '\PolylangStringExtractor\Scanner', [ $init ] );

		$activation = new Activation( $init );

		/**
		 * Expect that scanner will call `scan` method with
		 * when `activate` method will be called.
		 */
		$init['scanner']->shouldReceive( 'scan' );

		$activation->activate();
	}

	/**
	 * Mock Init class
	 *
	 * @return array
	 */
	private function mock_init() {

		return array(
			'id' => 'polylang_string_extractor',
		);
	}
}
