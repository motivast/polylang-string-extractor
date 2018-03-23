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

use PolylangStringExtractor\Extractors\WPCode;

/**
 * Class provided for setup symfony forms
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
class Scanner {

	/**
	 * Theme container.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
	}

	/**
	 * Scan files
	 *
	 * Scan all files in activated theme and activated directory.
	 */
	public function scan() {

		$strings = array();
		$theme_name = get_template();
		$theme_dir = get_template_directory();

		// http://php.net/manual/en/class.recursivedirectoryiterator.php#97228.
		$directory = new \RecursiveDirectoryIterator( $theme_dir );
		$iterator = new \RecursiveIteratorIterator( $directory );

		$regex = new \RegexIterator( $iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH );

		$translations = new \Gettext\Translations();
		$translations->setDomain( $theme_name );

		foreach ( $regex as $files ) {
			$path = current( $files );

			WPCode::fromFile( $path, $translations );
		}

		$translations_iterator = $translations->getIterator();

		foreach ( $translations_iterator as $translation ) {
			$string = $translation->getOriginal();

			$strings[ md5( $string ) ] = array(
				'name' => '',
				'string' => $string,
				'context' => $theme_name,
				'multiline' => false,
			);
		}

		$option_name = sprintf( '%s_strings', $this->plugin['id'] );

		update_option( $option_name , $strings );
	}
}
