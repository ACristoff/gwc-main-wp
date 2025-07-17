<?php

/**
 * YouTube Embed Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-youtube-embed-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-youtube-embed wp-embed-aspect-16-9 wp-has-aspect-ratio';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Load values and adding defaults.
$embed_type = get_field('embed_type');
$youtube_url = get_field('youtube_url');
$iframe_code = get_field('iframe_code');
$video_caption = get_field('video_caption');

if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-youtube-embed.jpg" alt="Preview of the YouTube Embed Block.">';
    echo '</figure>';
else:

echo '<div id="'.esc_attr($id).'" class="'.esc_attr($className).'">';

    if( $embed_type == 'url' && $youtube_url ):
        echo '<div class="ql-youtube-embed-container" data-youtube-url="'.$youtube_url.'">';
            echo '<div id="youtube-player"></div>';
        echo '</div>';
    elseif( $embed_type == 'iframe' && $iframe_code ):
        echo '<div class="ql-youtube-embed-container" data-youtube-url="'.$youtube_url.'">';
            echo '<div id="youtube-player">';
                echo $iframe_code;
            echo '</div>';
        echo '</div>';
    else:
        echo '<div class="ql-youtube-embed-empty"></div>';
    endif;

    // Caption
    if( $video_caption ):
        echo '<p class="caption">'.$video_caption.'</p>';
    endif;
echo '</div>';

endif;