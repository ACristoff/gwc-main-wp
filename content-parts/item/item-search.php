<?php
do_action( 'genesis_before_entry' );


genesis_markup(
    [
        'open'    => '<article %s>',
        'context' => 'entry',
    ]
);

    do_action( 'genesis_entry_header' );

    genesis_markup(
        [
            'open'    => '<div %s>',
            'context' => 'entry-content',
        ]
    );

    do_action( 'ql_excerpt_hook' );

    echo modify_read_more_link('search-template');

    genesis_markup(
        [
            'close'   => '</div>',
            'context' => 'entry-content',
        ]
    );
    
genesis_markup(
    [
        'close'   => '</article>',
        'context' => 'entry',
    ]
);

do_action( 'genesis_after_entry' );
