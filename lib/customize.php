<?php
/**
 * Genesis Sample.
 *
 * This file adds the Customizer additions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  Global Watch Co
 * @license GPL-2.0-or-later
 * @link    https://www.globalwatchco.com/
 */

add_action( 'customize_register', 'genesis_sample_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function genesis_sample_customizer_register( $wp_customize ) {

	$appearance = genesis_get_config( 'appearance' );

	$wp_customize->add_setting(
		'gwc_tudor_primary_color',
		[
			'default'           => $appearance['default-colors']['primary'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'gwc_tudor_primary_color',
			[
				'description' => '',
				'label'       => __( 'Primary Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'gwc_tudor_primary_color',
			]
		)
	);

	$wp_customize->add_setting(
		'gwc_tudor_black_color',
		[
			'default'           => $appearance['default-colors']['black'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'gwc_tudor_black_color',
			[
				'description' => '',
				'label'       => __( 'Black Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'gwc_tudor_black_color',
			]
		)
	);

	$wp_customize->add_setting(
		'gwc_tudor_grey_dark_color',
		[
			'default'           => $appearance['default-colors']['grey_dark'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'gwc_tudor_grey_dark_color',
			[
				'description' => '',
				'label'       => __( 'Grey Dark Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'gwc_tudor_grey_dark_color',
			]
		)
	);

	$wp_customize->add_setting(
		'gwc_tudor_grey_color',
		[
			'default'           => $appearance['default-colors']['grey'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'gwc_tudor_grey_color',
			[
				'description' => '',
				'label'       => __( 'Grey Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'gwc_tudor_grey_color',
			]
		)
	);

	$wp_customize->add_setting(
		'gwc_tudor_grey_light_color',
		[
			'default'           => $appearance['default-colors']['grey_light'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'gwc_tudor_grey_light_color',
			[
				'description' => '',
				'label'       => __( 'Grey Light Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'gwc_tudor_grey_light_color',
			]
		)
	);

	$wp_customize->add_setting(
		'genesis_sample_logo_width',
		[
			'default'           => 350,
			'sanitize_callback' => 'absint',
			'validate_callback' => 'genesis_sample_validate_logo_width',
		]
	);

	// Add a control for the logo size.
	$wp_customize->add_control(
		'genesis_sample_logo_width',
		[
			'label'       => __( 'Logo Width', 'genesis-sample' ),
			'description' => __( 'The maximum width of the logo in pixels.', 'genesis-sample' ),
			'priority'    => 9,
			'section'     => 'title_tagline',
			'settings'    => 'genesis_sample_logo_width',
			'type'        => 'number',
			'input_attrs' => [
				'min' => 100,
			],

		]
	);

}

/**
 * Displays a message if the entered width is not numeric or greater than 100.
 *
 * @param object $validity The validity status.
 * @param int    $width The width entered by the user.
 * @return int The new width.
 */
function genesis_sample_validate_logo_width( $validity, $width ) {

	if ( empty( $width ) || ! is_numeric( $width ) ) {
		$validity->add( 'required', __( 'You must supply a valid number.', 'genesis-sample' ) );
	} elseif ( $width < 100 ) {
		$validity->add( 'logo_too_small', __( 'The logo width cannot be less than 100.', 'genesis-sample' ) );
	}

	return $validity;

}
