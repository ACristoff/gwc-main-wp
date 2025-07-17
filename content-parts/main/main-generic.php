<?php
// ----------------------------- Customizations ----------------------------- //

// Remove the entry title 
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
// Remove the entry header markup
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

add_filter ( 'genesis_edit_post_link' , '__return_false' );

if( !get_the_content() ): $addClasses = ' no-content'; else: $addClasses = ''; endif;

// ----------------------------- Output ----------------------------- //

echo '<section class="main-content main-generic' . $addClasses . '">';
 
    if( get_the_content() ):

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
        echo '<p>This page has no content.</p>';
    endif;

    if ( is_user_logged_in() ):
        edit_post_link( __( 'Edit this page', 'textdomain' ));
    endif;
    
echo '</section>';