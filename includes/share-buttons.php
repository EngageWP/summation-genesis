<?php
/**
 *	Sharing buttons that don't rely on any JavaScript
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

function summation_genesis_get_share_buttons( $post_id = '' ) {

	if ( ! $post_id ) {
		global $post;
	} else {
		$post = get_post( $post_id );
	}

	$url = esc_url_raw( get_permalink( $post->ID ) );
	$title = urlencode( $post->post_title );
	$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	$buttons = array(
		'facebook' => array(
			'url' => add_query_arg( array( 'u' => $url ), 'https://www.facebook.com/sharer/sharer.php' ),
			'icon' => '<i class="fa fa-facebook"></i>',
			'button_text' => __( 'Share it', 'summation-genesis' ),
		),
		'twitter' => array(
			'url' => add_query_arg( array( 'text' => $title, 'url' => $url, ), 'https://twitter.com/intent/tweet' ),
			'icon' => '<i class="fa fa-twitter"></i>',
			'button_text' => __( 'Tweet it', 'summation-genesis' ),
		),
		'pinterest' => array(
			'url' => add_query_arg( array( 'url' => $url, 'description' => $title, 'media' => $thumbnail ), 'http://pinterest.com/pin/create/button' ),
			'icon' => '<i class="fa fa-pinterest"></i>',
			'button_text' => __( 'Pin it', 'summation-genesis' ),
		),
	);

	return $buttons;
}