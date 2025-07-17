<?php
/**
 * GWC Theme.
 *
 * This file represents the search page template for the GWC Theme.
 *
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

get_header();

/**
 * Fires after the header, before the content sidebar wrap.
 *
 * @since 1.0.0
 */
do_action( 'genesis_before_content_sidebar_wrap' );

genesis_markup(
    [
        'open'    => '<div %s>',
        'context' => 'content-sidebar-wrap',
    ]
);

    /**
     * Fires before the content, after the content sidebar wrap opening markup.
     *
     * @since 1.0.0
     */
    do_action( 'genesis_before_content' );

    genesis_markup(
        [
            'open'    => '<main %s>',
            'context' => 'content',
        ]
    );

        /**
         * Fires before the loop hook, after the main content opening markup.
         *
         * @since 1.0.0
         */
        do_action( 'genesis_before_loop' );

        /**
         * Fires to display the loop contents.
         *
         * @since 1.1.0
         */
        // Removing default genesis loop and adding custom content
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        add_action( 'genesis_loop', 'ql_do_content' );
        do_action( 'genesis_loop' );

        /**
         * Fires after the loop hook, before the main content closing markup.
         *
         * @since 1.0.0
         */
        do_action( 'genesis_after_loop' );

    genesis_markup(
        [
            'close'   => '</main>', // End .content.
            'context' => 'content',
        ]
    );

    /**
     * Fires after the content, before the main content sidebar wrap closing markup.
     *
     * @since 1.0.0
     */
    do_action( 'genesis_after_content' );

genesis_markup(
    [
        'close'   => '</div>',
        'context' => 'content-sidebar-wrap',
    ]
);

/**
 * Fires before the footer, after the content sidebar wrap.
 *
 * @since 1.0.0
 */
do_action( 'genesis_after_content_sidebar_wrap' );

get_footer();