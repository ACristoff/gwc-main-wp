<?php

/**
 * Interactive Slide Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-interactive-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-interactive-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$slides = get_field('slides');
$sliderTitle = get_field('slider_title');
$blockSettings = get_field('block_settings');
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'];
$paddingTopValue = $blockSettings['padding_top'];
$paddingBottomValue = $blockSettings['padding_bottom'];

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

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-interactive-slider.jpg" alt="Preview of the Interactive Slider Block.">';
    echo '</figure>';
else:

echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className) .' align-full bg-grey_light" style="'.$marginTop.$marginBottom.$paddingTop.$paddingBottom.'">';

    if($sliderTitle): echo '<h2 class="slider-title">'.$sliderTitle.'</h2>'; endif;

    echo '<div class="ql-slider">';
        echo '<ul class="ql-slider-nav">';
        $i = 0;
        foreach( $slides as $slide ):
            if($i === 0) {
                echo '<li class="ql-slide-nav-item item-'.$i.' current">';
                    echo '<h5>'.$slide['slide_title'].'</h5>';
                    echo '<div class="ql-slide-content-item-mobile hide-on-desktop">'.$slide['slide_content'].'</div>';
                echo '</li>';
            } else {
                echo '<li class="ql-slide-nav-item item-'.$i.'">';
                    echo '<h5>'.$slide['slide_title'].'</h5>';
                    echo '<div class="ql-slide-content-item-mobile hide-on-desktop">'.$slide['slide_content'].'</div>';
                echo '</li>';
            }
            $i++;
        endforeach;
        echo '</ul>';

        echo '<ul class="ql-slide-content hide-on-tablet-and-mobile">';
        $i = 0;
        foreach( $slides as $slide ):    
            if($i === 0) {
                echo '<li class="ql-slide-content-item item-'.$i.' current">';
                    echo '<h3 class="ql-slide-title">'.$slide['slide_title'].'</h3>';
                    echo $slide['slide_content'];
                echo '</li>';
            } else {
                echo '<li class="ql-slide-content-item item-'.$i.'">';
                    echo '<h3 class="ql-slide-title">'.$slide['slide_title'].'</h3>';
                    echo $slide['slide_content'];
                echo '</li>';
            }
            $i++;
        endforeach;
        echo '</ul>';
    echo '</div>';
    
echo '</div>';

endif;