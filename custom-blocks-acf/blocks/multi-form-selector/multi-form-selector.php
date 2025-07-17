<?php

/**
 * Multi-Form Selector Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-multi-form-selector-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-multi-form-selector';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . sanitize_title( $block['align'] );
}

// ----------------------------- Variables ----------------------------- //

$form_selection = get_field('form_selection');

// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-multi-form-selector.jpg" alt="Preview of the Multi-Form Selector Block.">';
    echo '</figure>';
else:
    
echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className).'">';

    // Form description/excerpt
    echo '<div class="ql-multi-form-description" id="ql-multi-form-scroll-target">';
    foreach ( $form_selection as $key => $form ):
        if ( $key == 0 ):
            echo '<h3 class="form-title form-'.$form->ID.' active">Contact '.$form->post_title.'</h3>';
            echo '<p class="form-description form-'.$form->ID.' active">'.$form->post_excerpt.'</p>';
        else:
            echo '<h3 class="form-title form-'.$form->ID.'">Contact '.$form->post_title.'</h3>';
            echo '<p class="form-description form-'.$form->ID.'">'.$form->post_excerpt.'</p>';
        endif;
    endforeach;
    echo '</div>';


    echo '<div class="ql-multi-form-selector-wrap">';
        // Forms navigation
        echo '<div class="ql-form-nav-menu">';
        foreach ( $form_selection as $key => $form ):
            echo '<a href="#" class="ql-menu-item '.strtolower($form->post_title).' item-'.$form->ID;
            if ( $key == 0 ): echo ' active'; endif;
            echo '" id="'.$form->ID.'">'.$form->post_title.'</a>';
        endforeach;
        echo '</div>';

        // Forms output
        foreach( $form_selection as $key => $form ):
            echo do_shortcode('[wpforms id="'.$form->ID.'" title="false"]');
        endforeach;

    echo '</div>';
echo '</div>';

endif;