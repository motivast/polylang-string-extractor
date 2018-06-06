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
	 * Polylang constructor.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Merge polylang translate strings with strings from extractor
	 *
	 * @param array $strings Polylang translate strings.
	 *
	 * @return array
	 */
	public function get_strings( $strings ) {

		return array_merge( $strings, $this->get_extractor_strings() );
	}

	/**
	 * Get Polylang translation strings added by extractor and
	 * move them to global `$l10n` array separated by domain.
	 *
	 * When we want to translate string using e.g. `__` function, first argument
	 * will be string to translate and second textdomain to use.
	 *
	 * <code>
	 * __('Test string', 'theme_textdomain')
	 * </code>
	 *
	 * When translate WordPress will be looking for `Test string` string in
	 * `test` textdomain in `$l10n` array.
	 *
	 * <code>
	 * $l10n['theme_textdomain']['Test string']
	 * </code>
	 *
	 * Polylang keep all string translations in own `pll_strings` textdomain.
	 *
	 * <code>
	 * $l10n['pll_strings']['Test string']
	 * </code>
	 *
	 * We must convert extractor translation from `pll_strings` textdomain to
	 * proper groups of themes and plugins e.g. 'theme_textdomain'.
	 *
	 * <code>
	 * $l10n['pll_strings']['Test string from theme with textdomain "theme_textdomain"'] =>
	 * $l10n['theme_textdomain']['Test string from theme with textdomain "theme_textdomain"']
	 *
	 * $l10n['pll_strings']['Test string from plugin with textdomain "plugin_textdomain"'] =>
	 * $l10n['plugin_textdomain']['Test string from plugin with textdomain "plugin_textdomain"']
	 * </code>
	 */
	public function load_strings_translations() {

		global $l10n;

		if ( ! isset( $l10n['pll_string'] ) ) {
			return;
		}

		/**
		 * Get polylang already translated strings
		 */
		$translations = $l10n['pll_string']->entries;

		/**
		 * Get strings from extractor in associative array grouped by domain
		 */
		$domains = $this->get_extractor_strings_by_domain();

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
					 * Clone entry from pll_string but to proper domain
					 */
					$mo->add_entry( $translations[ $domain_string['string'] ] );
				}
			}

			/**
			 * Add domain to global WordPress translations
			 */
			$l10n[ $domain ] = $mo; // @codingStandardsIgnoreLine Adding key to WordPress global is the best way to do it.
		}
	}

	/**
	 * Initialize hookable class
	 */
	public function run() {

		/**
		 * Merge polylang translate strings with strings from extractor
		 */
		$this->plugin['loader']->add_filter( 'pll_get_strings', $this, 'get_strings' );

		$this->plugin['loader']->add_action( 'pll_language_defined', $this, 'load_strings_translations', 6 ); // Execute after polylang.
		$this->plugin['loader']->add_action( 'change_locale', $this, 'load_strings_translations', 11 ); // Execute after polylang.
	}

	/**
	 * Get strings from extractor
	 *
	 * @return array
	 */
	private function get_extractor_strings() {

		return get_option( $this->plugin['strings_option_name'], array() );
	}

	/**
	 * Get strings from extractor in associative array grouped by domain
	 *
	 * @return array
	 */
	private function get_extractor_strings_by_domain() {

		$domains = array();

		/**
		 * Get extractor strings to translate
		 */
		$strings = $this->get_extractor_strings();

		/**
		 * Group strings extractor strings by domain.
		 *
		 * Polylang is adding all strings to single `polylang` domain if we
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

		return $domains;
	}
}
