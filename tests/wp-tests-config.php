<?php
/**
 * The tests configuration for WordPress
 *
 * The wp-tests-config.php creation script uses this file during the
 * tests.
 *
 * @link       http://viewone.pl
 * @since      0.1.0
 *
 * @package    Acf_Helper
 * @subpackage Acf_Helper/inc
 */

/**
 * Path to the WordPress codebase you'd like to test. Add a forward slash in the end.
 */
define( 'ABSPATH', WP_PATH );

/**
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress install defined above.
 */
define( 'WP_DEFAULT_THEME', 'default' );

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );
// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );
// Test with WordPress debug mode (default).
define( 'WP_DEBUG', true );

// ** MySQL settings ** //
// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.
// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.
define( 'DB_NAME', WP_TESTS_CONFIG_DB_NAME );
define( 'DB_USER', WP_TESTS_CONFIG_DB_USER );
define( 'DB_PASSWORD', WP_TESTS_CONFIG_DB_PASS );
define( 'DB_HOST', WP_TESTS_CONFIG_DB_HOST );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix  = 'wptests_';   // Only numbers, letters, and underscores please!

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );
