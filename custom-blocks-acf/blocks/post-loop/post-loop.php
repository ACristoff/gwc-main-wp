<?php

/**
 * Post Loop Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" and "align" values.
$id = 'ql-post-loop-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$className = 'acf-block ql-post-loop';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// ----------------------------- Variables ----------------------------- //
$blockSettings = get_field('block_settings');
$loopSettings = get_field('loop_settings');
$postsPerPage = $loopSettings['posts_per_page'] ?: 3;

$args = array(
    'post_type' => 'blog_post',
    'posts_per_page' => $postsPerPage,
);

$loop = new WP_Query($args);

// Variables
$marginTopValue = $blockSettings['margin_top'];
$marginBottomValue = $blockSettings['margin_bottom'];

if( $marginTopValue ) {
    $marginTop = ' margin-top: '.$marginTopValue.'px;';
} 
if( $marginBottomValue ) {
    $marginBottom = ' margin-bottom: '.$marginBottomValue.'px;';
}


// ----------------------------- Output ----------------------------- //
if( !empty( $block['data']['_is_preview'] ) ):
    echo '<figure style="margin:0;">';
        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/block-previews/block-preview-post-loop.jpg" alt="Preview of the Post Loop.">';
    echo '</figure>';
else:

echo '<div id="'. esc_attr($id) .'" class="'. esc_attr($className) .'" style="'.$marginTop.$marginBottom.'">';

    if( !is_admin() ):
        // Loop grid
        echo '<div class="ql-loop-grid archive-post-grid single-column-archive-grid">';
        
            // The loop
            if( $loop->have_posts() ):
                while ( $loop->have_posts() ) : $loop->the_post();
                    // Add custom micro data
                    add_filter( 'genesis_attr_entry', 'ql_microdata_schema' );
                    // Customizing post entry meta header
                    add_filter( 'genesis_post_info', 'ql_post_info_filter' );
                    // Function to modify the length of post excerpts to 30 words
                    add_filter( 'excerpt_length', 'ql_excerpt_length' );
                    // Adding trailing dots to excerpts
                    add_filter('excerpt_more', 'ql_excerpt_trailing_dots');
                    // Add post title back into loop
                    add_action( 'genesis_entry_header', 'ql_entry_title');

                    get_template_part('content-parts/item/item', 'archive');
                    
                endwhile;

            else: get_template_part('content-parts/item/item', 'empty');  

            endif; wp_reset_postdata();

            // reset the main query object to avoid unexpected results on other parts of the page   
            wp_reset_query();
            
        echo '</div>';

    else:
        echo '<div class="ql-editor-preview">';
            echo '<figure class="editor-preview-image"><img src="' . esc_url( get_stylesheet_directory_uri() . '/assets/block-previews/editor-preview-post-loop.jpg' ) . '" alt="editor block preview"></figure>';

        echo '</div>';
    endif;

echo '</div>';

endif;