<?php
/**
 *	Modify the header (favicon too)
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Favicon
 */
add_filter( 'genesis_pre_load_favicon', 'summation_genesis_favicon' );
function summation_genesis_favicon( $favicon_url ) {

	if ( get_theme_mod( 'summation_favicon' ) ) {
		$favicon_url = get_theme_mod( 'summation_favicon' );
	}

	return $favicon_url;
}

/**
 *	Customizer header/logo
 */
add_filter( 'genesis_seo_title', 'summation_genesis_logo', 10, 2 );
function summation_genesis_logo( $title, $inside ) {

	if ( get_theme_mod( 'summation_logo' ) ) {
		$child_inside = sprintf( '
			<div class="site-logo-wrap header-logo">
				<div class="site-logo">
					<a href="%1$s" title="%2$s">
						<img src="%3$s" title="%2$s" alt="%2$s" class="logo-image aligncenter" />
					</a>
				</div>
			</div>', trailingslashit( get_home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_theme_mod( 'summation_logo' ) );
	} else {
		$child_inside = sprintf( '
			<div class="site-logo-wrap header-title">
				<div class="site-logo">
					<a href="%1$s" title="%2$s">%2$s</a>
				</div>
			</div>', trailingslashit( get_home_url() ), esc_attr( get_bloginfo( 'name' ) ) );
	}

	$title = str_replace( $inside, $child_inside, $title );

	return $title;
}

/**
 *	Add custom data attribute to header when sticky header is enabled
 */
add_filter( 'genesis_attr_site-header', 'summation_genesis_sticky_header' );
function summation_genesis_sticky_header( $atts ) {

	if ( get_theme_mod( 'summation_sticky_header' ) == 1 ) {
		$atts['data-sticky-header'] = 'enabled';
	}

	return $atts;
}