<?php
/**
 * 
 * Image & Text Column ALT Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

//  Limiting the types of inner blocks for this template block
$allowed_blocks = array( 
    'core/heading',
    'core/paragraph', 
    'core/list',
    'core/quote',
    'core/pullquote',
    'core/shortcode',
    'core/separator',
    "acf/button",
    "acf/spacer",
    'acf/social-media',
    'acf/contact-details',
    'acf/icon',
);

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-image-text-column-alt-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-image-text-column-alt';
if( !empty($block['className']) ) {
    $className .= ' '.$block['className'];
}

// Setting the default template for this template block
$template = array(
	array('core/heading', array(
		'level' => 3,
		'content' => '40/60 two-column block example',
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
$marginBottomValue = $blockSettings['margin_bottom'];
$image = get_field('image') ?: 9259;
$imageFit = get_field('image_fit') ?: 'cover';
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

$bgColour = $blockSettings['background_colour'] ?: 'bg-grey_light';
$lightColours = ['bg-transparent', 'bg-grey_light'];
if( !in_array($bgColour, $lightColours ) ) {
    $bgColour .= ' bg-dark';
}


// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-image-text-column-alt.jpg" alt="Preview of the Image & Text Column ALT Block.">';
    echo '</figure>';
else:

echo '<div id="' . esc_attr($id) . '" class="' . esc_attr($className) .'" style="'.$marginTop.$marginBottom.'">';
    echo '<div class="column column-content '.$bgColour.'">';
        echo '<div class="column-content-inner">';
            echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
        echo '</div>';
    echo '</div>';
    echo '<div class="column column-image image-'.$imageFit.'">';
        if( $imageFit == 'contain' ):
            echo wp_get_attachment_image( $image, 'full', '', ['style' => 'object-position:50% '.$imageVerticalPosition.'%;'] );
        else:
            echo wp_get_attachment_image( $image, 'genesis-singular-images', '', ['style' => 'object-position:50% '.$imageVerticalPosition.'%;'] );
        endif;
    echo '</div>';
echo '</div>';

endif;