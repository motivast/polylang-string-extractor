<?php
/**
 * Class provided for mock WordPress WP_Theme class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/sample
 * @author     Motivast <support@motivast.com>
 */

/**
 * Class provided for mock WordPress WP_Theme class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/sample
 * @author     Motivast <support@motivast.com>
 */
class WP_Theme {

	/**
	 * Indicates whether test get method should return good value
	 *
	 * @var boolean
	 */
	private $correct;

	/**
	 * Mock WP_Theme class constructor
	 *
	 * @param boolean $correct Indicates whether test get method should return good value.
	 */
	public function __construct( $correct = true ) {
		$this->correct = $correct;
	}

	/**
	 * Method for getting WP_Theme values
	 *
	 * @param string $key Key to retrieve.
	 *
	 * @return string|boolean
	 */
	public function get( $key ) {

		if ( 'TextDomain' === $key && $this->correct ) {
			return 'test';
		}

		if ( 'TextDomain' === $key && ! $this->correct ) {
			return false;
		}
	}
}
