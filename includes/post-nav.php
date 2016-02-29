<?php
/**
 *	Add some navigation after posts (related posts, next/prev posts, etc.)
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

// Post navigation
add_action( 'genesis_after_entry', 'summation_genesis_post_nav', 5 );
function summation_genesis_post_nav() {

	global $post;

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$prev = get_adjacent_post();
	$next = get_adjacent_post( false, '', false );

	echo '<div class="single-post-nav clearfix">';

	if ( $prev ) {
		printf( '<a href="%s" class="previous-post"><span class="post-nav-direction">%s</span>%s</a>', get_permalink( $prev->ID ), __( '&lt; Previous', 'summation-genesis' ), get_the_title( $prev->ID ) );
	}

	if ( $next ) {
		printf( '<a href="%s" class="next-post"><span class="post-nav-direction">%s</span>%s</a>', get_permalink( $next->ID ), __( 'Next &gt;', 'summation-genesis' ), get_the_title( $next->ID ) );
	}

	echo '</div>';
}