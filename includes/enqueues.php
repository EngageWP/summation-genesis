<?php
/**
 *	Enqueue scripts and styles
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Add scripts and stylesheets
 */
add_action( 'wp_enqueue_scripts', 'summation_genesis_enqueues' );
function summation_genesis_enqueues() {

	// Google fonts
	wp_enqueue_style( 'google-font-montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-ptserif', '//fonts.googleapis.com/css?family=PT+Serif:400,400italic,700', array(), CHILD_THEME_VERSION );

	// Font Awesome
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' );

	// Add compiled JS
	wp_enqueue_script( 'summation-scripts', CHILD_THEME_DIRECTORY_URL . 'js/min/project-min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script( 'summation-scripts', 'summation', array(
		'open_menu_text' => __( 'Open Menu', 'summation-genesis' ),
		'close_menu_text' => __( 'Close Menu', 'summation-genesis' ),
	) );

	// CSS Editor
	if ( current_user_can( 'manage_options' ) && genesis_get_option( 'summation_genesis_enable_css_editor' ) ) {

		// jQuery UI (WP version does not include all necessary components)
		wp_enqueue_script( 'jquery-ui', CHILD_THEME_DIRECTORY_URL . 'js/min/jquery-ui-min.js', array( 'jquery' ), '1.11.4' );
		wp_enqueue_style( 'jquery-ui', CHILD_THEME_DIRECTORY_URL . 'css/jquery-ui.min.css', array(''), '1.11.4' );

		// Ace Editor
		wp_enqueue_script( 'ace', CHILD_THEME_DIRECTORY_URL . 'js/ace/ace.js', array( 'jquery' ), CHILD_THEME_VERSION );
		wp_enqueue_script( 'ace-mode', CHILD_THEME_DIRECTORY_URL . 'js/ace/mode-css.js', array( 'jquery', 'ace' ), CHILD_THEME_VERSION, true );
		wp_enqueue_script( 'ace-monokai-js', CHILD_THEME_DIRECTORY_URL . 'js/ace/theme-monokai.js', array( 'jquery', 'ace' ), CHILD_THEME_VERSION, true );
		wp_enqueue_style( 'ace-monokai-css', CHILD_THEME_DIRECTORY_URL . 'js/ace/theme-monokai.css', array(''), CHILD_THEME_VERSION );
		wp_enqueue_script( 'ace-language-tools', CHILD_THEME_DIRECTORY_URL . 'js/ace/ext-language_tools.js', array( 'jquery', 'ace' ), CHILD_THEME_VERSION, true );
		wp_enqueue_script( 'css-editor', CHILD_THEME_DIRECTORY_URL . 'js/min/css-editor-min.js', array('jquery','ace','ace-monokai-js','ace-mode','ace-language-tools'), CHILD_THEME_VERSION, true );
		wp_localize_script( 'css-editor', 'summation_editor', array(
			'no_changes_msg' => __( 'No changes were made.', 'summation-genesis' ),
			'saving_text' => __( 'Saving...', 'summation-genesis' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );
	}
}

/**
 *	Deregister the default styles for Genesis Simple Share
 *	GSS is styled in sass/partials/_genesis-simple-share.scss
 */
add_action( 'wp_print_styles', 'summation_genesis_remove_gss_css', 99 );
function summation_genesis_remove_gss_css()  {
	wp_dequeue_style( 'genesis-simple-share-plugin-css' );
	wp_dequeue_style( 'genesis-simple-share-genericons-css' );
}