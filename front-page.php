<?php
/**
 *	Front page template
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Remove global hero
 */
remove_action( 'genesis_before_header', 'summation_genesis_hero_open' );
remove_action( 'genesis_after_header', 'summation_genesis_hero_close' );

/**
 *	Add landing body class to the head
 */
add_filter( 'body_class', 'summation_genesis_front_page_body_class' );
function summation_genesis_front_page_body_class( $classes ) {
	$classes[] = 'front-page';
	return $classes;
}

/**
 *	Styles
 */
add_action( 'wp_head', 'summation_genesis_front_page_head' );
function summation_genesis_front_page_head() { ?>

<style id="summation-front-page-customizer-css">
	.home-hero {
		background-image: url( '<?php echo get_theme_mod( "summation_hero_image" ); ?>' );
		color: <?php echo get_theme_mod( 'summation_hero_text_color' ); ?>;
	}
	.home-hero h1,
	.home-hero h2,
	.home-hero h3,
	.home-hero .widget-title {
		color: <?php echo get_theme_mod( 'summation_hero_header_color' ); ?>;
	}
</style>

<?php }

/**
 *	Enqueue scripts
 */
add_action( 'wp_enqueue_scripts', 'summation_genesis_front_page_enqueue_scripts' );
function summation_genesis_front_page_enqueue_scripts() {
	wp_enqueue_style( 'front-page', CHILD_THEME_DIRECTORY_URL . 'css/front-page.min.css', '', CHILD_THEME_VERSION );
}

/**
 *	Remove default loop if set to show static front page
 */
add_action( 'genesis_loop', 'summation_genesis_maybe_override_front_page', 5 );
function summation_genesis_maybe_override_front_page() {

	if ( get_option( 'show_on_front' ) == 'page' ) {
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}

/**
 *	Open main hero markup
 */
add_action( 'genesis_before_header', 'summation_genesis_front_page_hero_open' );
function summation_genesis_front_page_hero_open() {

	// Bail if front page is set to show posts
	if ( get_option( 'show_on_front' ) == 'posts' ) {
		return;
	}

	?>

	<div class="hero home-hero">
		<div class="hero-overlay">

	<?php
}

/**
 *	Close main hero markup
 */
add_action( 'genesis_after_header', 'summation_genesis_front_page_hero_close' );
function summation_genesis_front_page_hero_close() {

	// Bail if front page is set to show posts
	if ( get_option( 'show_on_front' ) == 'posts' ) {
		return;
	}

	?>

			<div class="container">
				<div class="content">
					<?php genesis_widget_area( 'front-page-hero' ); ?>
				</div>
			</div>
		</div><!-- .hero-overlay -->
	</div><!-- .home-hero -->

	<?php
}

/**
 *	Output front page widget areas
 */
add_action( 'genesis_before_content', 'summation_genesis_front_page_hero_content', 15 );
function summation_genesis_front_page_hero_content() {

	// Bail if front page is set to show posts
	if ( get_option( 'show_on_front' ) == 'posts' ) {
		return;
	}

	for ( $i = 1; $i < CHILD_THEME_FRONT_PAGE_WIDGET_AREAS; $i++ ) {

		// Skip if sidebar has no widgets
		if ( ! is_active_sidebar( "front-page-$i" ) ) {
			continue;
		}

		// Customizer style options
		$image = get_theme_mod( "summation_front_page_{$i}_image" );
		$bg_color = get_theme_mod( "summation_front_page_{$i}_background_color" );
		$text_color = get_theme_mod( "summation_front_page_{$i}_text_color" );

		$atts = array(
			'class' => 'hero home-featured',
			'id' => "front-page-$i",
		);

		$style_atts = array();
		$final_atts = '';

		// Background image
		if ( $image ) {
			$style_atts[] = "background-image: url('$image');";
		}

		// Background color
		if ( $bg_color ) {
			$style_atts[] = "background-color: $bg_color;";
		}

		// Text color
		if ( $text_color ) {
			$style_atts[] = "color: $text_color;";
		}

		// Throw style elements into a string
		if ( $style_atts ) {
			$atts['style'] = implode( ' ', $style_atts );
		}

		// Create attributes-values string
		foreach ( $atts as $att => $val ) {
			$final_atts .= "$att=\"$val\"";
		}

		// Open section with attributes
		printf( '<section %s>', $final_atts );

		if ( $image ) {
			echo '<div class="hero-overlay">';
		}

		genesis_widget_area( "front-page-$i", array(
			'before' => '<div class="flexible-widgets widget-area"><div class="wrap">',
			'after'  => '</div></div></section>',
		) );

		if ( $image ) {
			echo '</div>';
		}
	}
}

genesis();