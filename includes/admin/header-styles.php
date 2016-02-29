<?php
/**
 *	Styles that are places in the header
 *
 *	@package Summation Child Theme
 *	@author Ren Ventura
 */
?>

<style id="summation-customizer-css">
	
	.social-following {
		background-color: <?php echo $social_following_bg_color ? $social_following_bg_color : '#f6f6f6'; ?>;
	}

	.header-logo .logo-image {
		max-height: <?php echo $logo_height ? $logo_height . 'px' : '60px'; ?>;
		max-width: <?php echo $logo_width ? $logo_width . 'px' : '360px'; ?>;
	}

</style>

<style id="summation-custom-css">
	<?php echo $custom_css; ?>
</style>