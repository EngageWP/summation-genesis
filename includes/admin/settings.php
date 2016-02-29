<?php
/**
 *	Theme settings
 *
 *	@package Summation Genesis Child Theme
 *	@author Ren Ventura
 */

/**
 *	Register custom Genesis theme settings
 *
 *	@param (array) $defaults Default theme settings
 *	@return (array) New default theme settings
 */
add_filter( 'genesis_theme_settings_defaults', 'summation_genesis_genesis_theme_defaults' );
function summation_genesis_genesis_theme_defaults( $defaults ) {
	$defaults['summation_genesis_front_page_widget_areas'] = '';
	$defaults['summation_genesis_enable_css_editor'] = '';
	$defaults['summation_genesis_enable_author_box'] = '';
	$defaults['summation_genesis_custom_footer'] = '';
	return $defaults;
}

/**
 * Register additional metaboxes to Genesis > Theme Settings
 *
 * @param (string) $_genesis_theme_settings_pagehook
 */
add_action( 'genesis_theme_settings_metaboxes', 'summation_genesis_genesis_meta_boxes' );
function summation_genesis_genesis_meta_boxes( $_genesis_theme_settings_pagehook ) {
	add_meta_box( 'summation_genesis-settings', __( 'Summation Child Theme Settings', 'summation-genesis' ), 'summation_genesis_genesis_meta_boxes_callback', $_genesis_theme_settings_pagehook, 'main', 'high' );
}

/**
 *	Fill in the meta box with inputs
 *	@see summation_genesis_genesis_meta_boxes()
 */
function summation_genesis_genesis_meta_boxes_callback() { ?>

	<?php

		global $pagenow;

		$return_url = urlencode( add_query_arg( array(
			'page' => 'genesis'
		), admin_url( $pagenow ) ) ); 

	?>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e( 'Frontend CSS Editor', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Frontend CSS Editor', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_css_editor]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_css_editor]" id="summation-genesis-enable-css-editor" value="1" <?php checked( intval( genesis_get_option( 'summation_genesis_enable_css_editor' ) ), 1 ); ?> />
								<?php _e( 'Enable Editor', 'summation-genesis' ); ?>
							</label>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Author Box', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Author Box', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_author_box]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_author_box]" id="summation-genesis-enable-author-box" value="1" <?php checked( intval( genesis_get_option( 'summation_genesis_enable_author_box' ) ), 1 ); ?> />
								<?php _e( 'Enable on single posts', 'summation-genesis' ); ?>
							</label>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Front Page Widgets', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Front Page Widgets', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_front_page_widget_areas]">
								<input type="number" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_front_page_widget_areas]" id="summation-genesis-front-page-widgets" value="<?php esc_attr_e( genesis_get_option( 'summation_genesis_front_page_widget_areas' ) ); ?>" />
							</label><br/>
							<span class="description"><?php _e( 'Number of front page widgets', 'summation-genesis' ); ?></span>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Custom Footer', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Custom Footer', 'summation-genesis' ); ?></legend>
						
						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_custom_footer]"></label>
							<textarea name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_custom_footer]" id="summation-genesis-custom-footer" class="large-text" rows="8"><?php esc_html_e( genesis_get_option( 'summation_genesis_custom_footer' ) ); ?></textarea>
							<span class="description"><?php _e( 'Supports HTML and Shortcodes', 'summation-genesis' ); ?></span>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Customizer', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Customizer', 'summation-genesis' ); ?></legend>
						
						<p><?php _e( 'For more customizations, open the WordPress Customizer and see the Summation Genesis panel.', 'summation-genesis' ) ?> <a href='<?php echo admin_url( "customize.php?return=$return_url" ); ?>'><?php _e( 'Open Customizer', 'summation-genesis' ) ?></a></p>
						
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>

<?php }

// Sanitize new Genesis setting meta boxes
add_action( 'genesis_settings_sanitizer_init', 'summation_genesis_sanitize_meta_boxes' );
function summation_genesis_sanitize_meta_boxes() {

	/**
	 *	Genesis sanitization filters:
	 *	one_zero, no_html, absint, safe_html, requires_unfiltered_html, url, email_address
	 */

	// Safe HTML
	genesis_add_option_filter( 'safe_html', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_custom_footer'
	) );

	// 0 or 1 (i.e. checkboxes, radio buttons)
	genesis_add_option_filter( 'one_zero', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_enable_css_editor',
		'summation_genesis_enable_author_box'
	) );

	// Number (absint)
	genesis_add_option_filter( 'absint', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_front_page_widget_areas',
	) );
}