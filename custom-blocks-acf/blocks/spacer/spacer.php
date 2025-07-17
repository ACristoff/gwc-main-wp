<?php

/**
 * Spacer Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-spacer-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-spacer';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// ----------------------------- Variables ----------------------------- //
$responsiveHeight = get_field('responsive_height');
$heightDesktop = get_field('height_desktop') ?: '40';
$heightTablet = get_field('height_tablet');
$heightMobile = get_field('height_mobile');

if( $responsiveHeight ) {
    $isResponsive = ' is-responsive';
}
if( $heightDesktop ) {
    $styleOutput = ' style="height:'.$heightDesktop.'px;"';
    $heightDesktopData = ' data-height-desktop="'.$heightDesktop.'"';
} 
if( $responsiveHeight && $heightTablet >= '0' ) {
    $heightTabletData = ' data-height-tablet="'.$heightTablet.'"';
} 
if( $responsiveHeight && $heightMobile >= '0' ) {
    $heightMobileData = ' data-height-mobile="'.$heightMobile.'"';
}

// ----------------------------- Output ----------------------------- //

echo '<div id="'.esc_attr($id).'" class="'.esc_attr($className) . $isResponsive.'"'.$heightDesktopData.$heightTabletData.$heightMobileData.$styleOutput.'></div>';
