<?php
/**
 * Class provided for mock WordPress MO class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/sample
 * @author     Motivast <support@motivast.com>
 */

/**
 * Class provided for mock WordPress MO class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/sample
 * @author     Motivast <support@motivast.com>
 */
class MO {

	/**
	 * All translations
	 *
	 * @var array
	 */
	public $entries;

	/**
	 * Method for adding translations
	 *
	 * @param string $entry Translation.
	 */
	public function add_entry( $entry ) {

		$this->entries[ $entry ] = $entry;
	}
}
