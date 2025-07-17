<?php
// ----------------------------- Customizations ----------------------------- //

// Store the current post type in a variable
$currentPostType = get_post_type();
// If it's an archive, get_post_type() won't work. Do this instead and overwrite $currentPostType:
if(!$currentPostType): $currentPostType = $wp_query->queried_object->name; endif;

// Add Custom Micro Data To Specific Pages In Genesis
add_filter( 'genesis_attr_entry', 'ql_microdata_schema' );
// Customizing post entry meta header
add_filter( 'genesis_post_info', 'ql_post_info_filter' );
// Function to modify the length of post excerpts to 30 words
add_filter( 'excerpt_length', 'ql_excerpt_length' );
// Adding trailing dots to excerpts
add_filter('excerpt_more', 'ql_excerpt_trailing_dots');
// Adding the featured post class to entries in this archive
add_filter( 'genesis_attr_entry', 'ql_featured_post_class' );

// If there are no posts in this archive, add a 'no-content' class to the archive-post-grid
if( !have_posts() ): $addClasses = ' no-content'; else: $addClasses = ''; endif;

// ----------------------------- Output ----------------------------- //
echo '<section class="main-content main-archive">';

    // Archive Search & Filter Form
    if( $currentPostType == 'blog_post' ):
    echo '<div class="archive-filter-form">';
            echo do_shortcode('[searchandfilter slug="press-blog"]');
    echo '</div>';
    endif;

    // Archive list containing all posts
    echo '<div class="archive-post-grid' . $addClasses .'">';

        // The loop
        if( have_posts() ):
            while ( have_posts() ) : the_post();

                get_template_part('content-parts/item/item', 'archive');
                
            endwhile;
        else: get_template_part('content-parts/item/item', 'empty'); 
        endif; wp_reset_query();

        // Pagination for this archive
        $total_pages = $wp_query->max_num_pages;
    
        if ($total_pages > 1){
    
            $current_page = max(1, get_query_var('paged'));
    
            $pages = paginate_links(array(
                'base'         => get_pagenum_link(1) . '%_%',
                'current'      => $current_page,
                'total'        => $total_pages,
                'prev_text'    => '<i class="fas fa-arrow-left"></i>',
                'next_text'    => '<i class="fas fa-arrow-right"></i>',
                'type'         => 'array',
            ));
    
            echo '<div class="pagination-wrap">';
                echo '<ul class="pagination archive-pagination">';
    
                // Print a list item for each page
                foreach ( $pages as $page ) {
                    echo '<li>' . $page . '</li>';
                }
    
                echo '</ul>';
            echo '</div>';
        }
        
    echo '</div>';

    if( $currentPostType == 'blog_post' ) {
        get_template_part('content-parts/reusable-content-blocks/rcb', 'cta', array(
            'post_type' => $currentPostType,
        )); 
    }

echo '</section>';