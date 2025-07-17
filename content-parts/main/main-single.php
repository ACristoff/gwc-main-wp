<?php
// ----------------------------- Customizations ----------------------------- //
$exclusive_post = get_field('blog_post_exclusive_brand_post');
$rolex_post_banner_image = get_field('blog_post_rolex_post_banner');
$rolex_post_banner_image_mobile = get_field('blog_post_rolex_post_banner_mobile');

// Relocation entry post info above featured image
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
if( get_post_type() !== 'blog_post' ) {
    add_action( 'genesis_entry_header', 'genesis_post_info', 1 );
}

// Add Custom Micro Data To Specific Pages In Genesis
add_filter( 'genesis_attr_entry', 'ql_microdata_schema' );
// Customizing post entry meta header
add_filter( 'genesis_post_info', 'ql_post_info_filter' );

//* Remove the entry title and entry post meta (this is for single 'post' posts)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_filter ( 'genesis_edit_post_link' , '__return_false' );


if( !get_the_content() ): $addClasses = ' no-content'; else: $addClasses = ''; endif;

// ----------------------------- Output ----------------------------- //


echo '<section class="main-content main-single' . $addClasses . '">';

    if( get_the_content() ):

        // Exclusive post logo
        if( get_post_type() == 'blog_post' && $exclusive_post == 'rolex-post' ):
            echo '<figure class="exclusive-post-logo"><img src="'.get_stylesheet_directory_uri().'/assets/logos/rolex-logo.png" alt="Rolex Official Logo"></figure>';
        elseif( get_post_type() == 'blog_post' && $exclusive_post == 'tudor-post' ):
            echo '<figure class="exclusive-post-logo"><img src="'.get_stylesheet_directory_uri().'/assets/logos/tudor-logo.png" alt="Tudor Official Logo"></figure>';
        endif;

        // Exclusive Rolex post banner
        if( get_post_type() == 'blog_post' && $exclusive_post == 'rolex-post' && $rolex_post_banner_image ):
            echo '<div class="rolex-post-banner-image align-full no-pad'; if(!$rolex_post_banner_image_mobile): echo ' no-mobile-banner-image">'; else: echo '">'; endif; 
            echo wp_get_attachment_image( $rolex_post_banner_image, 'full' ) . '</div>';
        endif;
        if( get_post_type() == 'blog_post' && $exclusive_post == 'rolex-post' && $rolex_post_banner_image_mobile ):
            echo '<div class="rolex-post-banner-image mobile align-full no-pad">' . wp_get_attachment_image( $rolex_post_banner_image_mobile, 'full' ) . '</div>';
        endif;

        do_action( 'genesis_before_while' );

            do_action( 'genesis_before_entry' );

            genesis_markup(
                [
                    'open'    => '<article %s>',
                    'context' => 'entry',
                ]
            );

            do_action( 'genesis_entry_header' );

            do_action( 'genesis_before_entry_content' );

            genesis_markup(
                [
                    'open'    => '<div %s>',
                    'context' => 'entry-content',
                ]
            );
  
            do_action( 'genesis_entry_content' );
            genesis_markup(
                [
                    'close'   => '</div>',
                    'context' => 'entry-content',
                ]
            );

            do_action( 'genesis_after_entry_content' );

            do_action( 'genesis_entry_footer' );

            genesis_markup(
                [
                    'close'   => '</article>',
                    'context' => 'entry',
                ]
            );

            do_action( 'genesis_after_entry' );


        do_action( 'genesis_after_endwhile' );

    else:
        echo '<p>This post has no content.</p>';
    endif;
    
    if ( is_user_logged_in() ):
        edit_post_link( __( 'Edit this post', 'textdomain' ));
    endif;
    
echo '</section>';