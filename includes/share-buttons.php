<?php
/**
 *	Sharing buttons that don't rely on any JavaScript
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

function summation_genesis_get_share_buttons( $post_id = '' ) {

	$options = get_option( 'genesis-settings' );

	// Bail if feature is not enabled
	if ( ! $options['summation_genesis_enable_share_buttons'] ) {
		return;
	}

	if ( ! $post_id ) {
		global $post;
	} else {
		$post = get_post( $post_id );
	}

	$return = array();
	$activated = isset( $options['summation_genesis_share_button_types'] ) ? $options['summation_genesis_share_button_types'] : '';

	// Return empty array if no buttons are enabled
	if ( ! $activated ) {
		return $return;
	}

	$url = esc_url_raw( get_permalink( $post->ID ) );
	$title = urlencode( $post->post_title );
	$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	$twitter_via = $options['summation_genesis_share_button_via'];
	$twitter_related = $options['summation_genesis_share_button_related_accounts'];

	$buttons = array(
		'facebook' => array(
			'url' => add_query_arg( array( 'u' => $url ), 'https://www.facebook.com/sharer/sharer.php' ),
			'icon' => '<i class="fa fa-facebook"></i>',
			'button_text' => __( 'Share it', 'summation-genesis' ),
		),
		'twitter' => array(
			'url' => add_query_arg( array( 'text' => $title, 'url' => $url, 'via' => $twitter_via, 'related' => $twitter_related ), 'https://twitter.com/intent/tweet' ),
			'icon' => '<i class="fa fa-twitter"></i>',
			'button_text' => __( 'Tweet it', 'summation-genesis' ),
			'via' => isset( $twitter_via ) ? $twitter_via : '',
			'related' => isset( $twitter_related ) ? $twitter_related : '',
		),
		'pinterest' => array(
			'url' => add_query_arg( array( 'url' => $url, 'description' => $title, 'media' => $thumbnail ), 'http://pinterest.com/pin/create/button' ),
			'icon' => '<i class="fa fa-pinterest"></i>',
			'button_text' => __( 'Pin it', 'summation-genesis' ),
		),
	);

	foreach( $activated as $key => $value ) {
		if ( $value == 1 ) {
			$return[$key] = $buttons[$key];
		}
	}

	return $return;
}

/**
 *	Output the share buttons after header/hero
 */
add_action( 'genesis_after_header', 'summation_genesis_header_social_buttons', 20 );
function summation_genesis_header_social_buttons() {

	global $post;

	// Bail if not a singular post
	if ( ! is_singular( $post->post_type ) ) {
		return;
	}

	$post_types = genesis_get_option( 'summation_genesis_share_button_post_types' );

	if ( ! $post_types ) {
		$post_types = array();
	}

	// Bail if sharing is not enabled for this post type
	if ( ! array_key_exists( $post->post_type, $post_types ) ) {
		return;
	}

	// Social buttons
	$buttons = summation_genesis_get_share_buttons();

	// Bail if disabled or no buttons enabled
	if ( ! $buttons ) {
		return;
	}

	echo '<div class="social-buttons">';

	foreach( $buttons as $key => $button ) {

		printf( "<a href='%s' class='social-button $key' target='_blank'>%s %s</a>", $button['url'], $button['icon'], $button['button_text'] );		
	}

	echo '</div>';
}