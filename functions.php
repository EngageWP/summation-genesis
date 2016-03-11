<?php

// Include Genesis core
include_once get_template_directory() . '/lib/init.php';

// Child theme constants (do not remove)
if ( ! defined( 'CHILD_THEME_NAME' ) ) {
	define( 'CHILD_THEME_NAME', __( 'Summation Child Theme', 'summation-genesis' ) );
}
if ( ! defined( 'CHILD_THEME_URL' ) ) {
	define( 'CHILD_THEME_URL', 'https://www.engagewp.com/' );
}
if ( ! defined( 'CHILD_THEME_VERSION' ) ) {
	define( 'CHILD_THEME_VERSION', '1.0b' );
}
if ( ! defined( 'CHILD_THEME_DIRECTORY_PATH' ) ) {
	define( 'CHILD_THEME_DIRECTORY_PATH', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'CHILD_THEME_DIRECTORY_URL' ) ) {
	define( 'CHILD_THEME_DIRECTORY_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}
if ( ! defined( 'CHILD_THEME_FRONT_PAGE_WIDGET_AREAS' ) ) {
	define( 'CHILD_THEME_FRONT_PAGE_WIDGET_AREAS', genesis_get_option( 'summation_genesis_front_page_widget_areas' ) );
}

// Include necessary PHP files
include_once 'includes/admin/customizer-options.php';
include_once 'includes/admin/customizer-global-output.php';
include_once 'includes/admin/process-ajax.php';
include_once 'includes/admin/settings.php';
include_once 'includes/admin/sidebars.php';
include_once 'includes/archives.php';
include_once 'includes/author-bio.php';
include_once 'includes/comments.php';
include_once 'includes/enqueues.php';
include_once 'includes/footer.php';
include_once 'includes/header.php';
include_once 'includes/hero.php';
include_once 'includes/post-info-meta.php';
include_once 'includes/post-nav.php';
include_once 'includes/schemas.php';
include_once 'includes/share-buttons.php';

// Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'summation-genesis' ) ) );

// After-Entry widget area
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Replace the main style.css with the minified style.min.css
add_filter( 'stylesheet_uri', 'summation_genesis_stylesheet_uri', 10, 2 );
function summation_genesis_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {
    return CHILD_THEME_DIRECTORY_URL . 'css/style.min.css';
}

// Load text domain
add_action( 'after_setup_theme', 'summation_genesis_load_textdomain' );
function summation_genesis_load_textdomain() {
    load_child_theme_textdomain( 'summation-genesis', get_stylesheet_directory() . '/languages' );
}

// Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );