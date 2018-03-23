<?php
/**
 * Class provided for setup symfony forms
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

namespace PolylangStringExtractor;

/**
 * Class provided for setup symfony forms
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class Polylang {

	/**
	 * Theme container.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

		$this->define_hooks();
	}

	/**
	 * Merge polylang translate strings with strings from extractor
	 *
	 * @param array $strings Polylang translate strings.
	 *
	 * @return array
	 */
	public function get_strings( $strings ) {

		$extractor_strings = get_option( $this->plugin['strings_option_name'], array() );

		return array_merge( $strings, $extractor_strings );
	}

	/**
	 * Add polylang string extractor translations
	 * to global WordPress translations.
	 */
	public function load_strings_translations() {

		global $l10n;

		if ( isset( $l10n['pll_string'] ) ) {

			$domains = array();

			/**
			 * Get strings from extractor
			 */
			$strings = $this->get_strings( array() );

			/**
			 * Get pll_string domain translations
			 */
			$translations = $l10n['pll_string']->entries;

			/**
			 * Group strings from pll_string domain by separate own domains
			 */
			foreach ( $strings as $md5 => $string ) {

				/**
				 * Only group strings which has own domain
				 */
				if ( isset( $string['context'] ) && ! empty( $string['context'] ) ) {

					/**
					 * Add string to domain group
					 */
					$domains[ $string['context'] ][ $md5 ] = $string;
				}
			}

			/**
			 * Create separate mo classes for each domain ad clone entry from
			 * pll_string domain.
			 */
			foreach ( $domains as $domain => $domain_strings ) {

				/**
				 * Create separate mo classes for domain
				 */
				$mo = new \MO();

				/**
				 * Iterate over previously created domains
				 */
				foreach ( $domain_strings as $domain_string ) {

					/**
					 * Check, to be sure, if string exist in pll_string
					 * translation.
					 */
					if ( isset( $translations[ $domain_string['string'] ] ) ) {

						/**
						 * Clone entry from pll_string but to own domain
						 */
						$mo->add_entry( $translations[ $domain_string['string'] ] );
					}
				}

				/**
				 * Add domain to global WordPress translations
				 */
				$l10n[ $domain ] = $mo; // @codingStandardsIgnoreLine Adding key to WordPress global is the best way to do it.
			}
		}// End if().
	}

	/**
	 * Define hooks for setup class
	 */
	private function define_hooks() {

		/**
		 * Merge polylang translate strings with strings from extractor
		 */
		$this->plugin['loader']->add_filter( 'pll_get_strings' , $this, 'get_strings' );

		$this->plugin['loader']->add_action( 'pll_language_defined' , $this, 'load_strings_translations', 6 ); // Execute after polylang.
		$this->plugin['loader']->add_action( 'change_locale' , $this, 'load_strings_translations', 11 ); // Execute after polylang.
	}
}
