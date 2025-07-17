<?php

/**
 * Icon Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-social-media-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-social-media';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Load values and adding defaults.
$iconColour = get_field('icon_colour');
$instagram = get_field('instagram');
$facebook = get_field('facebook');
$linkedin = get_field('linkedin');
$x = get_field('x');
$email = get_field('email');

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-social-media.jpg" alt="Preview of the Social Media Block.">';
    echo '</figure>';
else:

    if( $facebook || $instagram || $linkedin || $x || $email ):
    echo '<div id="'.esc_attr($id).'" class="'.esc_attr($className) . ' ' . $iconColour . '">';

    echo '<ul class="ql-social-media-list">';
            if( !$facebook['hide'] ):
                echo '<li><a target="_blank" rel="noopener" href="' . $facebook['url'] .'"><div class="svg-logo facebook">' . file_get_contents(get_stylesheet_directory() . '/assets/logos/facebook-logo.svg') . '</div></a></li>';
            endif;
            if( !$x['hide'] ):
                echo '<li><a target="_blank" rel="noopener" href="' . $x['url'] .'"><div class="svg-logo x">' . file_get_contents(get_stylesheet_directory() . '/assets/logos/x-logo.svg') . '</div></a></li>';
            endif;
            if( !$linkedin['hide'] ):
                echo '<li><a target="_blank" rel="noopener" href="' . $linkedin['url'] .'"><div class="svg-logo linkedin">' . file_get_contents(get_stylesheet_directory() . '/assets/logos/linkedin-logo.svg') . '</div></a></li>';
            endif;
            if( !$instagram['hide'] ):
                echo '<li><a target="_blank" rel="noopener" href="' . $instagram['url'] .'"><div class="svg-logo instagram">' . file_get_contents(get_stylesheet_directory() . '/assets/logos/instagram-logo.svg') . '</div></a></li>';
            endif;
            if( !$email['hide'] ):
                echo '<li><a target="_blank" rel="noopener" href="mailto:' . $email['url'] .'"><div class="svg-logo email">' . file_get_contents(get_stylesheet_directory() . '/assets/logos/email-logo.svg') . '</div></a></li>';
            endif;
        echo '</ul>';

    echo '</div>';
    endif;

endif;