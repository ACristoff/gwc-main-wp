<?php
/**
 * 
 * Contact Details Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-contact-details-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-contact-details';
if( !empty($block['className']) ) {
    $className .= $block['className'];
}

// ----------------------------- Variables ----------------------------- //
$phone = get_field('phone_number');
$phoneSanitized = preg_replace('/[^0-9]/', '', $phone);
$email = get_field('email');
$directions = get_field('directions_url');


// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-contact-details.jpg" alt="Preview of the Contact Details Block.">';
    echo '</figure>';
else:

echo '<div id="' . esc_attr($id) . '" class="'. esc_attr($className) .'">';
    echo '<ul>';
    if( $phone ):
        echo '<li class="contact-phone">Call us on <a href="tel:'.$phoneSanitized.'">'.$phone.'</a></li>';
    endif;
    if( $email ):
        echo '<li class="contact-email"><a href="mailto:'.$email.'">Send us an email</a></li>';
    endif;
    if( $directions ):
        echo '<li class="contact-directions"><a href="'.$directions.'" target="_blank">Get directions</a></li>';
    endif;
    echo '</ul>';
echo '</div>';

endif;