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
class Activation {

	/**
	 * Plugin container
	 *
	 * @var Init
	 */
	private $plugin;

	/**
	 * Activation constructor.
	 *
	 * @param Init $plugin PolylangStringExtractor plugin container.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Activation hook
	 */
	public function activate() {
		$this->plugin['scanner']->scan();
	}

	/**
	 * Initialize hookable class
	 */
	public function run() {

		$plugin_slug 	 = str_replace( '_', '-', $this->plugin['id'] );
		$plugin_basename = sprintf( '%s/%s.php', $plugin_slug, $plugin_slug );
		$hook            = sprintf( 'activate_%s', $plugin_basename );

		/**
		 * Simulate register_activation_hook function with our logic
		 */
		$this->plugin['loader']->add_action( $hook , $this, 'activate' );
	}
}
