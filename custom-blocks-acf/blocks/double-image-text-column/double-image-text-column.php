<?php
/**
 * 
 * Double Image & Text Column Block Template.
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
$id = 'ql-double-image-text-column-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-double-image-text-column';
if( !empty($block['className']) ) {
    $className .= $block['className'];
}

// Setting the default template for this template block
$template = array(
	array('core/heading', array(
		'level' => 3,
		'content' => 'Double Image & Text Column block example',
	)),
	array('core/paragraph', array(
		'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
	)),
    array('acf/button'),
);

// ----------------------------- Variables ----------------------------- //
$blockSettings = get_field('block_settings');
$image_1 = get_field('image_1') ?: 9259;
$image_2 = get_field('image_2') ?: 9259;
$labelText = get_field('label_text');
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'];

if( $marginTopValue ) {
    $marginTop = ' margin-top: '.$marginTopValue.'px;';
} 
if( $marginBottomValue ) {
    $marginBottom = ' margin-bottom: '.$marginBottomValue.'px;';
}


// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-double-image-text-column.jpg" alt="Preview of the Double Image & Text Column Block.">';
    echo '</figure>';
else:

echo '<div id="' . esc_attr($id) . '" class="' . esc_attr($className) .'" style="'.$marginTop.$marginBottom.'">';
    echo '<div class="column column-content">';
        if($labelText):
            echo '<h6 class="label">'.$labelText.'</h6>';
        endif;
        echo '<div class="column-content-inner">';
            echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
        echo '</div>';
    echo '</div>';
    echo '<div class="column column-image">';
        echo wp_get_attachment_image( $image_1, 'medium' );
        echo wp_get_attachment_image( $image_2, 'medium' );
    echo '</div>';
echo '</div>';

endif;