<?php
/**
 * GWC Theme appearance settings.
 *
 * @package GWC
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
 */

$gwc_default_colors = [
	'primary'   => '#245995',
	'green'   => '#127749',
	'black' => '#282828',
	'grey_dark' => '#A4A4A4',
	'grey' => '#D8D8D8',
	'grey_light' => '#f8f8f8',
	'white' => '#fff',
];

$gwc_primary_color = get_theme_mod(
	'gwc_tudor_primary_color',
	$gwc_default_colors['primary']
);
$gwc_green_color = get_theme_mod(
	'gwc_tudor_green_color',
	$gwc_default_colors['green']
);
$gwc_black_color = get_theme_mod(
	'gwc_tudor_black_color',
	$gwc_default_colors['black']
);
$gwc_grey_dark_color = get_theme_mod(
	'gwc_tudor_grey_dark_color',
	$gwc_default_colors['grey_dark']
);
$gwc_grey_color = get_theme_mod(
	'gwc_tudor_grey_color',
	$gwc_default_colors['grey']
);
$gwc_grey_light_color = get_theme_mod(
	'gwc_tudor_grey_light_color',
	$gwc_default_colors['grey_light']
);
$gwc_white_color = get_theme_mod(
	'gwc_tudor_white_color',
	$gwc_default_colors['white']
);

$gwc_primary_color_contrast   = genesis_sample_color_contrast( $gwc_primary_color );
$gwc_primary_color_brightness = genesis_sample_color_brightness( $gwc_primary_color, 35 );

return [
	'fonts-url'            => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Quicksand:wght@300..700&display=swap',
	'font-awesome-all'		=> get_stylesheet_directory_uri().'/assets/fontawesome-free-6.4.0-web/css/all.css',
	'slick-styles'		   => get_stylesheet_directory_uri().'/assets/slick/slick.css',	
	'content-width'        => 1062,
	'button-bg'            => $gwc_primary_color,
	'button-color'         => $gwc_primary_color_contrast,
	'button-outline-hover' => $gwc_primary_color_brightness,
	'primary-color'        => $gwc_primary_color,
	'default-colors'       => $gwc_default_colors,
	'editor-color-palette' => [
		[
			'name'  => __( 'Primary', 'genesis-sample' ),
			'slug'  => 'theme-primary',
			'color' => $gwc_primary_color,
		],
		[
			'name'  => __( 'Green', 'genesis-sample' ),
			'slug'  => 'theme-green',
			'color' => $gwc_green_color,
		],
		[
			'name'  => __( 'Black', 'genesis-sample' ),
			'slug'  => 'theme-black',
			'color' => $gwc_black_color,
		],
		[
			'name'  => __( 'Grey Dark', 'genesis-sample' ),
			'slug'  => 'theme-grey-dark',
			'color' => $gwc_grey_dark_color,
		],
		[
			'name'  => __( 'Grey', 'genesis-sample' ),
			'slug'  => 'theme-grey',
			'color' => $gwc_grey_color,
		],
		[
			'name'  => __( 'Grey Light', 'genesis-sample' ),
			'slug'  => 'theme-grey-light',
			'color' => $gwc_grey_light_color,
		],
		[
			'name'  => __( 'White', 'genesis-sample' ),
			'slug'  => 'theme-white',
			'color' => $gwc_white_color,
		],
	],
	'editor-font-sizes'    => [
		[
			'name' => __( 'Small', 'genesis-sample' ),
			'size' => 12,
			'slug' => 'small',
		],
		[
			'name' => __( 'Normal', 'genesis-sample' ),
			'size' => 18,
			'slug' => 'normal',
		],
		[
			'name' => __( 'Large', 'genesis-sample' ),
			'size' => 20,
			'slug' => 'large',
		],
		[
			'name' => __( 'Larger', 'genesis-sample' ),
			'size' => 24,
			'slug' => 'larger',
		],
	],
];
