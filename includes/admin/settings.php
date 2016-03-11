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
	$defaults['summation_genesis_enable_share_buttons'] = '';
	$defaults['summation_genesis_share_button_types'] = '';
	$defaults['summation_genesis_share_button_post_types'] = '';
	$defaults['summation_genesis_share_button_via'] = '';
	$defaults['summation_genesis_share_button_related_accounts'] = '';
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
	add_meta_box( 'summation_genesis-general-settings', __( 'Summation Child Theme - General Settings', 'summation-genesis' ), 'summation_genesis_general_settings_metabox', $_genesis_theme_settings_pagehook, 'main', 'high' );
	add_meta_box( 'summation_genesis-social-settings', __( 'Summation Child Theme - Social Share Settings', 'summation-genesis' ), 'summation_genesis_social_settings_metabox', $_genesis_theme_settings_pagehook, 'main', 'high' );
}

/**
 *	Fill in the General Settings meta box with inputs
 *	@see summation_genesis_genesis_meta_boxes()
 */
function summation_genesis_general_settings_metabox() { ?>

	<?php

		global $pagenow;

		$return_url = urlencode( add_query_arg( array(
			'page' => 'genesis'
		), admin_url( $pagenow ) ) );

		$options = get_option( 'genesis-settings' );

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
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_css_editor]" id="summation-genesis-enable-css-editor" value="1" <?php checked( intval( $options['summation_genesis_enable_css_editor'] ), 1 ); ?> />
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
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_author_box]" id="summation-genesis-enable-author-box" value="1" <?php checked( intval( $options['summation_genesis_enable_author_box'] ), 1 ); ?> />
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
								<input type="number" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_front_page_widget_areas]" id="summation-genesis-front-page-widgets" value="<?php esc_attr_e( $options['summation_genesis_front_page_widget_areas'] ); ?>" />
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
							<textarea name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_custom_footer]" id="summation-genesis-custom-footer" class="large-text" rows="8"><?php esc_html_e( $options['summation_genesis_custom_footer'] ); ?></textarea>
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

/**
 *	Fill in the Social Share meta box with inputs
 *	@see summation_genesis_genesis_meta_boxes()
 */
function summation_genesis_social_settings_metabox() { ?>

	<?php

		global $pagenow;

		$return_url = urlencode( add_query_arg( array(
			'page' => 'genesis'
		), admin_url( $pagenow ) ) );

		$options = get_option( 'genesis-settings' );

		$button_types = isset( $options['summation_genesis_share_button_types'] ) ? $options['summation_genesis_share_button_types'] : '';
		$post_types = isset( $options['summation_genesis_share_button_post_types'] ) ? $options['summation_genesis_share_button_post_types'] : '';

	?>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e( 'Enable Social Sharing Icons', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Enable Social Sharing Icons', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_share_buttons]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_enable_share_buttons]" id="summation-genesis-enable-share-buttons" value="1" <?php checked( intval( $options['summation_genesis_enable_share_buttons'] ), 1 ); ?> />
								<?php _e( 'Enable Share Buttons', 'summation-genesis' ); ?>
							</label>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Button Types', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Button Types', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][twitter]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][twitter]" id="summation-genesis-twitter" value="1" <?php checked( intval( isset( $button_types['twitter'] ) ? $button_types['twitter'] : '' ), 1 ); ?> />
								<?php _e( 'Twitter', 'summation-genesis' ); ?>
							</label>
						</p>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][facebook]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][facebook]" id="summation-genesis-facebook" value="1" <?php checked( intval( isset( $button_types['facebook'] ) ? $button_types['facebook'] : '' ), 1 ); ?> />
								<?php _e( 'Facebook', 'summation-genesis' ); ?>
							</label>
						</p>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][pinterest]">
								<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_types][pinterest]" id="summation-genesis-pinterest" value="1" <?php checked( intval( isset( $button_types['pinterest'] ) ? $button_types['pinterest'] : '' ), 1 ); ?> />
								<?php _e( 'Pinterest', 'summation-genesis' ); ?>
							</label>
						</p>
						
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Post Types', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Post Types', 'summation-genesis' ); ?></legend>

						<span class="description"><?php _e( 'Which post types should include share buttons?', 'summation-genesis' ); ?></span>

						<?php foreach( get_post_types( array( 'public' => true ) ) as $type ) : ?>

							<p>
								<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_post_types][<?php echo $type; ?>]">
									<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_post_types][<?php echo $type; ?>]" id="summation-genesis-<?php echo $type; ?>" value="1" <?php checked( intval( isset( $post_types[$type] ) ? $post_types[$type] : '' ), 1 ); ?> />
									<?php echo ucwords( $type ); ?>
								</label>
							</p>

						<?php endforeach; ?>

					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Via... (Twitter)', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'Via... (Twitter)', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_via]">
								<input type="text" class="regular-text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_via]" id="summation-genesis-via" value="<?php echo $options['summation_genesis_share_button_via']; ?>" placeholder="i.e. CLE_Ren" />
							</label>
						</p>

						<span class="description"><?php _e( 'Who is responsible for the content?', 'sumation-genesis' ); ?></span>

					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'List of "Related" accounts (Twitter)', 'summation-genesis' ); ?></th>
				<td>
					<fieldset>
						
						<legend class="screen-reader-text"><?php _e( 'List of "Related" accounts (Twitter)', 'summation-genesis' ); ?></legend>

						<p>
							<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_related_accounts]">
								<input type="text" class="regular-text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[summation_genesis_share_button_related_accounts]" id="summation-genesis-related-accounts" value="<?php echo $options['summation_genesis_share_button_related_accounts']; ?>" placeholder="i.e. CLE_Ren,srikat" />
							</label>
						</p>

						<span class="description"><?php _e( 'These accounts may be recommended by Twitter after a successful share. Separate each account by a comma. Do not include the @ symbol.', 'summation-genesis' ); ?></span>

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

	// No HTML
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_share_button_related_accounts',
		'summation_genesis_share_button_via',
	) );

	// Safe HTML
	genesis_add_option_filter( 'safe_html', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_custom_footer',
	) );

	// 0 or 1 (i.e. checkboxes, radio buttons)
	genesis_add_option_filter( 'one_zero', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_enable_css_editor',
		'summation_genesis_enable_author_box',
		'summation_genesis_enable_share_buttons',
		'summation_genesis_share_button_types["twitter"]',
		'summation_genesis_share_button_types["facebook"]',
		'summation_genesis_share_button_types["pinterest"]',
	) );

	// Number (absint)
	genesis_add_option_filter( 'absint', GENESIS_SETTINGS_FIELD, array(
		'summation_genesis_front_page_widget_areas',
	) );
}