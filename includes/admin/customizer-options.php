<?php
/**
 *	Add style settings to the WordPress Customizer
 *
 *	@package Summation Child Theme
 *	@author Ren Ventura
 */

if ( ! class_exists( 'Summation_Child_Theme_Customizer_Settings' ) ):

class Summation_Child_Theme_Customizer_Settings {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customizer_fields' ) );
	}

	/**
	 *	Define the Customizer settings
	 *
	 *	@return array $settings The Customizer settings
	 */
	public function customizer_settings() {

		$front_page_fields = array(

			// Fields
			array(
				'type' => 'image_upload',
				'key' => 'summation_hero_image',
				'label' => __( 'Main Hero Image', 'summation-genesis' ),
				'description' => __( '', 'summation-genesis' )
			),
			array(
				'type' => 'color',
				'key' => 'summation_hero_header_color',
				'label' => __( 'Hero Header Color', 'summation-genesis' ),
				'default' => '',
			),
			array(
				'type' => 'color',
				'key' => 'summation_hero_text_color',
				'label' => __( 'Hero Text Color', 'summation-genesis' ),
				'default' => '',
			),
		);

		for ( $i = 1; $i <= CHILD_THEME_FRONT_PAGE_WIDGET_AREAS; $i++ ) {

			$front_page_fields[] = array(
				'type' => 'image_upload',
				'key' => "summation_front_page_{$i}_image",
				'label' => __( "Front Page Section {$i} Image", 'summation-genesis' ),
				'description' => __( '', 'summation-genesis' )
			);
			$front_page_fields[] = array(
				'type' => 'color',
				'key' => "summation_front_page_{$i}_background_color",
				'label' => __( "Front Page Section {$i} Background Color", 'summation-genesis' ),
				'default' => '',
			);
			$front_page_fields[] = array(
				'type' => 'color',
				'key' => "summation_front_page_{$i}_text_color",
				'label' => __( "Front Page Section {$i} Text Color", 'summation-genesis' ),
				'default' => '',
			);
		}

		$settings = array(

			'panels' => array(

				// Panels
				array(
					'key' => 'summation_genesis_customizer_panel',
					'priority' => 1,
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __( 'Summation Child Theme', 'summation-genesis' ),
					'description' => __( 'Customizer settings for the Summation child theme.', 'summation-genesis' ),
					'sections' => array(

						// Panel Sections
						array(
							'key' => 'summation_genesis_customizer_front_page',
							'title' => __( 'Front Page', 'summation-genesis' ),
							'description' => __( 'Front page images and colors.', 'summation-genesis' ),
							'fields' => $front_page_fields,
						),
						array(
							'key' => 'summation_genesis_customizer_global_widgets',
							'title' => __( 'Global Widgets', 'summation-genesis' ),
							'description' => __( 'Widgets displayed across the entire site.', 'summation-genesis' ),
							'fields' => array(
								// Fields
								array(
									'type' => 'color',
									'key' => 'summation_hero_social_follow_background',
									'label' => __( 'Social Follow Background Color', 'summation-genesis' ),
									'default' => '',
								),
							)
						),
						array(
							'key' => 'summation_genesis_customizer_misc',
							'title' => __( 'Miscellaneous', 'summation-genesis' ),
							'description' => __( 'Miscellaneous settings.', 'summation-genesis' ),
							'fields' => array(
								// Fields
								array(
									'type' => 'image_upload',
									'key' => 'summation_favicon',
									'label' => __( 'Favicon', 'summation-genesis' ),
								),
								array(
									'type' => 'image_upload',
									'key' => 'summation_logo',
									'label' => __( 'Logo Image', 'summation-genesis' ),
									'description' => __( '', 'summation-genesis' )
								),
								array(
									'type' => 'number',
									'key' => 'summation_logo_width',
									'label' => __( 'Logo Max Width', 'summation-genesis' ),
									'description' => __( 'Default: 360px', 'summation-genesis' )
								),
								array(
									'type' => 'number',
									'key' => 'summation_logo_height',
									'label' => __( 'Logo Max Height', 'summation-genesis' ),
									'description' => __( 'Default: 80px', 'summation-genesis' )
								),
								array(
									'type' => 'checkbox',
									'key' => 'summation_sticky_header',
									'label' => __( 'Sticky Header', 'summation-genesis' ),
									'description' => __( 'Stick header to top of screen when scrolling up.', 'summation-genesis' )
								),
								array(
									'type' => 'checkbox',
									'key' => 'summation_scroll_to_top',
									'label' => __( 'Scroll to Top', 'summation-genesis' ),
									'description' => __( 'Enable a scroll-to-top button.', 'summation-genesis' )
								),
							),
						),
					),
				),
			),
		);

		return $settings;
	}

	/**
	 *	Add customizer controls
	 */
	public function register_customizer_fields( $wp_customize ) {

		$settings = $this->customizer_settings();

		$this->control_setup( $settings, $wp_customize );
	}

	/**
	 *	Loop through each customizer setting and set it up with the proper control
	 */
	public function control_setup( $settings, $wp_customize ) {

		foreach ( $settings['panels'] as $panel ) {

			// Create the panel(s)
			$wp_customize->add_panel( $panel['key'], array(
				'priority'       => isset( $panel['priority'] ) ? $panel['priority'] : '',
				'capability'     => isset( $panel['capability'] ) ? $panel['capability'] : '',
				'theme_supports' => isset( $panel['theme_supports'] ) ? $panel['theme_supports'] : '',
				'title'          => isset( $panel['title'] ) ? $panel['title'] : '',
				'description'    => isset( $panel['description'] ) ? $panel['description'] : '',
			) );

			foreach ( $panel['sections'] as $section ) {

				if ( ! isset( $section_priority ) ) {
					$section_priority = isset( $section['priority'] ) ? $section['priority'] : 1;
				}

				$wp_customize->add_section( $section['key'], array(
					'title' => isset( $section['title'] ) ? $section['title'] : '',
					'description' => isset( $section['description'] ) ? $section['description'] : '',
					'priority' => $section_priority,
					'panel'  => $panel['key'],
				) );

				if ( isset( $section['fields'] ) && is_array( $section['fields'] ) ) {

					foreach ( $section['fields'] as $field ) {

						if ( ! isset( $field_priority ) ) {
							$field_priority = 1;
						}

						switch ( $field['type'] ) {

							// Color picker
							case 'color':
								$wp_customize->add_setting( $field['key'], array(
									'default' => $field['default'] ? $field['default'] : '',
								) );
								$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $field['key'], array(
									'label' => isset( $field['label'] ) ? $field['label'] : '',
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'section' => $section['key'],
									'settings' => isset( $field['key'] ) ? $field['key'] : '',
									'priority' => $field_priority,
									'default' => isset( $field['default'] ) ? $field['default'] : '',
								) ) );
								break;

							// Text
							case 'text':
								$wp_customize->add_setting( $field['key'], array(
									'default' => isset( $field['default'] ) ? $field['default'] : '',
									'sanitize_callback' => array( $this, 'sanitize_number' ),
							    ) );
								$wp_customize->add_control( $field['key'], array(
									'label' => isset( $field['label'] ) ? $field['label'] : '',
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'section' => $section['key'],
									'type' => 'text',
									'priority' => $field_priority,
								) );
								break;

							// Numbers
							case 'number':
								$wp_customize->add_setting( $field['key'], array(
									'default' => isset( $field['default'] ) ? $field['default'] : '',
							    ) );
								$wp_customize->add_control( $field['key'], array(
									'label' => isset( $field['label'] ) ? $field['label'] : '',
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'section' => $section['key'],
									'type' => 'number',
									'priority' => $field_priority,
								) );
								break;

							// Checkbox
							case 'checkbox':
								$wp_customize->add_setting( $field['key'], array(
									'default' => isset( $field['default'] ) ? $field['default'] : '',
							    ) );
								$wp_customize->add_control( $field['key'], array(
									'label' => isset( $field['label'] ) ? $field['label'] : '',
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'section' => $section['key'],
									'type' => 'checkbox',
									'priority' => $field_priority,
								) );
								break;

							// Image uploader
							case 'image_upload':
								$wp_customize->add_setting( $field['key'] );
								$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
									$field['key'],
									array(
										'label' => isset( $field['label'] ) ? $field['label'] : '',
										'description' => isset( $field['description'] ) ? $field['description'] : '',
										'section'  => $section['key'],
										'settings' => $field['key'],
										'priority' => $field_priority,
									) ) );
								break;
							
							default:
								break;
						}

						$field_priority++;
					}
				}

				$section_priority++;
			}
		}
	}
}

endif;

new Summation_Child_Theme_Customizer_Settings;