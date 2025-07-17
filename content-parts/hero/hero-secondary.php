<?php
/**
 * GWC Theme.
 *
 * This file adds the secondary hero content the GWC Theme.
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
 */

//  Making the CPT array variable global and active for use in this template
global $ql_custom_post_types_arr;

// Store the current post type in a vriable
$currentPostType = get_post_type();

// If it's an archive, get_post_type() won't work. Do this instead and overwrite $currentPostType:
if(!$currentPostType): $currentPostType = $wp_query->queried_object->name; endif;

// Store true if we're on an archive page, store false for anything else
$isOnArchivePage = is_post_type_archive( $ql_custom_post_types_arr ) || is_home() || is_tag() || is_tax() || is_category();
$blogPostTaxonomies = get_object_taxonomies('blog_post');

// Variables for ACF
$heroTitle = get_field('hero_title');
$heroDescription = get_field('hero_description');
$heroBgImage = get_field('hero_background_image');
$defaultHeroBgImage = get_field('default_featured_image_single_post_' . $currentPostType, 'options');
$contentAlignment = get_field('hero_content_alignment') ?: 'left';

// Variables for ACF located inside option pages
$heroTitleOptions = get_field( 'hero_title_' . $currentPostType, 'options' );
$heroDescriptionOptions = get_field( 'hero_description_' . $currentPostType, 'options' );
$heroBgImageOptions = get_field( 'hero_background_image_' . $currentPostType, 'options' );
if( $isOnArchivePage ) { $contentAlignment = get_field( 'hero_content_alignment_' . $currentPostType, 'options' ) ?: 'left'; }


// Check if single post has a featured image / thumbnail attached. Add a class if false
$heroClassNames = '';
if( is_single () && !has_post_thumbnail() ) { $heroClassNames .= ' has-no-thumbnail'; }

// If on account page, add hero-minimal class
if (is_page(array('privacy-policy', 'terms-of-service')) ) { $heroClassNames .= ' hero-minimal'; }

// Output
$exclusive_post = get_field('blog_post_exclusive_brand_post');
if( is_singular('blog_post') && $exclusive_post == 'rolex-post' ):
    // Don't output the hero section
else:
    echo '<section class="hero-secondary'.$heroClassNames.'">';


        // Background image for archive pages 
        if( is_post_type_archive( $ql_custom_post_types_arr ) && $heroBgImageOptions || is_home() && $heroBgImageOptions || is_tax() && $heroBgImageOptions || is_tag() && $heroBgImageOptions ):
            echo '<div class="hero-background-wrap">' . wp_get_attachment_image( $heroBgImageOptions, 'full', '', ["class" => "hero-background-img archive"] ) . '</div>';
            
        elseif( is_post_type_archive( $ql_custom_post_types_arr ) && !$heroBgImageOptions || is_home() && !$heroBgImageOptions || is_tax() && !$heroBgImageOptions || is_tag() && !$heroBgImageOptions ):
            echo '<div class="hero-background-wrap">' . wp_get_attachment_image( '9175', 'full', '', ["class" => "hero-background-img archive"] ) . '</div>';

        // Background image for single posts
        elseif( !is_page() && is_singular( $ql_custom_post_types_arr ) ):

            if( !has_post_thumbnail() && $defaultHeroBgImage ):
                echo '<div class="hero-background-wrap">' . wp_get_attachment_image( $defaultHeroBgImage, 'full', '', ["class" => "hero-background-img"] ) . '</div>';
            else:
                do_action( 'ql_before_entry_header_hook' );
            endif;

        // Background image for remaining pages
        elseif( $heroBgImage ):
            echo '<div class="hero-background-wrap">' . wp_get_attachment_image( $heroBgImage, 'full', '', ["class" => "hero-background-img"] ) . '</div>';

        // Fallback background image
        else: 
            do_action( 'ql_before_entry_header_hook' );
        endif;


        echo '<div class="hero-content-wrap">';
            echo '<div class="hero-content container-extra-narrow text-'.$contentAlignment.' align-'.$contentAlignment.'">';
                    
                // Page title
                if( $heroTitle ):
                    echo '<h1>' . $heroTitle . '</h1>';

                // Custom archive page title
                elseif( is_post_type_archive( $ql_custom_post_types_arr ) && $heroTitleOptions || is_home() && $heroTitleOptions ):
                    echo '<h1>' . $heroTitleOptions . '</h1>';

                // Taxonomy & Category page title
                elseif( is_tax( $blogPostTaxonomies[1] ) ):

                    echo '<h1>Tag: '.$wp_query->queried_object->name.'</h1>';
   
                elseif( is_tax() || is_category() ):

                    if( !$wp_query->queried_object->label ) {
                        echo '<h1>Category: '.$wp_query->queried_object->name.'</h1>';
                    } else {
                        echo '<h1>Category: '.$wp_query->queried_object->label.'</h1>';
                    }

                // Archive page title fallback
                elseif( is_archive() ):

                    if( !$wp_query->queried_object->label ) {
                        echo '<h1>'.$wp_query->queried_object->name.'</h1>';
                    } else {
                        echo '<h1>'.$wp_query->queried_object->label.'</h1>';
                    }

                // Index page title fallback
                elseif( is_home() ):
                    echo '<h1>' . $wp_query->queried_object->post_title . '</h1>';


                // Fallback page title
                else: echo '<h1>' . get_the_title() . '</h1>'; endif;

                
                // Page description
                if( !$isOnArchivePage && $heroDescription ):
                    echo '<p>'.$heroDescription.'</p>';

                // // Archive page description
                elseif( $isOnArchivePage && $heroDescriptionOptions ):
                    echo '<p>'.$heroDescriptionOptions.'</p>';
                    echo '<h2>TEST</h2>';
                endif;

                if( is_singular( array('blog_post') ) ) {
                    add_action( 'ql_after_hero_title_hook', 'genesis_post_info', 5 );
                    add_filter( 'genesis_post_info', 'ql_post_info_filter' );
                    do_action('ql_after_hero_title_hook');
                }
                
            echo '</div>';
        echo '</div>';
        
    echo '</section>';
endif;