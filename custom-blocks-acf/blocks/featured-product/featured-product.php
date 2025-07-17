<?php

/**
 * Post Loop Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-featured-product-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-featured-product';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// Setting the default template for this template block
$template = array(
	array('core/heading', array(
		'level' => 3,
		'content' => 'Featured Product Name',
	)),
	array('core/paragraph', array(
		'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
	)),
    array('acf/button'),
);

// ----------------------------- Variables ----------------------------- //
$blockSettings = get_field('block_settings');
$reverseColumns = $blockSettings['reverse_columns'];
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'] ?: 40;
$image = get_field('image') ?: 9184;
$imageVerticalPosition = get_field('image_vertical_position') ?: '50';

if( $reverseColumns ) {
    $className .= ' reverse-columns';
}
if( $marginTopValue ) {
    $marginTop = ' margin-top: '.$marginTopValue.'px;';
} 
if( $marginBottomValue ) {
    $marginBottom = ' margin-bottom: '.$marginBottomValue.'px;';
}


// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-featured-product.jpg" alt="Preview of the Featured Product block.">';
    echo '</figure>';
else:

echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className) .'" style="'.$marginTop.$marginBottom.'">';
    echo '<div class="column column-image">';
        echo wp_get_attachment_image( $image, 'medium', '', ['style' => 'object-position:50% '.$imageVerticalPosition.'%;'] );
    echo '</div>';
    echo '<div class="column column-content">';
        echo '<div class="column-content-inner">';
            echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
        echo '</div>';
    echo '</div>';
echo '</div>';

endif;