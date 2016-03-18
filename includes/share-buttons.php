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

	$twitter_via = str_replace( '@', '', $options['summation_genesis_share_button_via'] );
	$twitter_related = str_replace( '@', '', $options['summation_genesis_share_button_related_accounts'] );

	$buttons = array(
		'facebook' => array(
			'url' => add_query_arg( array( 'u' => $url ), 'https://www.facebook.com/sharer/sharer.php' ),
			'icon' => '<i class="fa fa-facebook"></i>',
			'button_text' => __( 'Share it', 'summation-genesis' ),
		),
		'twitter' => array(
			'url' => add_query_arg( array( 'text' => $title, 'url' => $url ), 'https://twitter.com/intent/tweet' ),
			'icon' => '<i class="fa fa-twitter"></i>',
			'button_text' => __( 'Tweet it', 'summation-genesis' ),
		),
		'pinterest' => array(
			'url' => add_query_arg( array( 'url' => $url, 'description' => $title, 'media' => $thumbnail ), 'http://pinterest.com/pin/create/button' ),
			'icon' => '<i class="fa fa-pinterest"></i>',
			'button_text' => __( 'Pin it', 'summation-genesis' ),
		),
	);

	// Twitter "via @...""
	if ( isset( $twitter_via ) && $twitter_via != '' ) {
		$buttons['twitter']['url'] = add_query_arg( 'via', $twitter_via, $buttons['twitter']['url'] );
		$buttons['twitter']['via'] = $twitter_via;
	}

	// Related accounts
	if ( isset( $twitter_related ) && $twitter_related != '' ) {
		$buttons['twitter']['url'] = add_query_arg( 'related', $twitter_related, $buttons['twitter']['url'] );
		$buttons['twitter']['related'] = $twitter_related;
	}

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

	// Bail if front page
	if ( is_front_page() ) {
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

	$disabled = get_post_meta( $post->ID, 'summation_genesis_disable_share_buttons' );

	// Bail if buttons are disabled for this post
	if ( $disabled ) {
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

// Meta box for disabling share buttons
add_action( 'admin_init', 'summation_genesis_disable_share_buttons', 1 );
function summation_genesis_disable_share_buttons() {
	$post_types = get_option( 'genesis-settings' )['summation_genesis_share_button_post_types'];
	$post_types = isset( $post_types ) ? array_keys( $post_types ) : '';
	add_meta_box( 'summation-genesis-disable-share-buttons', 'Summation Share Buttons', 'summation_genesis_disable_share_buttons_callback', $post_types, 'side' );
}

function summation_genesis_disable_share_buttons_callback() {

	global $post;

	$disabled = get_post_meta( $post->ID, 'summation_genesis_disable_share_buttons' );
	
	?>

	<p>
		<label>
			<input type="checkbox" name="summation_genesis_disable_share_buttons" value="1" <?php checked( intval( $disabled ), 1 ); ?> />
			Disable Share Buttons
		</label>
		<?php wp_nonce_field( 'summation_genesis_disable_share_buttons_nonce', 'summation_genesis_disable_share_buttons_nonce' ); ?>
	</p>

	<span class="description">Disable the share buttons on this post.</span>
	
	<?php
}

add_action( 'save_post', 'summation_genesis_social_buttons_save_post' );
function summation_genesis_social_buttons_save_post( $post_id ) {

	if ( ! isset( $_POST['summation_genesis_disable_share_buttons_nonce'] ) || ! wp_verify_nonce( $_POST['summation_genesis_disable_share_buttons_nonce'], 'summation_genesis_disable_share_buttons_nonce' ) ) {
		return;
	}

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$old = intval( get_post_meta( $post_id, 'summation_genesis_disable_share_buttons', true ) );

	$new = isset( $_POST['summation_genesis_disable_share_buttons'] ) ? intval( $_POST['summation_genesis_disable_share_buttons'] ) : '';

	if ( $new == '' && $old ) { // Deleted
		delete_post_meta( $post_id, 'summation_genesis_disable_share_buttons' );
	} elseif ( $new && ! $old ) { // Added
		update_post_meta( $post_id, 'summation_genesis_disable_share_buttons', $new );
	}
}