<?php
/**
 * 
 * CTA Grid Single Template.
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
    "acf/button",
    "acf/spacer",
    'acf/social-media',
    'acf/contact-details',
    'acf/icon',
);

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-cta-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-cta';
if( !empty($block['className']) ) {
    $className .= ' '.$block['className'];
}

// Setting the default template for this template block
$template = array(
    array('core/paragraph', array(
        'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
	)),
    array('acf/button'),
);

// ----------------------------- Variables ----------------------------- //
$blockSettings = get_field('block_settings');
$backgroundSettings = get_field('background_settings');
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'];
$paddingTopValue = $blockSettings['padding_top'];
$paddingBottomValue = $blockSettings['padding_bottom'];
$bgImageUrl = $backgroundSettings['background_image'];
$bgImageUrlStripped = str_replace(site_url(), "", $bgImageUrl);

$bgColour = $backgroundSettings['background_colour'] ?: '40,40,40';
$bgColourGradient = $backgroundSettings['background_colour_gradient'];

if( $bgColour == 'none' ) {
    $bgColourOutputStyle = '';
} elseif( $bgImageUrl ) {
    $bgColourOutputStyle = ' background: rgba('.$bgColour.',0.80);';
} else {
    $bgColourOutputStyle = ' background: rgba('.$bgColour.',1);';
}

if( $bgColourGradient && $bgColour != 'none' ) {
    $bgColourOutputStyle = ' background: rgba('.$bgColour.',0.75); background: linear-gradient(0deg,rgba('.$bgColour.',1)20%,rgba(255,255,255,0)100%);';
}

if( $marginTopValue ) {
    $marginTop = ' margin-top: '.$marginTopValue.'px;';
} 
if( $marginBottomValue ) {
    $marginBottom = ' margin-bottom: '.$marginBottomValue.'px;';
}
if( $paddingTopValue ) {
    $paddingTop = ' padding-top: '.$paddingTopValue.'px;';
} 
if( $paddingBottomValue ) {
    $paddingBottom = ' padding-bottom: '.$paddingBottomValue.'px;';
}
if( $bgImageUrl ) {
    $bgImageStyle = ' background-image: url('.$bgImageUrl.'); background-repeat: no-repeat; background-size: cover; background-position: center;';
    $className .= ' has-background-image';
}

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-call-to-action.jpg" alt="Preview of the Call-To-Action.">';
    echo '</figure>';
else:

echo '<div id="' . esc_attr($id) . '" class="align-full ' . esc_attr($className) .'" style="'.$marginTop.$marginBottom.$paddingTop.$paddingBottom.$bgImageStyle.'">';

    if( $bgColour != 'none' ):
        echo '<div class="ql-cta-color-overlay" style="'.$bgColourOutputStyle.'"></div>';
    endif;

    echo '<div class="ql-cta-inner bg-dark">';
        echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" templateLock="false" />';
    echo '</div>';

echo '</div>';

endif;