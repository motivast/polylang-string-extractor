<?php
/**
 * Class to test core container class.
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

use PolylangStringExtractor\Init;

/**
 * Class to test core container class.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/core
 * @author     Motivast <support@motivast.com>
 */
class Container_Test extends TestCase {

	/**
	 * Test if we can save to container
	 */
	function test_saving_to_container() {

		$container = new Init();

		$container['key_int'] = 1;
		$container['key_string'] = 'String';
		$container['key_object'] = new \stdClass();

		$this->assertEquals( 1, $container['key_int'] );
		$this->assertEquals( 'String', $container['key_string'] );
		$this->assertEquals( new \stdClass(), $container['key_object'] );
	}

	/**
	 * Test if we can check if key exist in container
	 */
	function test_existence_in_container() {

		$container = new Init();

		$container['key_int'] = 1;
		$container['key_string'] = 'String';
		$container['key_object'] = new \stdClass();

		$this->assertEquals( true, isset( $container['key_int'] ) );
		$this->assertEquals( true, isset( $container['key_string'] ) );
		$this->assertEquals( true, isset( $container['key_object'] ) );

		$this->assertEquals( false, isset( $container['key_fake'] ) );
	}

	/**
	 * Test if we can delete key
	 */
	function test_deleting_from_container() {

		$container = new Init();

		$container['key_int'] = 1;
		$container['key_string'] = 'String';
		$container['key_object'] = new \stdClass();

		unset( $container['key_int'] );
		unset( $container['key_string'] );
		unset( $container['key_object'] );

		$this->assertEquals( false, isset( $container['key_int'] ) );
		$this->assertEquals( false, isset( $container['key_string'] ) );
		$this->assertEquals( false, isset( $container['key_object'] ) );
	}
}
