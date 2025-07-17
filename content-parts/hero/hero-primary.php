<?php
/**
 * GWC Theme.
 *
 * This file adds the primary hero content the GWC Theme.
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
 */

$index = 0;

echo '<section class="hero-primary">';

    if( have_rows( 'hero_slides' ) ):
    echo '<div class="hero-slider">';
        while ( have_rows( 'hero_slides' ) ) : the_row();

        echo' <div class="hero-slide">';
            // Variables
            $heroTitle = get_sub_field('slide_title') ?: 'Slide Title Placeholder' ;
            $heroLabel = get_sub_field('slide_label');
            $heroBgFileType = get_sub_field('slide_background_file_type');
            $heroBgImage = get_sub_field('slide_background_image');
            $heroBgImageUrl = wp_get_attachment_image_url($heroBgImage, 'full');
            $heroBgImageMobile = get_sub_field('slide_background_image_mobile');
            $heroBgImageMobileUrl = wp_get_attachment_image_url($heroBgImageMobile, 'full');
            $contentAlignment = get_sub_field('slide_content_alignment') ?: 'left';
            $contentAlignmentMobile = get_sub_field('slide_content_alignment_mobile') ?: 'center';
// TODO mobile alignment

            $heroBgVideoDesktop = get_sub_field('slide_background_video_desktop');
            $heroBgVideoPosterDesktop = get_sub_field('slide_background_video_poster_desktop');
            $heroBgVideoMobile = get_sub_field('slide_background_video_mobile');
            $heroBgVideoPosterMobile = get_sub_field('slide_background_video_poster_mobile');

            // Background video/image
            if( $heroBgFileType == 'image' && $heroBgImage && $heroBgImageMobile ):

                // Get the attachment metadata
                $heroBgImageMetadata = wp_get_attachment_metadata($heroBgImage);
                $width = $heroBgImageMetadata['width'];
                $height = $heroBgImageMetadata['height'];
    
                echo '<div class="hero-background-wrap">';
                    echo wp_get_attachment_image( $heroBgImage, 'full', '', ["class" => "hero-background-img", "data-src-mobile" => $heroBgImageMobileUrl, "data-src-desktop" => $heroBgImageUrl, "data-original-width" => $width, "data-original-height" => $height] );
                echo '</div>';

            elseif( $heroBgFileType == 'video' ):
                echo '<div class="hero-background-wrap">';
                    echo '<video autoplay muted defaultMuted playsinline loop preload="none" class="hero-background-video" data-src-mobile="'.$heroBgVideoMobile[ 'url' ].'" data-src-desktop="'.$heroBgVideoDesktop[ 'url' ].'" data-poster-mobile="'.$heroBgVideoPosterMobile.'" data-poster-desktop="'.$heroBgVideoPosterDesktop.'">';
                    echo '</video>';
                echo '</div>';
            else: 
                echo '<div class="hero-background-wrap">' . wp_get_attachment_image( '9066', 'full', '', ["class" => "hero-background-img"] ) . '</div>';
            endif;

            echo '<div class="hero-content-wrap mobile-align-'.$contentAlignmentMobile.'">';
                echo '<div class="hero-content text-center align-'.$contentAlignment.'">';

                    // Page label
                    if($heroLabel):
                        echo '<h6>' . $heroLabel . '</h6>';
                    endif;

                    // Page title
                    if($index == 0):
                        echo '<h1>' . $heroTitle . '</h1>';
                    else:
                        echo '<h2>' . $heroTitle . '</h2>';
                    endif;

                    // Page description
                    get_template_part('content-parts/flexible-content-blocks/flexible', 'content');

                echo '</div>';
            echo '</div>';
            
        echo '</div>';

        $index++;

        endwhile;

        echo '</div>';
    endif;

    echo '</div>';
echo '</section>';