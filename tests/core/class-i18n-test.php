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

use PolylangStringExtractor\Core\I18n;

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
class I18n_Test extends TestCase {

	/**
	 * Test if we can save to container
	 */
	function test_i18n_is_calling_method() {

		/**
		 * Mock load_plugin_textdomain function
		 */
		\WP_Mock::wpFunction( 'load_plugin_textdomain', array(
			'times' => 1,
			'args' => array(
				'polylang_string_extractor',
				false,
				'polylang-string-extractor/languages',
			),
		) );

		$i18n = new I18n( array(
			'id' => 'polylang_string_extractor',
		) );
		$i18n->load_plugin_textdomain();
	}
}
