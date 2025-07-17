<?php

/**
 * 
 * Button Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-button-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'ql-button';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// ----------------------------- Variables ----------------------------- //
// Load values.
$buttonDefaultArray = array(
    'title' => 'Button Text Here',
    'url' => '#',
    'target' => '',
);
$buttonArray = get_field('button') ?: $buttonDefaultArray;
$buttonStyle = get_field('button_style');
$buttonIcon = get_field('button_icon');
$buttonColour = get_field('button_colour');
$buttonOutlined = get_field('button_outlined') ?: 'no';
$buttonDisplay = get_field('button_display') ?: 'ql-button-display-block';
$buttonAlignment = get_field('button_alignment') ?: 'button-left';

if($buttonOutlined === 'yes'){$className .= ' ql-button-outlined';}
if($buttonColour){$className .= ' ' . $buttonColour;}
if($buttonIcon){$className .= ' ' . $buttonIcon;}

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-button.jpg" alt="Preview of the Button Block.">';
    echo '</figure>';
else:

echo '<div id="' . esc_attr($id) . '" class="' . esc_attr($className) .' '. $buttonAlignment .' '. $buttonStyle .' '. $buttonDisplay .'">';
    echo '<a href="' . $buttonArray["url"] . '" class="ql-button-link" target="' . $buttonArray["target"] . '">' . $buttonArray["title"] . '</a>';
echo '</div>';

endif;