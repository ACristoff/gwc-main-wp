<?php
// ----------------------------- Customizations ----------------------------- //

// Function to modify the length of post excerpts to 30 words
add_filter( 'excerpt_length', 'ql_excerpt_length' );
// Adding trailing dots to excerpts
add_filter('excerpt_more', 'ql_excerpt_trailing_dots');
// Printing what type of search result is being display for more context
// add_action( 'genesis_entry_header', 'ql_print_type_of_search_result');
add_filter( 'genesis_search_text', 'ql_search_text_srp' );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


// Generate a custom title for the search results page
$searchDescription = sprintf( '<p class="search-results-description">%s %s<strong>%s</strong>%s</p>', $wp_query->found_posts, apply_filters( 'genesis_search_title_text', __( 'search results for "', 'genesis' ) ), get_search_query(), '"' );

if( !get_search_query() ) {
    $searchDescription = 'Start your search below.';
}

// Variables
if( !have_posts() ): $addClasses = ' no-content no-search-results'; else: $addClasses = ''; endif;

// ----------------------------- Output ----------------------------- //
echo '<section class="main-content main-search">';

    echo '<div class="search-results-header text-center">';
        echo '<h1>Search Results</h1>';
        echo $searchDescription;
        echo '<div class="search-form-wrap">';
            get_search_form();
        echo '</div>';
    echo '</div>';

    
    // Archive list containing all posts
    echo '<div class="search-results-grid'.$addClasses.'">';

        // The loop
        if( have_posts() ):
            while ( have_posts() ) : the_post();

                wc_get_template_part( 'content', 'product' );
                // get_template_part('content-parts/item/item', 'search');
                
            endwhile;
        else: 
            get_template_part('content-parts/item/item', 'empty', array( 
                'error_icon' => '<i class="fa-solid fa-shop-slash fa-3x"></i>',
                'error_message' => 'Sorry, it looks like there are no products that match your criteria.',
            ));
        endif; wp_reset_query();

        // Pagination for this archive
        $total_pages = $wp_query->max_num_pages;

        if ($total_pages > 1){
    
            $current_page = max(1, get_query_var('paged'));
    
            $pages = paginate_links(array(
                // 'base'         => get_pagenum_link(1) . '%_%',
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

    do_action('ql_search_page_featured_collections');

echo '</section>';