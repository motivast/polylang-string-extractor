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

use Gettext\Translations;

use PolylangStringExtractor\Utils\WPFunctionsScanner;

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
class WPFunctionsScanner_Test extends TestCase {

	/**
	 * Test string
	 *
	 * @var string
	 */
	private $string = 'String';

	/**
	 * Test plural string
	 *
	 * @var string
	 */
	private $string_plural = 'String plural';

	/**
	 * Test textdomain
	 *
	 * @var string
	 */
	private $textdomain = 'textdomain';

	/**
	 * Test context
	 *
	 * @var string
	 */
	private $context = 'context';

	/**
	 * Glue
	 *
	 * @var string
	 */
	private $glue;

	/**
	 * Set up tests
	 */
	public function setUp() {

		$this->glue = chr( 04 );
	}

	/**
	 * START wp_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_translate
	 */
	function test_wp_function_scanner_will_handle_wp_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php __("%s", "%s");';
		$code = sprintf( $code, $this->string, $this->textdomain );

		$options = $this->get_options_for_wp_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php __("%s", "%s");';
		$code = sprintf( $code, $this->string, 'faketextdomain' );

		$options = $this->get_options_for_wp_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php __("%s");';
		$code = sprintf( $code, $this->string );

		$options = $this->get_options_for_wp_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_translate
	 */

	/**
	 * START wp_n_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_n_translate
	 */
	function test_wp_function_scanner_will_handle_wp_n_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n("%s", "%s", "%d", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1, $this->textdomain );

		$options = $this->get_options_for_wp_n_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_n_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n("%s", "%s", "%d", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1, 'faketextdomain' );

		$options = $this->get_options_for_wp_n_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_n_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n("%s", "%s", "%d");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1 );

		$options = $this->get_options_for_wp_n_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_n_translate
	 */

	/**
	 * START wp_x_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_x_translate
	 */
	function test_wp_function_scanner_will_handle_wp_x_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _x("%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->context, $this->textdomain );

		$options = $this->get_options_for_wp_x_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->context . $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_x_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _x("%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->context, 'faketextdomain' );

		$options = $this->get_options_for_wp_x_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_x_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _x("%s", "%s");';
		$code = sprintf( $code, $this->string, $this->context );

		$options = $this->get_options_for_wp_x_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_x_translate
	 */

	/**
	 * START wp_nx_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_nx_translate
	 */
	function test_wp_function_scanner_will_handle_wp_nx_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx("%s", "%s", %d, "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1, $this->context, $this->textdomain );

		$options = $this->get_options_for_wp_nx_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->context . $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_nx_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx("%s", "%s", %d, "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1, $this->context, 'faketextdomain' );

		$options = $this->get_options_for_wp_nx_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_nx_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx("%s", "%s", %d, "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 1, $this->context );

		$options = $this->get_options_for_wp_nx_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_nx_translate
	 */

	/**
	 * START wp_n_noop_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_n_noop_translate
	 */
	function test_wp_function_scanner_will_handle_wp_n_noop_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n_noop("%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, $this->textdomain );

		$options = $this->get_options_for_wp_n_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_n_noop_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n_noop("%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, 'faketextdomain' );

		$options = $this->get_options_for_wp_n_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_n_noop_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _n_noop("%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural );

		$options = $this->get_options_for_wp_n_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_n_noop_translate
	 */

	/**
	 * START wp_nx_noop_translate
	 */

	/**
	 * Test if wp function scanner will handle properly wp_nx_noop_translate
	 */
	function test_wp_function_scanner_will_handle_wp_nx_noop_translate() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx_noop("%s", "%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, $this->context, $this->textdomain );

		$options = $this->get_options_for_wp_nx_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$translation = $translations[ $this->context . $this->glue . $this->string ];

		$this->assertEquals( 'String', $translation->getOriginal() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * wrong textdomain.
	 */
	function test_wp_function_scanner_will_not_handle_wp_nx_noop_translate_if_wrong_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx_noop("%s", "%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, $this->context, 'faketextdomain' );

		$options = $this->get_options_for_wp_nx_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will not handle translations if there is
	 * no textdomain provided.
	 */
	function test_wp_function_scanner_will_not_handle_wp_nx_noop_translate_if_no_textdomain() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php _nx_noop("%s", "%s", "%s");';
		$code = sprintf( $code, $this->string, $this->string_plural, $this->context );

		$options = $this->get_options_for_wp_nx_noop_translate();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * END wp_nx_noop_translate
	 */

	/**
	 * Test if wp function scanner will not handle fake function.
	 */
	function test_wp_function_scanner_will_not_handle_fake_function() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php __fake("%s", "%s");';
		$code = sprintf( $code, $this->string, $this->textdomain );

		$options = $this->get_options_for_fake_function();

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );

		$this->assertEquals( 0, $translations->count() );
	}

	/**
	 * Test if wp function scanner will throw exception if there is no
	 * assigned case for function.
	 */
	function test_wp_function_scanner_will_not_handle_fake_index_function() {

		$translations = new Translations();
		$translations->setDomain( $this->textdomain );

		$code = '<?php fake("%s", "%s");';
		$code = sprintf( $code, $this->string, $this->textdomain );

		$options = $this->get_options_for_fake_function();

		$this->expectException( '\Exception' );
		$this->expectExceptionMessage( 'Not valid function fake' );

		$wp_function_scanner = new WPFunctionsScanner( $code );
		$wp_function_scanner->saveGettextFunctions( $translations, $options );
	}

	/**
	 * Get common options for wp_translate
	 */
	private function get_options_for_wp_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'__' => 'wp_translate',
			),
		);
	}

	/**
	 * Get common options for wp_n_translate
	 */
	private function get_options_for_wp_n_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'_n' => 'wp_n_translate',
			),
		);
	}

	/**
	 * Get common options for wp_n_translate
	 */
	private function get_options_for_wp_x_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'_x' => 'wp_x_translate',
			),
		);
	}

	/**
	 * Get common options for wp_nx_translate
	 */
	private function get_options_for_wp_nx_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'_nx' => 'wp_nx_translate',
			),
		);
	}

	/**
	 * Get common options for wp_n_noop_translate
	 */
	private function get_options_for_wp_n_noop_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'_n_noop' => 'wp_n_noop_translate',
			),
		);
	}

	/**
	 * Get common options for wp_nx_noop_translate
	 */
	private function get_options_for_wp_nx_noop_translate() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'_nx_noop' => 'wp_nx_noop_translate',
			),
		);
	}

	/**
	 * Get common options for fake function
	 */
	private function get_options_for_fake_function() {

		return array(
			'constants' => array(),
			'file' => 'test.php',
			'functions' => array(
				'fake' => 'fake',
			),
		);
	}
}
