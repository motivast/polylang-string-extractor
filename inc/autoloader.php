<?php
/**
 * Automatically locates and loads files based on their namespaces and their
 * file names whenever they are instantiated.
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/inc
 * @author     Motivast <support@motivast.com>
 */

spl_autoload_register(
	function( $filename ) {

		// First, separate the components of the incoming file.
		$file_path = explode( '\\', $filename );

		/**
	 * - The first index will always be the namespace since it's part of the plugin.
	 * - All but the last index will be the path to the file.
	 * - The final index will be the filename. If it doesn't begin with 'I' then it's a class.
	 */

		// Get the last index of the array. This is the class we're loading.
		$class_file = '';
		if ( isset( $file_path[ count( $file_path ) - 1 ] ) ) {

			$class_file = strtolower(
				$file_path[ count( $file_path ) - 1 ]
			);
			$class_file = str_ireplace( '_', '-', $class_file );
			$class_file = "class-$class_file.php";
		}

		/**
	 * Find the fully qualified path to the class file by iterating through the $file_path array.
	 * We ignore the first index since it's always the top-level package. The last index is always
	 * the file so we append that at the end.
	 */
		$fully_qualified_path = rtrim(
			dirname(
				dirname( __FILE__ )
			), '/\\'
		) . '/';

		$fully_qualified_path = sprintf( '%s/inc/', $fully_qualified_path );

		$file_path_count = count( $file_path );

		for ( $i = 1; $i < $file_path_count - 1; $i++ ) {

			$dir                   = strtolower( $file_path[ $i ] );
			$fully_qualified_path .= rtrim( $dir, '/\\' ) . '/';
		}
		$fully_qualified_path .= $class_file;

		// Now include the file.
		if ( stream_resolve_include_path( $fully_qualified_path ) ) {
			include_once $fully_qualified_path;
		}
	}
);
