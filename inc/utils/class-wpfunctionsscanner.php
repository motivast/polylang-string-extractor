<?php
/**
 * Class provided to handle WordPress translation function correctly
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc/utils
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor\Utils;

use Gettext\Translations;
use Gettext\Utils\PhpFunctionsScanner;

/**
 * Class provided to handle WordPress translation function correctly
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc/utils
 * @author     Motivast <support@motivast.com>
 */
class WPFunctionsScanner extends PhpFunctionsScanner {

	/**
	 * Search for specific functions and create translations
	 *
	 * @param Translations $translations The translations instance where save the values.
	 * @param array        $options      The extractor options.
	 *
	 * @throws \Exception If there is no matching function.
	 */
	public function saveGettextFunctions( Translations $translations, array $options ) {

		$functions = $options['functions'];
		$file = $options['file'];

		foreach ( $this->getFunctions( $options['constants'] ) as $function ) {
			list($name, $line, $args) = $function;

			if ( ! isset( $functions[ $name ] ) ) {
				continue;
			}

			$domain = null;
			$context = null;
			$original = null;
			$plural = null;
			$number = null;

			switch ( $functions[ $name ] ) {
				case 'wp_translate':
					if ( ! isset( $args[0] ) ) {
						continue 2;
					}

					$original = $args[0];
					break;

				case 'wp_n_translate':

					if ( ! isset( $args[1] ) ) {
						continue 2;
					}

					list($original, $plural) = $args;
					break;

				case 'wp_x_translate':
					if ( ! isset( $args[1] ) ) {
						continue 2;
					}

					list($original, $context) = $args;
					break;

				case 'wp_nx_translate':
					if ( ! isset( $args[3] ) ) {
						continue 2;
					}

					list($original, $plural, $number, $context) = $args;
					break;

				case 'wp_n_noop_translate':

					if ( ! isset( $args[1] ) ) {
						continue 2;
					}

					list($original, $plural) = $args;
					break;

				case 'wp_nx_noop_translate':

					if ( ! isset( $args[2] ) ) {
						continue 2;
					}

					list($original, $plural, $context) = $args;
					break;

				default:
					throw new \Exception( sprintf( 'Not valid function %s', $functions[ $name ] ) );
			}// End switch().

			if ( '' !== (string) $original && ( null === $domain || $domain === $translations->getDomain()) ) {
				$translation = $translations->insert( $context, $original, $plural );
				$translation->addReference( $file, $line );

				if ( isset( $function[3] ) ) {
					foreach ( $function[3] as $extracted_comment ) {
						$translation->addExtractedComment( $extracted_comment );
					}
				}
			}
		}// End foreach().
	}
}
