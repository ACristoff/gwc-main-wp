<?php

/**
 * Container Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-container-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-container';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Setting the default template for this template block
$template = array(
	array('core/heading', array(
		'level' => 2,
		'content' => 'H2 Headline Text',
	)),
    array('core/paragraph', array(
		'content' => 'Duis aute irure dolor in reprehenderit in uienply voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat norin proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	)),
	array('core/paragraph', array(
		'content' => 'Ut enim ad minim veniam, quis nostrud ullamco poriti laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in uienply velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat norin proident, sunt in culpa qui officia deserunt mollit anim id est.',
	)),
);

// ----------------------------- Variables ----------------------------- //
$maxWidth = get_field('container_max_width');
$alignment = get_field('container_alignment');
$classNameInner = 'ql-container-inner';

// Background color
$addBackground = get_field('add_background_color');
$background_color_hex = get_field('background_color');

if($addBackground) {
	$classNameInner .= ' has-background';
}
if( $maxWidth ) {
    $style = 'style="max-width:'.$maxWidth.'px;"';
}

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-container.jpg" alt="Preview of the Container Block.">';
    echo '</figure>';
else:
    
echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className).' '.$alignment.'" '.$style.'>';
	if($addBackground) {
		echo '<div class="ql-container-bg-container" style="background-color:#'.$background_color_hex.';"></div>';
	}
	echo '<div class="'. esc_attr($classNameInner).'">';
		echo '<InnerBlocks template="' . esc_attr( wp_json_encode( $template ) ) . '" templateLock="false" />';
	echo '</div>';
echo '</div>';

endif;