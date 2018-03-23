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

		translate( 'Test string translate', 'pllse' ); // @codingStandardsIgnoreLine Check low level api functions too.
		translate_with_gettext_context( 'Test string translate_with_gettext_context', 'Test context translate_with_gettext_context', 'pllse' ); // @codingStandardsIgnoreLine Check low level api functions too.

		__( 'Test string __', 'pllse' );
		esc_attr__( 'Test string esc_attr__', 'pllse' );
		esc_html__( 'Test string esc_html__', 'pllse' );

		_e( 'Test string _e', 'pllse' ); // @codingStandardsIgnoreLine Do not bother escaping here.
		esc_attr_e( 'Test string esc_attr_e', 'pllse' );
		esc_html_e( 'Test string esc_html_e', 'pllse' );

		_x( 'Test string _x', 'Test context _x', 'pllse' );
		_ex( 'Test string _ex', 'Test context _ex', 'pllse' ); // @codingStandardsIgnoreLine Do not bother escaping here.
		esc_attr_x( 'Test string esc_attr_x', 'Test context esc_attr_x', 'pllse' );
		esc_html_x( 'Test string esc_html_x', 'Test context esc_html_x', 'pllse' );

		_n( 'Test single string number 1 _n', 'Test plural string number 1 _n', 1, 'pllse' );
		_n( 'Test single string number 2 _n', 'Test plural string number 2 _n', 2, 'pllse' );
		_nx( 'Test single string number 1 _nx', 'Test plural string number 1 _nx', 1, 'Test context number 1 _nx', 'pllse' );
		_nx( 'Test single string number 2 _nx', 'Test plural string number 2 _nx', 2, 'Test context number 2 _nx', 'pllse' );

		_n_noop( 'Test single string _n_noop', 'Test plural string _n_noop', 'pllse' );
		_nx_noop( 'Test single string _nx_noop', 'Test plural string _nx_noop', 'Test context _nx_noop', 'pllse' );

		?>
	</div><!-- #content -->
</div><!-- #container -->
