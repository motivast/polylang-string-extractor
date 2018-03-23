<?php
/**
 * Class to test WordPress code extractor.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/extractors
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractorTests\Extractors;

use PolylangStringExtractor\Extractors\WPCode;

/**
 * Class to test WordPress code extractor.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/extractors
 * @author     Motivast <support@motivast.com>
 */
class WPCode_Test extends \WP_UnitTestCase {

	/**
	 * Test if WPCode extractor return proper string for gettext
	 */
	function test_wpcode_extractor_for_gettext() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string translate' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string __' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string esc_attr__' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string esc_html__' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string _e' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string esc_attr_e' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test string esc_html_e' ] );
	}

	/**
	 * Test if WPCode extractor return proper string for gettext with context
	 */
	function test_wpcode_extractor_for_gettext_with_context() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context _x' . $x04 . 'Test string _x' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context _ex' . $x04 . 'Test string _ex' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context esc_attr_x' . $x04 . 'Test string esc_attr_x' ] );
		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context esc_html_x' . $x04 . 'Test string esc_html_x' ] );
	}

	/**
	 * Test if WPCode extractor return proper string for gettext plurals
	 */
	function test_wpcode_extractor_for_gettext_plurals() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test single string number 1 _n' ] );
		$this->assertEquals( 'Test plural string number 1 _n', $entries[ $x04 . 'Test single string number 1 _n' ]->getPlural() );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test single string number 2 _n' ] );
		$this->assertEquals( 'Test plural string number 2 _n', $entries[ $x04 . 'Test single string number 2 _n' ]->getPlural() );
	}

	/**
	 * Test if WPCode extractor return proper string for gettext plurals with context
	 */
	function test_wpcode_extractor_for_gettext_plurals_with_context() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context number 1 _nx' . $x04 . 'Test single string number 1 _nx' ] );
		$this->assertEquals( 'Test plural string number 1 _nx', $entries[ 'Test context number 1 _nx' . $x04 . 'Test single string number 1 _nx' ]->getPlural() );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context number 2 _nx' . $x04 . 'Test single string number 2 _nx' ] );
		$this->assertEquals( 'Test plural string number 2 _nx', $entries[ 'Test context number 2 _nx' . $x04 . 'Test single string number 2 _nx' ]->getPlural() );
	}

	/**
	 * Test if WPCode extractor return proper string for gettext noop plurals
	 */
	function test_wpcode_extractor_for_gettext_noop_plurals() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ $x04 . 'Test single string _n_noop' ] );
		$this->assertEquals( 'Test plural string _n_noop', $entries[ $x04 . 'Test single string _n_noop' ]->getPlural() );
	}

	/**
	 * Test if WPCode extractor return proper string for gettext noop plurals with context
	 */
	function test_wpcode_extractor_for_gettext_noop_plurals_with_context() {

		$path 		  = realpath( dirname( __FILE__ ) . '/../sample/page.php' );
		$translations = new \Gettext\Translations();

		WPCode::fromFile( $path, $translations );

		$entries = iterator_to_array( $translations->getIterator() );

		$x04 = chr( 04 );

		$this->assertInstanceOf( 'Gettext\Translation', $entries[ 'Test context _nx_noop' . $x04 . 'Test single string _nx_noop' ] );
		$this->assertEquals( 'Test plural string _nx_noop', $entries[ 'Test context _nx_noop' . $x04 . 'Test single string _nx_noop' ]->getPlural() );
	}
}
