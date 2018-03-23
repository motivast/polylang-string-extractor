<?php
/**
 * PHPUnit bootstrap file
 *
 * @package PolylangStringExtractor
 */

$_tests_dir = './vendor/wordpress/wordpress-dev/tests/phpunit';

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/polylang-string-extractor.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
