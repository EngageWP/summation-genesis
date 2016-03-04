<?php

/**
 *	Hero sections
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Open markup for hero
 */
add_action( 'genesis_before_header', 'summation_genesis_hero_open' );
function summation_genesis_hero_open() {

	global $post;

	$hero_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	// Bail if no hero image selected or is archvie
	if ( ! $hero_src || is_archive() || is_home() ) {
		return;
	}

	printf( '
		<div class="hero" style="background-image: url(\'%s\');">
			<div class="hero-overlay">
				<div class="wrap">', esc_url( $hero_src ) );
}

/**
 *	Close hero markup
 */
add_action( 'genesis_after_header', 'summation_genesis_hero_close' );
function summation_genesis_hero_close() {

	global $post;

	$hero_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	// Bail if no hero image selected or is archive
	if ( ! $hero_src || is_archive() || is_home() ) {
		return;
	}

	$title = $post->post_title;
	$author = get_user_meta( $post->post_author, 'first_name', true ) . ' ' . get_user_meta( $post->post_author, 'last_name', true );

	if ( has_tag() ) {
		$post_meta = '[post_categories sep=", " before="<i class=\'fa fa-folder\'></i> "]<br/>[post_tags sep="" before=""]';
	} else {
		$post_meta = '[post_categories sep=", " before="<i class=\'fa fa-folder\'></i> "]';
	}

	echo '<div class="post-overview">';

	printf( '<h1 class="entry-title" itemprop="headline">%s</h1>', $title );

	if ( $post->post_type === 'post' ) {

		echo '<div class="post-info">';
		
		printf( '<span class="post-date">%s</span> &middot; ', summation_genesis_get_post_date( $post->ID ) );
		
		printf( '<span class="post-author">%s</span>', $author );
		
		// Show comments link if there are comments or comments are open
		if ( $post->comment_count > 0 || $post->comment_status == 'open' ) {
			echo ' &middot; ';
			printf( '<span class="to-comments"><a href="#comments">' . _n( '%s Comment', '%s Comments', intval( $post->comment_count ), 'summation-genesis' ) . '</a></span>', $post->comment_count );
		}
		
		printf( '<p class="post-meta">%s</p>', do_shortcode( $post_meta ) );
		echo '</div>';
	}

	echo '</div></div></div></div>';

	// Social buttons
	$buttons = summation_genesis_get_share_buttons();

	echo '<div class="social-buttons">';

	foreach( $buttons as $key => $button ) {

		printf( "<a href='%s' class='social-button $key' target='_blank'>%s %s</a>", $button['url'], $button['icon'], $button['button_text'] );		
	}

	echo '</div>';
}