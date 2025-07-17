<?php
/*
** Call-To-Action Block Template
*/

$args = wp_parse_args(
    $args,
    array(
        'post_type' => '',
    )
);

$currentPostType = $args['post_type'];
global $ql_custom_post_types_arr;

$richTextDefault = '<h2>Call-To-Action Title Goes Here</h2><p>Add a description to your call-to-action.</p>';
$linkDefaultArray = array(
    'title' => 'CTA Link Here',
    'url' => '#',
    'target' => '',
);

// Store true if we're on an archive page, store false for anything else
$isArchive = is_post_type_archive( $ql_custom_post_types_arr ) || is_home() || is_tag() || is_tax() || is_category();
$fieldName = 'rcb_cta_block';

if( $isArchive ) {
    $fieldName = $currentPostType.'_cta_rcb_cta_block';
}

// ----------------------------- For archive pages ----------------------------- //
if( $isArchive && have_rows( $fieldName, 'options' ) ):
    while ( have_rows( $fieldName, 'options' ) ) : the_row();

        // Load values.
        $hideBlock = get_sub_field('rcb_cta_hide_block');

        if(!$hideBlock) {
            $richText = get_sub_field('rcb_cta_rich_text') ?: $richTextDefault;
            $link = get_sub_field('rcb_cta_url') ?: $linkDefaultArray;
            $bgColour = get_sub_field('rcb_cta_background_colour') ?: '36,89,149';
            $bgImageUrl = get_sub_field('rcb_cta_background_image');
            $bgImageUrlStripped = str_replace(site_url(), "", $bgImageUrl);

            if($bgImageUrl) {
                $bgColourOutputStyle = ' background-color: rgba('.$bgColour.',0.80);';
            } else {
                $bgColourOutputStyle = ' background-color: rgba('.$bgColour.',1);';
            }

            if( $bgImageUrl ) {
                $bgImageStyle = ' background-image: url('.$bgImageUrl.'); background-repeat: no-repeat; background-size: cover; background-position: center;';
                $className .= ' has-background-image';
            }

            // Output
            echo '<div class="rcb-cta align-full" style="'.$bgImageStyle.'">';
                echo '<div class="rcb-cta-color-overlay" style="'.$bgColourOutputStyle.'"></div>';
                echo '<div class="rcb-cta-inner bg-dark">';
                    if($richText) {
                        echo $richText;
                    }
                    if($link) {
                        echo '<a href="'.$link['url'].'" class="button" target="'.$link['target'].'">'.$link['title'].'</a>';
                    }
                echo '</div>';
            echo '</div>';
        }

    endwhile;

// ----------------------------- For normal pages ----------------------------- //
elseif( have_rows( $fieldName ) ):
    while ( have_rows( $fieldName ) ) : the_row();

        // Load values.
        $hideBlock = get_sub_field('rcb_cta_hide_block');

        if(!$hideBlock) {
            $richText = get_sub_field('rcb_cta_rich_text') ?: $richTextDefault;
            $link = get_sub_field('rcb_cta_url') ?: $linkDefaultArray;
            $bgColour = get_sub_field('rcb_cta_background_colour') ?: '36,89,149';
            $bgImageUrl = get_sub_field('rcb_cta_background_image');
            $bgImageUrlStripped = str_replace(site_url(), "", $bgImageUrl);

            if($bgImageUrl) {
                $bgColourOutputStyle = ' background-color: rgba('.$bgColour.',0.80);';
            } else {
                $bgColourOutputStyle = ' background-color: rgba('.$bgColour.',1);';
            }

            if( $bgImageUrl ) {
                $bgImageStyle = ' background-image: url('.$bgImageUrl.'); background-repeat: no-repeat; background-size: cover; background-position: center;';
                $className .= ' has-background-image';
            }

            // Output
            echo '<div class="rcb-cta align-full" style="'.$bgImageStyle.'">';
                echo '<div class="rcb-cta-color-overlay" style="'.$bgColourOutputStyle.'"></div>';
                echo '<div class="rcb-cta-inner bg-dark">';
                    if($richText) {
                        echo $richText;
                    }
                    if($link) {
                        echo '<a href="'.$link['url'].'" class="button" target="'.$link['target'].'">'.$link['title'].'</a>';
                    }
                echo '</div>';
            echo '</div>';
        }

    endwhile;
endif;
