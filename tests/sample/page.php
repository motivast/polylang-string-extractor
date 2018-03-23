<?php
/**
 * Template for simulating single page with translation functions
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    PolylangStringExtractor
 * @subpackage PolylangStringExtractor/tests/sample
 * @author     Motivast <support@motivast.com>
 */

?>

<div id="container">
	<div id="content" role="main">
		<?php

		translate( 'Test string translate' ); // @codingStandardsIgnoreLine Check low level api functions too.
		translate_with_gettext_context( 'Test string translate_with_gettext_context', 'Test context translate_with_gettext_context' ); // @codingStandardsIgnoreLine Check low level api functions too.

		__( 'Test string __' );
		esc_attr__( 'Test string esc_attr__' );
		esc_html__( 'Test string esc_html__' );

		_e( 'Test string _e' ); // @codingStandardsIgnoreLine Do not bother escaping here.
		esc_attr_e( 'Test string esc_attr_e' );
		esc_html_e( 'Test string esc_html_e' );

		_x( 'Test string _x', 'Test context _x' );
		_ex( 'Test string _ex', 'Test context _ex' ); // @codingStandardsIgnoreLine Do not bother escaping here.
		esc_attr_x( 'Test string esc_attr_x', 'Test context esc_attr_x' );
		esc_html_x( 'Test string esc_html_x', 'Test context esc_html_x' );

		_n( 'Test single string number 1 _n', 'Test plural string number 1 _n', 1 );
		_n( 'Test single string number 2 _n', 'Test plural string number 2 _n', 2 );
		_nx( 'Test single string number 1 _nx', 'Test plural string number 1 _nx', 1, 'Test context number 1 _nx' );
		_nx( 'Test single string number 2 _nx', 'Test plural string number 2 _nx', 2, 'Test context number 2 _nx' );

		_n_noop( 'Test single string _n_noop', 'Test plural string _n_noop' );
		_nx_noop( 'Test single string _nx_noop', 'Test plural string _nx_noop', 'Test context _nx_noop' );

		?>
	</div><!-- #content -->
</div><!-- #container -->
