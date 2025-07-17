<?php
global $ql_custom_post_types_arr;
$currentPostType = get_post_type();

$args = wp_parse_args(
    $args,
    array(
        'class'          => '',
        'template_data' => array(
            'postfix' => '',
            'options_page' => false,
        ),
    )
);

// Store true if we're on an archive page, store false for anything else
$isArchive = is_post_type_archive( $ql_custom_post_types_arr ) || is_home() || is_tag() || is_tax() || is_category();

$postFix = $args['template_data']['postfix'];
$hasPostFix = isset($postFix);

$isOptionsPage = $args['template_data']['options_page'];


// If the template part has been given an argument for a postfix and is an options page
if( $hasPostFix && $isOptionsPage && have_rows( 'flexible_content_blocks_' . $postFix, 'options') ):
    
    // Loop through rows.
    while ( have_rows( 'flexible_content_blocks_' . $postFix, 'options' ) ) : the_row();

       // Case: Title Block.
       if( get_row_layout() == 'title_block' ): 
           
           get_template_part('content-parts/flexible-content-blocks/blocks/title', 'block');

       // Case: Rich Text Block.
       elseif( get_row_layout() == 'rich_text_block' ): 

           get_template_part('content-parts/flexible-content-blocks/blocks/rich-text', 'block');

       // Case: Button Block.
       elseif( get_row_layout() == 'button_block' ): 

           get_template_part('content-parts/flexible-content-blocks/blocks/button', 'block');

       endif;

   // End loop.
   endwhile;
   

// If the template part has been given an argument for a postfix
elseif( $hasPostFix && have_rows( 'flexible_content_blocks_' . $postFix ) ):
    
    // Loop through rows.
    while ( have_rows( 'flexible_content_blocks_' . $postFix ) ) : the_row();

       // Case: Title Block.
       if( get_row_layout() == 'title_block' ): 
           
           get_template_part('content-parts/flexible-content-blocks/blocks/title', 'block');

       // Case: Rich Text Block.
       elseif( get_row_layout() == 'rich_text_block' ): 

           get_template_part('content-parts/flexible-content-blocks/blocks/rich-text', 'block');

       // Case: Button Block.
       elseif( get_row_layout() == 'button_block' ): 

           get_template_part('content-parts/flexible-content-blocks/blocks/button', 'block');

       endif;

   // End loop.
   endwhile;


// If this is NOT an archive, check if flexible content exists.
elseif( !$isArchive && have_rows( 'flexible_content_blocks' ) ):

    // Loop through rows.
    while ( have_rows( 'flexible_content_blocks' ) ) : the_row();

        // Case: Title Block.
        if( get_row_layout() == 'title_block' ): 
            
            get_template_part('content-parts/flexible-content-blocks/blocks/title', 'block');

        // Case: Rich Text Block.
        elseif( get_row_layout() == 'rich_text_block' ): 

            get_template_part('content-parts/flexible-content-blocks/blocks/rich-text', 'block');

        // Case: Button Block.
        elseif( get_row_layout() == 'button_block' ): 

            get_template_part('content-parts/flexible-content-blocks/blocks/button', 'block');

        endif;

    // End loop.
    endwhile;

// If this is an archive, check if flexible content exists.
elseif( $isArchive && have_rows( 'flexible_content_blocks_' . $currentPostType, 'options' ) ):

    // Loop through rows.
    while ( have_rows( 'flexible_content_blocks_' . $currentPostType, 'options' ) ) : the_row();

        // Case: Title Block.
        if( get_row_layout() == 'title_block' ): 
            
            get_template_part('content-parts/flexible-content-blocks/blocks/title', 'block');

        // Case: Icon & Title Block.
        elseif( get_row_layout() == 'icon_title_block' ): 
            
            get_template_part('content-parts/flexible-content-blocks/blocks/icon-title', 'block');

        // Case: Rich Text Block.
        elseif( get_row_layout() == 'rich_text_block' ): 

            get_template_part('content-parts/flexible-content-blocks/blocks/rich-text', 'block');

        // Case: Button Block.
        elseif( get_row_layout() == 'button_block' ): 

            get_template_part('content-parts/flexible-content-blocks/blocks/button', 'block');

        endif;

    // End loop.
    endwhile;

// No value.
else :
    // Do nothing
endif;
?>