<?php
/**
 * Class to get gettext strings from WordPress php files returning arrays.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor\Extractors;

use Gettext\Extractors\ExtractorInterface;
use Gettext\Extractors\PhpCode;
use Gettext\Translations;

use PolylangStringExtractor\Utils\WPFunctionsScanner;

/**
 * Class to get gettext strings from WordPress php files returning arrays.
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class WPCode extends PhpCode implements ExtractorInterface {

	/**
	 * Extractor options
	 *
	 * @var array
	 */
	public static $options = [
		'constants' => [],

		'functions' => [
			'translate' => 'wp_translate',
			'translate_with_gettext_context' => 'wp_x_translate',

			'__' => 'wp_translate',
			'esc_attr__' => 'wp_translate',
			'esc_html__' => 'wp_translate',

			'_e' => 'wp_translate',
			'esc_attr_e' => 'wp_translate',
			'esc_html_e' => 'wp_translate',

			'_x' => 'wp_x_translate',
			'_ex' => 'wp_x_translate',
			'esc_attr_x' => 'wp_x_translate',
			'esc_html_x' => 'wp_x_translate',

			'_n' => 'wp_n_translate',
			'_nx' => 'wp_nx_translate',

			'_n_noop' => 'wp_n_noop_translate',
			'_nx_noop' => 'wp_nx_noop_translate',
		],
	];

	/**
	 * Parses a string and append the translations found in the Translations instance
	 *
	 * @param string       $string 		 String to parse.
	 * @param Translations $translations Translation object to which translations will be added.
	 * @param array        $options      Parser options.
	 */
	public static function fromString( $string, Translations $translations, array $options = [] ) {
		$options += static::$options;

		$functions = new WPFunctionsScanner( $string );

		$functions->saveGettextFunctions( $translations, $options );
	}
}
