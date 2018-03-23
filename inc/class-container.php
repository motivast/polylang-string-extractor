<?php
/**
 * Container class provided for keeping all plugin variables, classes in one
 * place.
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
 * Container class provided for keeping all plugin variables, classes in one
 * place.
 *
 * Using container allow us to access all plugin dependency in more convenient
 * way. Instead of creating global variables we have one container which we can
 * access from anywhere.
 *
 * To use this class simply extend your main plugin class.
 *
 * @since      1.0.0
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */
abstract class Container implements \ArrayAccess {


	/**
	 * Plugin container which store properties, objects, callbacks.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array $container Plugin container.
	 */
	protected $container = array();

	/**
	 * Sets the value at the specified index to new value to the container
	 *
	 * @param mixed $offset Offset at the container.
	 * @param mixed $value Value to be set.
	 */
	public function offsetSet( $offset, $value ) {

		$this->container[ $offset ] = $value;
	}

	/**
	 * Returns whether the requested index exists in the container
	 *
	 * @param mixed $offset Offset at the container.
	 *
	 * @return bool
	 */
	public function offsetExists( $offset ) {

		return isset( $this->container[ $offset ] );
	}

	/**
	 * Unset the value at the specified index at the container
	 *
	 * @param mixed $offset Offset at the container.
	 */
	public function offsetUnset( $offset ) {

		unset( $this->container[ $offset ] );
	}

	/**
	 * Returns the value at the specified index from the container
	 *
	 * @param mixed $offset Offset at the container.
	 *
	 * @return mixed|null
	 */
	public function offsetGet( $offset ) {

		return isset( $this->container[ $offset ] ) ? ($this->container[ $offset ]) : null;
	}
}
