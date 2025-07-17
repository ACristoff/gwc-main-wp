<?php

/**
 * Content Block Template.
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
    'core/columns',
    'core/quote',
    'core/pullquote',
    'core/image',
    'core/shortcode',
    'core/separator',
    "acf/button",
    "acf/spacer",
    'acf/icon',
    'acf/container',
    'acf/contact-details',
    'acf/social-media',
    'wpforms/form-selector',
);

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-content-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-content-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Setting the default template for this template block
$template = array(
	array('core/heading', array(
		'level' => 3,
		'content' => 'Title Goes Here!',
	)),
	array('core/paragraph', array(
		'content' => 'Lorem Ipsum is simply dummy text...',
	)),
);

$blockSettings = get_field('block_settings');
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'];
$alignment = $blockSettings['block_alignment'];

$blockHeader = get_field('block_header');
$addHeader = $blockHeader['add_header'];
$headerTitleOverlay = $blockHeader['header_title_overlay'];
$headerImage = $blockHeader['header_image'] ?: 9175;
$headerCaption = $blockHeader['header_image_caption'];
$headerImageSize = $blockHeader['header_image_size'] ?: 'large';
$headerImagePosition = $blockHeader['header_image_position'] ?: 'center';

if( !empty($alignment) ) {
    $className .= ' ql-align-' . $alignment;
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
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-content-block.jpg" alt="Preview of the Content Block.">';
    echo '</figure>';
else:

echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className) .' '.$bgColour.'" style="'.$marginTop.$marginBottom.'">';
    if( $addHeader ):
        echo '<div class="ql-content-block-header'; if( $headerTitle ): echo ' has-title">'; else: echo '">'; endif;
            if( $headerTitle ): echo '<h3>'.$headerTitle.'</h3>'; endif;
            echo '<figure>';
            echo wp_get_attachment_image( $headerImage, $headerImageSize, '', ["class" => "image-$headerImagePosition"] );
                if( $headerCaption ): echo '<figcaption>'.$headerCaption.'</figcaption>'; endif;
            echo '</figure>';
        echo '</div>';
    endif;
    echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
echo '</div>';

endif;