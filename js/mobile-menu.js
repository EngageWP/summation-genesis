jQuery(document).ready(function($) {

	$('body').addClass('js');
	
	/**
	 *	Mobile menu
	 */

	// Get supported menus that are in use
	var menus = {};
	menus.primary_nav = $('.nav-primary').clone();
	menus.header_nav = $('.site-header:not(.header-clone) .nav-header').clone();

	// Add the mobile menu icon to headers
	var header = $('.site-header');
	header.append( '<span id="summation-mobile-menu-open-container"><i class="summation-mobile-menu-open fa fa-bars"></i><span class="screen-reader-text">' + summation.open_menu_text + '</span></span><section id="summation-mobile-menu"></section>' );

	// Menu elements
	var mobile_menu = $('#summation-mobile-menu');
	var mobile_menu_open = $('.summation-mobile-menu-open');
	mobile_menu.prepend('<span id="summation-mobile-menu-close-container"><i id="summation-mobile-menu-close" class="fa fa-close"></i><span class="screen-reader-text">' + summation.close_menu_text + '</span></span>');

	var mobile_menu_close = $('#summation-mobile-menu-close');

	// Open mobile menu
	mobile_menu_open.click(function() {
		mobile_menu_open.addClass('spin');
		mobile_menu.removeClass('close').addClass('open');
		mobile_menu_close.removeClass('spin');
	});

	// Close mobile menu
	mobile_menu_close.click(function() {
		mobile_menu_close.addClass('spin');
		mobile_menu.removeClass('open').addClass('close');
		mobile_menu_open.removeClass('spin');
	});

	// Loop through each menu and add it to mobile menu
	$.each(menus,function(index, el) {
		el.removeClass();
		mobile_menu.append(el);
	});
});