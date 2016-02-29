<?php
/**
 *	Process AJAX requests
 *
 *	@package Summation Child Theme
 *	@author Ren Ventura
 */

/**
 *	Update Custom CSS theme mod
 */
add_action( 'wp_ajax_summation_genesis_save_css', 'summation_genesis_save_css' );
function summation_genesis_save_css() {

	$response = array();

	$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : null;
	$css = isset( $_POST['css'] ) ? $_POST['css'] : '';

	// Verify nonce, permissions, and that editor is enabled
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'summation_css_editor_nonce' ) || ! current_user_can( 'manage_options' ) || ! genesis_get_option( 'summation_genesis_enable_css_editor' ) ) {
		$response['status'] = 'failed';
		$response['message'] = __( 'Permissions failed.', 'summation-genesis' );
	}

	// Save the CSS
	set_theme_mod( 'summation_custom_css', strip_tags( $css ) );

	// Success response
	$response['status'] = 'success';
	$response['message'] = __( 'Changes saved!', 'summation-genesis' );

	// Send response
	wp_send_json( $response );
}