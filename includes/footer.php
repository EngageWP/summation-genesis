<?php
/**
 *	Modify the footer area
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Social Follow widget area
 */
add_action( 'genesis_before_footer', 'summation_genesis_social_follow_footer', 5 );
function summation_genesis_social_follow_footer() {
	
	echo '<div class="social-following">';

	genesis_widget_area( 'social-follow', array(
		'before' => '<div class="flexible-widgets widget-area"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	echo '</div>';
}

/**
 *	Custom footer and scroll-to-top button
 */
remove_action( 'genesis_footer', 'genesis_do_footer');
add_action( 'genesis_footer', 'summation_genesis_footer' );
function summation_genesis_footer() {

	$footer = genesis_get_option( 'summation_genesis_custom_footer' );
	$to_top = get_theme_mod( 'summation_scroll_to_top' );

	if ( $to_top ) {
		printf( '<span class="scroll-to-top" title="%s"><i class="fa fa-arrow-up"></i></span>', __( 'Return to top', 'summation-genesis' ) );
	}

	if ( $footer ) {
		echo do_shortcode( $footer );
	} else {
		printf( '<p><i class="fa fa-heart"></i> <a href="%s" target="_blank">%s</a> %s</p>', 'https://www.engagewp.com/downloads/summation-genesis/', CHILD_THEME_NAME, __( 'built for the Genesis Framework', 'summation-genesis' ) );
	}
}

/**
 *	Add custom data attribute to header when sticky header is enabled
 */
add_filter( 'genesis_attr_site-footer', 'summation_genesis_scroll_top' );
function summation_genesis_scroll_top( $atts ) {

	if ( get_theme_mod( 'summation_scroll_to_top' ) == 1 ) {
		$atts['data-scroll-to-top'] = 'enabled';
	}

	return $atts;
}