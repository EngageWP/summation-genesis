<?php
/**
 *	Theme sidebars
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

// Front page - main hero section
genesis_register_sidebar( array(
	'id'          => 'front-page-hero',
	'name'        => __( 'Front Page Hero', 'summation-genesis' ),
	'description' => __( 'This is the main/her section of the front page.', 'summation-genesis' ),
) );

// Front page sections
for ( $i = 1; $i <= CHILD_THEME_FRONT_PAGE_WIDGET_AREAS; $i++ ) { 
	genesis_register_sidebar( array(
		'id'          => "front-page-$i",
		'name'        => __( 'Front Page', 'summation-genesis' ) . ' ' . $i,
		'description' => __( "This is the front page $i section.", 'summation-genesis' ),
	) );
}

// Social Follow
genesis_register_sidebar( array(
	'id'          => 'social-follow',
	'name'        => __( 'Social Follow', 'summation-genesis' ),
	'description' => __( 'Insert social follow links (displayed globally)', 'summation-genesis' ),
) );