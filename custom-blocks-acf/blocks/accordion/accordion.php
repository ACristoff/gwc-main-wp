<?php

/**
 * Accordion Block Template.
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
    'core/separator',
    'acf/contact-details',
    "acf/button",
);

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-accordion-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-accordion';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Setting the default template for this template block
$template = array(
	array('core/paragraph', array(
		'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
	)),
	array('core/paragraph', array(
		'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
	)),
);

// Load values and adding defaults.
$accordionTitle = get_field('accordion_title') ?: 'Accordion Title';

if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-accordion.jpg" alt="Preview of the Accordion Block.">';
    echo '</figure>';
else:

echo '<div id="'.esc_attr($id).'" class="'.esc_attr($className).'">';
    echo '<button class="accordion-head button-minimal">';
        echo '<h4 class="accordion-title">'.$accordionTitle.'</h4>';
    echo '</button>';
    echo '<div class="accordion-body">';
        echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
    echo '</div>';
echo '</div>';

endif;