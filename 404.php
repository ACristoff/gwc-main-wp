<?php
/**
 * GWC Theme.
 *
 * This file represents the 404 page template for the GWC Theme.
 *
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// add 'not-found' class to site-inner
function ql_site_inner_attr( $attributes ) {

    // Add a class of 'full' for styling this .site-inner differently
    $attributes['class'] .= ' not-found';
    
    // Add the attributes from .entry, since this replaces the main entry
    $attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
    
    return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'ql_site_inner_attr' );
add_filter( 'genesis_search_text', 'ql_search_text_srp' );


// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message.
 *
 * @since 1.6
 */
function genesis_404() {

	genesis_markup(
		[
			'open'    => '<article class="entry">',
			'context' => 'entry-404',
		]
	);

	genesis_markup(
		[
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => apply_filters( 'genesis_404_entry_title', __( 'Not found, error 404', 'genesis' ) ),
			'context' => 'entry-title',
		]
	);

	$genesis_404_content = sprintf(
		/* translators: %s: URL for current website. */
		__( 'The page you are looking for no longer exists.<br><br> Perhaps you can return back to the <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis' ),
		esc_url( trailingslashit( home_url() ) )
	);

	$genesis_404_content = sprintf( '<p>%s</p>', $genesis_404_content );

	/**
	 * The 404 content (wrapped in paragraph tags).
	 *
	 * @since 2.2.0
	 *
	 * @param string $genesis_404_content The content.
	 */
	$genesis_404_content = apply_filters( 'genesis_404_entry_content', $genesis_404_content );

	genesis_markup(
		[
			'open'    => '<div %s>',
			'close'   => '</div>',
			'content' => $genesis_404_content . get_search_form( 0 ),
			'context' => 'entry-content',
		]
	);

	genesis_markup(
		[
			'close'   => '</article>',
			'context' => 'entry-404',
		]
	);

}

genesis();
