<?php
/**
 * Class provided for test polylang class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractorTests;

use WP_Mock\Tools\TestCase;

use Mockery;
use Mockery\MockInterface;

use PolylangStringExtractor\Polylang;

/**
 * Class provided for test polylang class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests
 * @author     Motivast <support@motivast.com>
 */
class Polylang_Test extends TestCase {

	/**
	 * Array of wp mock functions
	 *
	 * @var MockInterface
	 */
	public static $functions;

	/**
	 * Setup test
	 */
	public function setUp() {
		\WP_Mock::setUp();
	}

	/**
	 * Terminate test
	 */
	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * Test if polylang class will add hooks
	 */
	function test_polylang_will_add_hooks() {

		$init = $this->mock_init();
		$init['loader'] = Mockery::mock( '\PolylangStringExtractor\Loader', [ $init ] );

		$polylang = new Polylang( $init );

		/**
		 * Expect that loader will call `add_action` method with
		 * `pll_get_strings` hook and `get_strings` method.
		 */
		$init['loader']
			->shouldReceive( 'add_filter' )
			->with( 'pll_get_strings', $polylang, 'get_strings' );

		/**
		 * Expect that loader will call `add_action` method with
		 * `pll_get_strings` hook and `get_strings` method.
		 */
		$init['loader']
			->shouldReceive( 'add_action' )
			->with( 'pll_language_defined', $polylang, 'load_strings_translations', 6 );

		/**
		 * Expect that loader will call `add_action` method with
		 * `pll_get_strings` hook and `get_strings` method.
		 */
		$init['loader']
			->shouldReceive( 'add_action' )
			->with( 'change_locale', $polylang, 'load_strings_translations', 11 );

		$polylang->run();
	}

	/**
	 * Test if polylang get_strings method will return proper results
	 */
	function test_polylang_get_strings_will_return_results() {

		$init = $this->mock_init();

		$pll_strings = $this->get_pll_strings();
		$extractor_strings = $this->get_extractor_strings();

		/**
		 * Mock get_option function
		 */
		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'args' => array( 'polylang_string_extractor_strings', array() ),
			'return' => $extractor_strings,
		) );

		$polylang = new Polylang( $init );
		$strings = $polylang->get_strings( $pll_strings );

		$this->assertEquals( $strings, array_merge( $pll_strings, $extractor_strings ) );
	}

	/**
	 * Test if load_strings_translations method will populate $l10n with proper
	 * translations
	 */
	function test_load_strings_translations_will_populate_l10n() {

		/**
		 * MO mock class
		 */
		require_once dirname( __FILE__ ) . '/sample/mock/class-mo.php';

		global $l10n;

		$init = $this->mock_init();

		/**
		 * Get and convert polylang and extractor strings to WordPress translations
		 */
		$pll_strings = $this->get_pll_strings();
		$extractor_strings = $this->get_extractor_strings();

		$pll_translations = $this->pll_translations_to_mo( $pll_strings );
		$extractor_translations = $this->pll_translations_to_mo( $extractor_strings );

		/**
		 * Mock global $l10n variable
		 */
		$l10n['pll_string'] = new \MO(); // @codingStandardsIgnoreLine Ignore this for tests.
		$l10n['pll_string']->entries = array_merge( $pll_translations, $extractor_translations );

		/**
		 * Mock get_option function
		 */
		\WP_Mock::wpFunction( 'get_option', array(
			'times' => 1,
			'args' => array( 'polylang_string_extractor_strings', array() ),
			'return' => $this->get_extractor_strings(),
		) );

		$polylang = new Polylang( $init );
		$polylang->load_strings_translations();

		$expected_pll_strings_mo = new \MO();
		$expected_pll_strings_mo->add_entry( 'Pll test string 1' );
		$expected_pll_strings_mo->add_entry( 'Pll test string 2' );
		$expected_pll_strings_mo->add_entry( 'Extractor test string 1' );
		$expected_pll_strings_mo->add_entry( 'Extractor test string 2' );

		$expected_extractor_mo = new \MO();
		$expected_extractor_mo->add_entry( 'Extractor test string 1' );
		$expected_extractor_mo->add_entry( 'Extractor test string 2' );

		$expected_l10n = array(
			'pll_string' => $expected_pll_strings_mo,
			'extractor' => $expected_extractor_mo,
		);

		$this->assertEquals( $expected_l10n, $l10n );
	}

	/**
	 * Test if load_strings_translations method will do nothing if there is no
	 * pll_string index in $l10n global
	 */
	function test_load_strings_translations_will_do_nothing_when_empty_l10n() {

		global $l10n;

		$l10n = array();  // @codingStandardsIgnoreLine Ignore this for tests.

		$init = $this->mock_init();

		$polylang = new Polylang( $init );
		$polylang->load_strings_translations();

		$this->assertEquals( array(), $l10n );
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
	 * Sample polylang strings
	 *
	 * @retrun array
	 */
	private function get_pll_strings() {

		$pll_strings = array();

		$test_pll_string_1 = 'Pll test string 1';
		$test_pll_string_2 = 'Pll test string 2';

		$test_pll_context = 'polylang';

		$pll_strings[ md5( $test_pll_string_1 ) ] = array(
			'name' => '',
			'string' => $test_pll_string_1,
			'context' => $test_pll_context,
			'multiline' => false,
		);

		$pll_strings[ md5( $test_pll_string_2 ) ] = array(
			'name' => '',
			'string' => $test_pll_string_2,
			'context' => $test_pll_context,
			'multiline' => false,
		);

		return $pll_strings;
	}

	/**
	 * Sample extractor strings
	 *
	 * @retrun array
	 */
	private function get_extractor_strings() {

		$extractor_strings = array();

		$test_extractor_string_1 = 'Extractor test string 1';
		$test_extractor_string_2 = 'Extractor test string 2';

		$test_extractor_context = 'extractor';

		$extractor_strings[ md5( $test_extractor_string_1 ) ] = array(
			'name' => '',
			'string' => $test_extractor_string_1,
			'context' => $test_extractor_context,
			'multiline' => false,
		);

		$extractor_strings[ md5( $test_extractor_string_2 ) ] = array(
			'name' => '',
			'string' => $test_extractor_string_2,
			'context' => $test_extractor_context,
			'multiline' => false,
		);

		return $extractor_strings;
	}

	/**
	 * Convert polylang translations structure to WordPress mo translations
	 *
	 * @param array $translations Array of translations to convert.
	 *
	 * @return array
	 */
	private function pll_translations_to_mo( $translations ) {

		$mo = array();

		foreach ( $translations as $translation ) {
			$mo[ $translation['string'] ] = $translation['string'];
		}

		return $mo;
	}
}
