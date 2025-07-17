<?php
/**
 * This file represents the init file for all ACF custom blocks
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
 * */

//  Adding new category 'Custom Blocks' and reordering it to appear at the very top of the block editor
add_filter( 'block_categories', 'checkCategoryOrder', 10, 2 );
function checkCategoryOrder($categories) {
    //custom category array
	$customBlocksCategory = array(
        'slug'  => 'custom-blocks',
        'title' => 'Custom Blocks'
    );
    //new categories array and adding new custom category at first location
    $newCategories = array();
    $newCategories[0] = $customBlocksCategory;

    //appending original categories in the new array
    foreach ($categories as $category) {
        $newCategories[] = $category;
    }

    //return new categories
    return $newCategories;
}


// Initializing the custom acf blocks
add_action('acf/init', 'ql_acf_blocks_init');
function ql_acf_blocks_init() {

    
    // Check function exists.
    if( function_exists('acf_register_block_type') ) {


        /** Registering custom block:
         *
         * ------------ Button ------------
        */
        acf_register_block_type(array(
            'name'              => 'button',
            'title'             => __('Button'),
            'description'       => __('A button for your custom block.'),
            'render_template'   => 'custom-blocks-acf/blocks/button/button.php',
            'category'          => 'custom-blocks',
            'icon'              => 'button',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/button/button.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> false,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('button'),
        ));
                

        /** Registering custom block:
         *
         * ------------ Accordion ------------
        */
        acf_register_block_type(array(
            'name'              => 'accordion',
            'title'             => __('Accordion'),
            'description'       => __('Insert your own custom accordion.'),
            'render_template'   => 'custom-blocks-acf/blocks/accordion/accordion.php',
            'category'          => 'custom-blocks',
            'icon'              => 'arrow-down-alt',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/accordion/accordion.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('text', 'accordion', 'content'),
        ));

        /** Registering custom block:
         *
         * ------------ Container ------------
        */
        acf_register_block_type(array(
            'name'              => 'container',
            'title'             => __('Container'),
            'description'       => __('Control your layout by wrapping it with this container block.'),
            'render_template'   => 'custom-blocks-acf/blocks/container/container.php',
            'category'          => 'custom-blocks',
            'icon'              => 'editor-table',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/container/container.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'keywords' => array('container'),
        ));


        /** Registering custom block:
         *
         * ------------ Spacer ------------
        */
        acf_register_block_type(array(
            'name'              => 'spacer',
            'title'             => __('Spacer'),
            'description'       => __('Add white space between blocks and customise its height.'),
            'render_template'   => 'custom-blocks-acf/blocks/spacer/spacer.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="48" height="48" aria-hidden="true" focusable="false"><path d="M7 18h4.5v1.5h-7v-7H6V17L17 6h-4.5V4.5h7v7H18V7L7 18Z"></path></svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/spacer/spacer.css',
			'enqueue_script'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/spacer/spacer.js',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'keywords' => array('space', 'spacer', 'whitespace'),
        ));

                /** Registering custom block:
         *
         * ------------ Social Media ------------
        */
        acf_register_block_type(array(
            'name'              => 'social-media',
            'title'             => __('Social Media'),
            'description'       => __('Insert a list of social media links so visitors can connect with you.'),
            'render_template'   => 'custom-blocks-acf/blocks/social-media/social-media.php',
            'category'          => 'custom-blocks',
            'icon'              => 'share',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/social-media/social-media.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('social', 'social media', 'connect', 'instagram', 'facebook', 'email', 'mail', 'twitter', 'linkedin'),
        ));


        /** Registering custom block:
         *
         * ------------ YouTube Embed ------------
        */
        acf_register_block_type(array(
            'name'              => 'youtube-embed',
            'title'             => __('YouTube Embed'),
            'description'       => __('Embed a YouTube video'),
            'render_template'   => 'custom-blocks-acf/blocks/youtube-embed/youtube-embed.php',
            'category'          => 'custom-blocks',
            'icon'              => 'youtube',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/youtube-embed/youtube-embed.css',
			'enqueue_script'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/youtube-embed/youtube-embed.js',
			'supports'		=> [
				'align'			=> array( 'center', 'full' ),
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('youtube', 'media', 'video'),
        ));


        /** Registering custom block:
         *
         * ------------ Content Block ------------
        */
        acf_register_block_type(array(
            'name'              => 'content-block',
            'title'             => __('Content Block'),
            'description'       => __('Insert a block of content that is a little more exciting than just text.'),
            'render_template'   => 'custom-blocks-acf/blocks/content-block/content-block.php',
            'category'          => 'custom-blocks',
            'icon'              => 'text',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/content-block/content-block.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'mode' => 'preview',
            'keywords' => array('content block', 'text', 'paragraph', 'heading'),
        ));


        /** Registering custom block:
         *
         * ------------ Image & Text Column ------------
        */
        acf_register_block_type(array(
            'name'              => 'image-text-column',
            'title'             => __('Image & Text Column'),
            'description'       => __('Insert a two column layout with an image and custom blocks.'),
            'render_template'   => 'custom-blocks-acf/blocks/image-text-column/image-text-column.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg width="450" height="425" viewBox="0 0 450 425" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="450" height="425" rx="12" fill="#1E1E1E"/>
                                    <rect x="50" y="50" width="207" height="324" rx="4" fill="white"/>
                                    <rect x="297" y="50" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="142" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="234" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="326" width="103" height="48" rx="4" fill="white"/>
                                    </svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/image-text-column/image-text-column.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('column', 'image', 'text', 'block', 'content'),
        ));


        /** Registering custom block:
         *
         * ------------ Image & Text Column ALT ------------
        */
        acf_register_block_type(array(
            'name'              => 'image-text-column-alt',
            'title'             => __('Image & Text Column ALT'),
            'description'       => __('Insert an alternative two column layout with an image and custom blocks.'),
            'render_template'   => 'custom-blocks-acf/blocks/image-text-column-alt/image-text-column-alt.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg width="450" height="425" viewBox="0 0 450 425" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="450" height="425" rx="12" fill="#1E1E1E"/>
                                    <rect x="50" y="50" width="207" height="324" rx="4" fill="white"/>
                                    <rect x="297" y="50" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="142" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="234" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="326" width="103" height="48" rx="4" fill="white"/>
                                    </svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/image-text-column-alt/image-text-column-alt.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('column', 'image', 'text', 'block', 'content'),
        ));

        /** Registering custom block:
         *
         * ------------ Double Image & Text Column ------------
        */
        acf_register_block_type(array(
            'name'              => 'double-image-text-column',
            'title'             => __('Double Image & Text Column'),
            'description'       => __('Insert an alternative two column layout with two images and custom blocks.'),
            'render_template'   => 'custom-blocks-acf/blocks/double-image-text-column/double-image-text-column.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg width="450" height="425" viewBox="0 0 450 425" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="450" height="425" rx="12" fill="#1E1E1E"/>
                                    <rect x="50" y="50" width="207" height="324" rx="4" fill="white"/>
                                    <rect x="297" y="50" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="142" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="234" width="103" height="48" rx="4" fill="white"/>
                                    <rect x="297" y="326" width="103" height="48" rx="4" fill="white"/>
                                    </svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/double-image-text-column/double-image-text-column.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('column', 'image', 'text', 'block', 'content'),
        ));

        /** Registering custom block:
         *
         * ------------ Post Loop ------------
        */
        acf_register_block_type(array(
            'name'              => 'post-loop',
            'title'             => __('Post Loop'),
            'description'       => __('Insert a list of latest posts.'),
            'render_template'   => 'custom-blocks-acf/blocks/post-loop/post-loop.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="48" height="48" aria-hidden="true" focusable="false">
                                <path d="M18.1823 11.6392C18.1823 13.0804 17.0139 14.2487 15.5727 14.2487C14.3579 14.2487 13.335 13.4179 13.0453 12.2922L13.0377 12.2625L13.0278 12.2335L12.3985 10.377L12.3942 10.3785C11.8571 8.64997 10.246 7.39405 8.33961 7.39405C5.99509 7.39405 4.09448 9.29465 4.09448 11.6392C4.09448 13.9837 5.99509 15.8843 8.33961 15.8843C8.88499 15.8843 9.40822 15.781 9.88943 15.5923L9.29212 14.0697C8.99812 14.185 8.67729 14.2487 8.33961 14.2487C6.89838 14.2487 5.73003 13.0804 5.73003 11.6392C5.73003 10.1979 6.89838 9.02959 8.33961 9.02959C9.55444 9.02959 10.5773 9.86046 10.867 10.9862L10.8772 10.9836L11.4695 12.7311C11.9515 14.546 13.6048 15.8843 15.5727 15.8843C17.9172 15.8843 19.8178 13.9837 19.8178 11.6392C19.8178 9.29465 17.9172 7.39404 15.5727 7.39404C15.0287 7.39404 14.5066 7.4968 14.0264 7.6847L14.6223 9.20781C14.9158 9.093 15.2358 9.02959 15.5727 9.02959C17.0139 9.02959 18.1823 10.1979 18.1823 11.6392Z"></path>
                                </svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/post-loop/post-loop.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('post', 'blog', 'news', 'press', 'query', 'loop', 'archive'),
        ));




        /** Registering custom block:
         *
         * ------------ Contact Details ------------
        */
        acf_register_block_type(array(
            'name'              => 'contact-details',
            'title'             => __('Contact Details'),
            'description'       => __('A list of contact details.'),
            'render_template'   => 'custom-blocks-acf/blocks/contact-details/contact-details.php',
            'category'          => 'custom-blocks',
            'icon'              => 'phone',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/contact-details/contact-details.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('contact', 'details', 'phone', 'email;', 'location', 'store'),
        ));


        /** Registering custom block:
         *
         * ------------ Call-To-Action ------------
        */
        acf_register_block_type(array(
            'name'              => 'call-to-action',
            'title'             => __('Call-To-Action'),
            'description'       => __('Insert a full width call-to-action.'),
            'render_template'   => 'custom-blocks-acf/blocks/call-to-action/call-to-action.php',
            'category'          => 'custom-blocks',
            'icon'              => 'megaphone',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/call-to-action/call-to-action.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('call to action', 'cta', 'text', 'block', 'content'),
        ));


        /** Registering custom block:
         *
         * ------------ Interactive Slide ------------
        */
        acf_register_block_type(array(
            'name'              => 'interactive-slider',
            'title'             => __('Interactive Slider'),
            'description'       => __('Create an interactive slide show for your visitors.'),
            'render_template'   => 'custom-blocks-acf/blocks/interactive-slider/interactive-slider.php',
            'category'          => 'custom-blocks',
            'icon'              => 'slides',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/interactive-slider/interactive-slider.css',
            'enqueue_script'    => get_theme_file_uri() . '/custom-blocks-acf/blocks/interactive-slider/interactive-slider.js',
			'supports'		    => [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'edit',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('slide', 'slide show', 'interactive'),
        ));


        /** Registering custom block:
         *
         * ------------ Featured Product ------------
        */
        acf_register_block_type(array(
            'name'              => 'featured-product',
            'title'             => __('Featured Product'),
            'description'       => __('Promote a product in this featured product block.'),
            'render_template'   => 'custom-blocks-acf/blocks/featured-product/featured-product.php',
            'category'          => 'custom-blocks',
            'icon'              => 'sticky',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/featured-product/featured-product.css',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'preview',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('post', 'query', 'loop', 'archive', 'grid'),
        ));


        /** Registering custom block:
         *
         * ------------ Multi Form Selector ------------
        */
        acf_register_block_type(array(
            'name'              => 'multi-form-selector',
            'title'             => __('Multi-Form Selector'),
            'description'       => __('Insert multiple WPForms within one container.'),
            'render_template'   => 'custom-blocks-acf/blocks/multi-form-selector/multi-form-selector.php',
            'category'          => 'custom-blocks',
            'icon'              => '<svg width="24" height="24" viewBox="0 0 612 612" class="dashicon" aria-hidden="true" focusable="false"><path fill="currentColor" d="M544,0H68C30.445,0,0,30.445,0,68v476c0,37.556,30.445,68,68,68h476c37.556,0,68-30.444,68-68V68 C612,30.445,581.556,0,544,0z M464.44,68L387.6,120.02L323.34,68H464.44z M288.66,68l-64.26,52.02L147.56,68H288.66z M544,544H68 V68h22.1l136,92.14l79.9-64.6l79.56,64.6l136-92.14H544V544z M114.24,263.16h95.88v-48.28h-95.88V263.16z M114.24,360.4h95.88 v-48.62h-95.88V360.4z M242.76,360.4h255v-48.62h-255V360.4L242.76,360.4z M242.76,263.16h255v-48.28h-255V263.16L242.76,263.16z M368.22,457.3h129.54V408H368.22V457.3z"></path></svg>',
			'enqueue_style'     => get_theme_file_uri() . '/custom-blocks-acf/blocks/multi-form-selector/multi-form-selector.css',
            'enqueue_script'    => get_theme_file_uri() . '/custom-blocks-acf/blocks/multi-form-selector/multi-form-selector.js',
			'supports'		=> [
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
            ],
            'mode' => 'edit',
            'example'  => array(
                'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    '_is_preview'   => 'true'
                    )
                )
            ),
            'keywords' => array('form', 'wpforms', 'contact', 'fields'),
        ));

    }
}