<?php
/**
 *	Add custom schema markup
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

// Set the itemprop of an element to description
add_filter( 'genesis_attr_entry-content', 'summation_genesis_itemprop_description', 20 );
function summation_genesis_itemprop_description( $attr ) {
	$attr['itemprop'] = 'description';
	return $attr;
}

// Set the itemprop of an element to name
add_filter( 'genesis_attr_entry-title', 'summation_genesis_itemprop_name', 20 );
function summation_genesis_itemprop_name( $attr ) {
	$attr['itemprop'] = 'name';
	return $attr;
}

// Add the url itemprop to the URL of the entry
add_filter( 'genesis_post_title_output', 'summation_genesis_title_link_schema', 20 );
function summation_genesis_title_link_schema( $output ) {
	return str_replace( 'rel="bookmark"', 'rel="bookmark" itemprop="url"', $output );
}