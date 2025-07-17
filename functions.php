<?php
/**
 * GWC Theme.
 *
 * This file adds functions to the GWC Theme.
 *
 * @author  Global Watch Co
 * @link    https://www.globalwatchco.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Initilizes the Advanced Custom Blocks.
require_once get_stylesheet_directory() . '/custom-blocks-acf/custom-blocks-init.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- see https://core.trac.wordpress.org/ticket/49742
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		null
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}
}

// Enqueue Font Awesome on front- and back-end
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome_styles' );
add_action( 'admin_enqueue_scripts', 'enqueue_font_awesome_styles' );
function enqueue_font_awesome_styles() {
	$appearance = genesis_get_config( 'appearance' );
	wp_enqueue_style( genesis_get_theme_handle() . '-font-awesome-all', $appearance['font-awesome-all'], [], null );

	// Slick slider styles
	wp_enqueue_style( genesis_get_theme_handle() . '-slick-styles', $appearance['slick-styles'], [], null );
}

// Enqueue Custom JS script
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );
function enqueue_custom_scripts() {
	// Shared functionality script
    wp_enqueue_script( 'shared-js', get_stylesheet_directory_uri() . '/js/shared.js', array( 'jquery' ), false, true );

	// Slick slider script
	wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/slick/slick.min.js', array( 'jquery' ), false, false );

	// Custom WPForms validation script
	if( is_page('contact-us') ) {
		wp_enqueue_script( 'wpforms-custom-validation', get_stylesheet_directory_uri() . '/js/wpforms-custom-validation.js', array( 'jquery' ), false, true );
	}

	// AJAX handler script
	wp_enqueue_script( 'ajax-data-handler', get_stylesheet_directory_uri() . '/js/ajax-data-handler.js', array( 'jquery' ), false, true );

	// Rolex Retailer Clock script
	wp_enqueue_script( 'rolex-retailer-call', 'https://static.rolex.com/retailers/clock/retailercall.js', null, null, true );

	// Rolex Analytics script
	// wp_enqueue_script( 'rolex-analytics', 'https://assets.adobedtm.com/7e3b3fa0902e/7ba12da1470f/launch-73c56043319a-staging.min.js', null, null, false );

}

// Localizing the AJAX data handler script
add_action('wp_enqueue_scripts', 'localize_ajax_url');
function localize_ajax_url() {
	$nonce = wp_create_nonce('acf_data_nonce');
    wp_localize_script('ajax-data-handler', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
	// wp_localize_script('ajax-data-handler', 'acf_data_nonce', $nonce);
}


// Enqueue admin script
add_action('admin_enqueue_scripts', 'ql_enqueue_admin_scripts') ;
function ql_enqueue_admin_scripts() {
	global $post;
	global $ql_custom_post_types_arr;
	
	array_push($ql_custom_post_types_arr, 'page');

    if( !empty($post) && in_array( $post->post_type, $ql_custom_post_types_arr ) ) {
		wp_enqueue_script('gutenberg-filters', get_stylesheet_directory_uri() . '/js/filter-gutenberg-blocks.js', ['wp-edit-post']);
	}

	// Remove 'page' from array
	$key = array_search('page', $ql_custom_post_types_arr, true);
	if ($key !== false) {
		unset($ql_custom_post_types_arr[$key]);
	}

	wp_enqueue_style( 'backend-styles', get_stylesheet_directory_uri() . '/lib/backend-styles.css', array(), '1.0.0' );

	// Enqueue script to check for rolex editorial posts
	if (is_admin() && get_post_type() === 'blog_post') {
        wp_enqueue_script('admin-script', get_stylesheet_directory_uri() . '/js/admin-script.js', array('jquery'), null, true);
        // Pass data to the script
        wp_localize_script('admin-script', 'customAdminData', array(
            'exclusiveBrandField' => get_post_meta(get_the_ID(), 'blog_post_exclusive_brand_post', true),
        ));
    }

}


add_filter( 'body_class', 'genesis_sample_body_classes' );
/**
 * Add additional classes to the body element.
 *
 * @since 3.4.1
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function genesis_sample_body_classes( $classes ) {

	if ( ! genesis_is_amp() ) {
		// Add 'no-js' class to the body class values.
		$classes[] = 'no-js';
	}
	return $classes;
}

add_action( 'genesis_before', 'genesis_sample_js_nojs_script', 1 );
/**
 * Echo the script that changes 'no-js' class to 'js'.
 *
 * @since 3.4.1
 */
function genesis_sample_js_nojs_script() {

	if ( genesis_is_amp() ) {
		return;
	}

	?>
	<script>
	//<![CDATA[
	(function(){
		var c = document.body.classList;
		c.remove( 'no-js' );
		c.add( 'js' );
	})();
	//]]>
	</script>
	<?php
}

add_filter( 'wp_resource_hints', 'genesis_sample_resource_hints', 10, 2 );
/**
 * Add preconnect for Google Fonts.
 *
 * @since 3.4.1
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function genesis_sample_resource_hints( $urls, $relation_type ) {

	if ( wp_style_is( genesis_get_theme_handle() . '-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		];
	}

	return $urls;
}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'genesis-singular-images', 1000, 1000, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// -_-_-_-_-_-_-_-_-_-_-_-_- Customization by Global Watch Co starts here -_-_-_-_-_-_-_-_-_-_-_-_ //

//
//
// ----------------------------- Rolex Consent Cookies ----------------------------- //
//
//

// Insert the digital layer variable data in the head
add_action('wp_head', 'ql_rolex_cookies_integration', 5);
function ql_rolex_cookies_integration() {
    ?>
    <script id="rolex-analytics-cookies" type="text/javascript">
         // Function to set the cookie
		function setCookie(name, value, days) {
			var expires = "";
			if (days) {
			var date = new Date();
			date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
			expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + (value || "") + expires + "; path=/";
		}

		// Function to get the cookie value
		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(";");
			for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == " ") c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}

		// Set default cookie value to false if not set
		if (!getCookie("rlx-consent")) {
			setCookie("rlx-consent", "false", 365);
		}

		// Listen for CookieYes consent action
		document.addEventListener("cookieyes_consent_update", function (eventData) {
			// Check the value in the JSON eventData and perform desired action

			console.log(eventData.detail);
			const acceptedCookies = eventData.detail.accepted;

			if (acceptedCookies.length == 1 || acceptedCookies.length > 1 && !acceptedCookies.includes('analytics') && !acceptedCookies.includes('performance') ) {
				// console.log('Set cookie to false');
				setCookie("rlx-consent", "false", 365);
			} else if (acceptedCookies.length > 1 && acceptedCookies.includes('analytics') || acceptedCookies.length > 1 && acceptedCookies.includes('performance')) {
				// console.log('Set cookie to true');
				setCookie("rlx-consent", "true", 365);
			}
		});
    </script>
    <?php
}

//
//
// ----------------------------- Google shopping tags ----------------------------- //
//
//

add_action('wp_head', 'ql_add_google_tags');

function ql_add_google_tags() {
	?> <!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-9F9EZC919X"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-9F9EZC919X'); </script> <?php
}

//
//
// ----------------------------- WordPress admin modifications ----------------------------- //
//
//

// Array of custom post types. Specific to this project
global $ql_custom_post_types_arr;
$ql_custom_post_types_arr = array('blog_post');

function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

// removing the default welcome panel of the admin dashboard
remove_action( 'welcome_panel', 'wp_welcome_panel' );

// removing default admin dashboard widgets (Activity, WordPress News, Quick Draft and At a Glance) from the WordPress admin dashboard for all users.
add_action( 'admin_init', 'remove_dashboard_meta' );
function remove_dashboard_meta() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Activity
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // WordPress News
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Draft
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // At a Glance
}

// Hides WPForms dashboard widget in WordPress admin
add_filter( 'wpforms_admin_dashboardwidget', '__return_false' );

// removes the scripts metaboxes from all Edit Page screens
add_action( 'admin_menu' , 'remove_genesis_page_scripts_box' );
function remove_genesis_page_scripts_box() {
remove_meta_box( 'genesis_inpost_scripts_box', 'page', 'normal' ); 
}

// removing "posts" "comments" + "genesis portfolio item" nav items from the admin side menu
add_action( 'admin_menu', 'remove_default_post_type' );
function remove_default_post_type() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}

// removing '+New post' and 'comments' in top Admin Menu Bar
add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );
function remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
	$wp_admin_bar->remove_node( 'comments' ); 
}

// removing 'featured image' and 'discussion' support
add_action( 'init', 'ql_remove_featured_image_support', 10 );
function ql_remove_featured_image_support() {
	remove_post_type_support( 'page', 'thumbnail' );
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'post', 'comments' );
}

// adding the WordPress block library CSS
add_action( 'wp_enqueue_scripts', 'ql_add_wp_block_library_css', 100 );
function ql_add_wp_block_library_css(){
    wp_enqueue_style( 'wp-block-library' );
} 

// disabling gutenberg colour settings
add_action( 'after_setup_theme', 'ql_disable_gutenberg_color_settings' );
function ql_disable_gutenberg_color_settings() {
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
}


//adding excerpt support for custom post types
add_action( 'init', 'ql_add_excerpt_support', 10 );
function ql_add_excerpt_support() {
	global $ql_custom_post_types_arr;
	array_push($ql_custom_post_types_arr, 'page');

	foreach($ql_custom_post_types_arr as $postType):
		add_post_type_support( $postType, 'excerpt' );
	endforeach;

	// Remove 'page' from array
	$key = array_search('page', $ql_custom_post_types_arr, true);
	if ($key !== false) {
		unset($ql_custom_post_types_arr[$key]);
	}
}

// adding SEO meta boxes to custom post types
add_action( 'init', 'add_support_genesis_seo' );
function add_support_genesis_seo() {
	global $ql_custom_post_types_arr;

	foreach($ql_custom_post_types_arr as $postType):
		add_post_type_support( $postType, 'genesis-seo' );
	endforeach;
}

// Dequeue superfish
add_action( 'wp_print_scripts', 'ql_remove_superfish', 100 );
function ql_remove_superfish() {
	wp_dequeue_script( 'superfish' );
	wp_dequeue_script( 'hoverIntent' );
	wp_dequeue_script( 'scripts' );
}

add_action( 'wp_enqueue_scripts', 'ql_disable_superfish' );
function ql_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}


//
//
// ----------------------------- Layout modifications ----------------------------- //
//
//

// Unregister primary sidebar and secondary sidebar
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

// Remove layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar' );

// Remove layout metaboxes
remove_theme_support( 'genesis-inpost-layouts' );
remove_theme_support( 'genesis-archive-layouts' );


// Use full width layout 
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Removed structural wrap for site-inner & footer-widgets
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'footer',
) );

// Re-prioritise Genesis SEO metabox from high to default.
add_action( 'admin_menu', 'ea_add_inpost_seo_box' );
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
function ea_add_inpost_seo_box() {
	if ( genesis_detect_seo_plugins() )
		return;
	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-seo' ) )
			add_meta_box( 'genesis_inpost_seo_box', __( 'Theme SEO Settings', 'genesis' ), 'genesis_inpost_seo_box', $type, 'normal', 'default' );
	}
}


//
//
// ----------------------------- Header modifications ----------------------------- //
//
//


// Adding a the rolex clock to specified navigations
add_filter( 'wp_nav_menu_items', 'ql_theme_menu_extras', 10, 2 );
function ql_theme_menu_extras( $menu, $args ) {

	$rolex_clock_ref = 'https://globalwatchco.com/rolex/';

	if ( 'primary' === $args->theme_location ) {

		$rolex_retailer_clock = '<li class="menu-item rolex-clock"><a href="'.$rolex_clock_ref.'"><span class="rolex-retailer-clock"></span></a></li>';

		$menu .= $rolex_retailer_clock;

	}

	return $menu;
}


// Display a sticky back to top button
add_action('genesis_footer', 'ql_back_to_top_button');
function ql_back_to_top_button() {

	$output = printf( '<div class="back-to-top-container"><button onclick="topFunction()" id="back-to-top__button" title="Back to top"></button></div>');

}

// Add AJAX endpoint for fetching ACF data
add_action('wp_ajax_get_featured_products_data', 'get_featured_products_data');
add_action('wp_ajax_nopriv_get_featured_products_data', 'get_featured_products_data');
function get_featured_products_data() {
	// Verify nonce
	// $nonce = $_POST['nonce'];
	// if (!wp_verify_nonce($nonce, 'acf_data_nonce')) {
	// 	die('Nonce verification failed');
	// }

    // Retrieve data
	$featured_products_visibility = get_field('nav_menu_featured_products_visiblity', 'options');
	$featured_products = get_field( 'nav_menu_featured_products', 'options' );

	$return_data = array(
		'visibility_bool' => $featured_products_visibility,
		'product_repeater_data' => $featured_products,
	);
	
	wp_send_json($return_data);

    // Always exit to avoid extra output
    wp_die();
}


//
//
// ----------------------------- Footer modifications ----------------------------- //
//
//

// Move footer credits below footer nav menu
remove_action( 'genesis_footer', 'genesis_do_footer' ); 
add_action( 'genesis_footer', 'ql_do_footer', 12 );

// redefining genesis_do_footer (located in ./genesis/lib/structure/footer) to ql_do_footer and gave the footer credits output a class of 'footer-credits'
function ql_do_footer() {

	$creds_text = wp_kses_post( genesis_get_option( 'footer_text' ) );
	$output     = '<div class="footer-credits"><div class="wrap"><p>' . genesis_strip_p_tags( $creds_text ) . '</p></div></div>';

	/**
	 * Adjust full footer output.
	 */
	$output = apply_filters( 'genesis_footer_output', $output, '', $creds_text );

	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitize done prior to filter application

}

// moving footer-widget inside site-footer > wrap
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_footer', 'genesis_footer_widget_areas', 10 );


// Adding a custom class to the site-footer
add_filter( 'genesis_attr_footer-widgets', 'site_footer_attr' );
function site_footer_attr( $attributes ) {
 
	$attributes['class'] .= ' bg-grey_light';
	return $attributes;
 
}


// Change WPForms footer text
add_filter( 'wpforms_email_footer_text', 'wpf_dev_change_email_footer_text', 30, 1 );
function wpf_dev_change_email_footer_text( $footer ) {
  
    $footer = sprintf( __( 'COPYRIGHT © 2024 | Global Watch Company. ALL RIGHTS RESERVED.', 'wpforms' ) );
  
    return $footer;
  
}




//
//
// ----------------------------- Search form and search results page modifications ----------------------------- //
//
//


//* Customize search form input text
add_filter( 'genesis_search_text', 'ql_search_text' );
function ql_search_text( $text ) {
	return esc_attr( 'Search...' );
}

//* Customize search form input text on SRP page
function ql_search_text_srp( $text ) {
	return esc_attr( 'What are you looking for?' );
}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'ql_search_button_text' );
function ql_search_button_text( $text ) {
	return esc_attr( '&#xf002;' );
}

// Change the $wp_query arg: posts_per_page to -1 (unlimited) on the Search Results Page
add_action( 'pre_get_posts', 'ql_srp_results_per_page' );
function ql_srp_results_per_page( $query ) {
    if ( !is_admin() && $query->is_search() && $query->is_main_query() ) {
		$query->set('posts_per_page', 12);
    }
}

// Printing what type of search result is being display for more context
function ql_print_type_of_search_result() {

    global $ql_custom_post_types_arr;

    $post = get_post();
    $postType = $post->post_type;
    $post_type_obj = get_post_type_object( $post->post_type );

    if ( in_array( $postType, $ql_custom_post_types_arr ) ) {
		$SRType = 'Archive: <a href="' . get_post_type_archive_link($postType) . '">';
        $metaData =  $SRType . $post_type_obj->labels->name . '</a>';
    } elseif( $postType == 'page' ) {
        $metaData = $post_type_obj->labels->singular_name;
    } else {
        $metaData = $post_type_obj->labels->name;
    }

	$result = sprintf( '<div class="search-result-meta-data"><p class="search-result-type">%s</p></div>', $metaData );

	echo $result;

}

//
//
// ----------------------------- Adding custom shortcodes ----------------------------- //
//
//

// enable shortcodes in widgets and nav menu
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'wp_nav_menu', 'do_shortcode' );


// adding shortcode for page url string. Without markup
add_shortcode( 'ql_page_url_string', 'ql_page_url_string_shortcode' );

function ql_page_url_string_shortcode( $atts ) {

    $defaults = [
		'after'  => '',
		'before' => '',
        'page' => '',
	];

	$atts     = shortcode_atts( $defaults, $atts, 'ql_page_url_string' );
    
    $output =  site_url($atts['page']);
    
	return apply_filters( 'ql_page_url_string_shortcode', $output, $atts );
}

// adding shortcode for complete site home page link
add_shortcode( 'ql_site_link', 'ql_site_link_shortcode' );
function ql_site_link_shortcode( $atts ) {

    $defaults = [
		'after'  => '',
		'before' => '',
        'page' => '',
        'name' => '',
	];

	$atts     = shortcode_atts( $defaults, $atts, 'ql_site_link' );

	$output = sprintf( '%s<a href="%s">%s</a>%s', $atts['before'], $atts['page'], $atts['name'], $atts['after'] );

	return apply_filters( 'ql_site_link_shortcode', $output, $atts );

}

add_shortcode( 'ql_footer_privacypolicy_link', 'ql_footer_privacypolicy_link_shortcode' );
/**
 * Adds Privacy Policy link to the footer.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through `ql_footer_privacypolicy_link_shortcode` filter before returning.
 *
 * @since 1.2.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Output for `ql_footer_privacypolicy_link' shortcode.
 */
function ql_footer_privacypolicy_link_shortcode( $atts ) {

	$defaults = [
		'after'  => '',
		'before' => '',
	];
    $privacyUrl = get_privacy_policy_url();

	$atts     = shortcode_atts( $defaults, $atts, 'ql_footer_privacypolicy_link' );

	$output = sprintf( '%s<a href="%s">%s</a>%s', $atts['before'], $privacyUrl, 'Privacy Policy', $atts['after'] );

	return apply_filters( 'ql_footer_privacypolicy_link_shortcode', $output, $atts );

}

add_shortcode( 'ql_footer_termsofservice_link', 'ql_footer_termsofservice_link_shortcode' );
/**
 * Adds Terms of service link to the footer.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through `ql_footer_termsofservice_link_shortcode` filter before returning.
 *
 * @since 1.2.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Output for `ql_footer_termsofservice_link' shortcode.
 */
function ql_footer_termsofservice_link_shortcode( $atts ) {

	$defaults = [
		'after'  => '',
		'before' => '',
	];
    $tosUrl = site_url('terms-of-service');

	$atts     = shortcode_atts( $defaults, $atts, 'ql_footer_termsofservice_link' );

	$output = sprintf( '%s<a href="%s">%s</a>%s', $atts['before'], $tosUrl, 'Terms of Service', $atts['after'] );

	return apply_filters( 'ql_footer_termsofservice_link_shortcode', $output, $atts );

}

add_shortcode( 'ql_footer_credits_link', 'ql_footer_credits_link_shortcode' );
/**
 * Adds the credits link to the footer.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   name (the developers' name, default is Global Watch Co),
 *   name (the link url, default is https://www.globalwatchco.com/),
 *   before (output before link, default is 'Website Designed & Developed by').
 *
 * Output passes through `ql_footer_credits_link_shortcode` filter before returning.
 *
 * @since 1.2.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Output for `ql_footer_credits_link' shortcode.
 */
function ql_footer_credits_link_shortcode( $atts ) {

	$defaults = [
		'after'  => '',
        'name' => 'Global Watch Co',
        'url' => 'https://www.globalwatchco.com/',
		'before' => 'Designed & Developed by ',
	];

	$atts     = shortcode_atts( $defaults, $atts, 'ql_footer_credits_link' );

	$output = sprintf( '%s<a href="%s" target=_blank>%s</a>%s', $atts['before'], $atts['url'], $atts['name'], $atts['after'] );

	return apply_filters( 'ql_footer_credits_link_shortcode', $output, $atts );

}

// add font awesome social icon shortcodes
add_shortcode('social_icon', 'ql_social_icon_shortcode');
function ql_social_icon_shortcode( $atts ) { 

	$defaults = [
		'size'  => '',
        'social' => 'instagram'
	];

	$atts     = shortcode_atts( $defaults, $atts, 'ql_social_icon_shortcode' );

	$output = sprintf( '<i class="fab fa-%s fa-%s"></i>', $atts['social'], $atts['size'] );

	return apply_filters( 'ql_social_icon_shortcode', $output, $atts );
}

// add svg social icon shortcode
add_shortcode('svg_social_icon', 'ql_svg_social_icon_shortcode');
function ql_svg_social_icon_shortcode( $atts ) {

	$defaults = [
        'social' => 'instagram'
	];

	$atts     = shortcode_atts( $defaults, $atts, 'ql_svg_social_icon_shortcode' );

	// Checking if file exists to prevent a PHP error
	if ( $svg_contents = @file_get_contents(get_stylesheet_directory() . '/assets/logos/' . $atts['social'] . '-logo.svg') === false ) {
		$svg_contents = 'Couldn\'t locate file for "'.$atts['social'].'".';
		// echo "HTTP request failed. Error was: " . $error['message'];
	} else {
		$svg_contents = file_get_contents(get_stylesheet_directory() . '/assets/logos/' . $atts['social'] . '-logo.svg');
	}

	$output = sprintf( '<div class="svg-logo-%s">%s</div>', $atts['social'], $svg_contents );

	return apply_filters( 'ql_svg_social_icon_shortcode', $output, $atts );
}

//
//
// ----------------------------- Advanced Custom Fields ----------------------------- //
//
//


// Allowing the custom block types and WP core innerblocks
add_filter( 'allowed_block_types', 'ql_allowed_block_types', 10, 2 );
function ql_allowed_block_types( $allowed_blocks, $post ) {
 
    $allowed_blocks = array(
        'core/heading',
        'core/paragraph',
        'core/list',
        'core/list-item',
        'core/image',
        'core/video',
        'core/embed',
        'core/audio',
		'core/quote',
		'core/shortcode',
		'core/html',
		'core/pullquote',
		'core/column',
		'core/columns',
		'core/text-columns',
		'core/gallery',
		'core/table',
		'core/separator',
        'acf/container',
        'acf/button',
        'acf/accordion',
		'acf/spacer',
		'acf/icon',
		'acf/youtube-embed',
		'acf/content-block',
		'acf/image-text-column',
		'acf/image-text-column-alt',
		'acf/double-image-text-column',
		'acf/contact-details',
		'acf/call-to-action',
		'acf/featured-product',
		'acf/interactive-slider',
		'acf/post-loop',
		'acf/social-media',
		'acf/multi-form-selector',
		'wpforms/form-selector',
    );

	return $allowed_blocks;
 
}

// Create custom input field to upload default image to ACF image field
add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field', 20);
function add_default_value_to_image_field($field) {
	acf_render_field_setting( $field, array(
	'label'      => __('Default Image ID','acf'),
	'instructions'  => __('Appears when creating a new post','acf'),
	'type'      => 'image',
	'name'      => 'default_value',
	));
}


//
//
// ----------------------------- Advanced Custom Fields ----------------------------- //
//
//


// Adding options pages and subpages with ACF
if( function_exists( 'acf_add_options_page' ) ) {

	// options page for the News archive page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'News & Press Archive Options',
		'menu_title'	=> 'Options',
		'menu_slug'		=> 'news-options',
		'parent_slug'	=> 'edit.php?post_type=blog_post',
	));

	// options page for the News archive page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Menu Featured Products',
		'menu_title'	=> 'Menu Featured Products',
		'menu_slug'		=> 'menu-options',
		'parent_slug'	=> 'themes.php',
	));

}

add_action( 'block_categories', 'ql_register_block_categories', 10, 2 );
function ql_register_block_categories( $categories ) {

	return array_merge(
		$categories,
		[
			[
				'slug'  => 'writing',
				'title' => __( 'Writing' ),
			],
			[
				'slug'  => 'custom-post-types',
				'title' => __( 'Custom Post Types' ),
			],
		]
	);
}


//
//
// ----------------------------- Content modifications ----------------------------- //
//
//

// Disable the Gutenberg editor on specified post types and pages
add_filter( 'use_block_editor_for_post', 'ql_disable_gutenberg', 10, 2 );
function ql_disable_gutenberg( $can_edit, $post ) {

	$allowed_post_types = array('page', 'post', 'blog_post');
	$blocked_page_IDs = array('9108');

	if( in_array( $post->ID, $blocked_page_IDs ) ) {
		return false;
	} elseif( in_array( $post->post_type, $allowed_post_types ) ) {
		return true;
	}

	return false;
}

// adding hero content
add_action('genesis_before_content', 'ql_get_hero_content_part');
function ql_get_hero_content_part() {
    
    if( is_front_page() ) {
		get_template_part('content-parts/hero/hero', 'primary');
	} elseif( !is_front_page() && !is_404() && !is_search() ) {
		get_template_part('content-parts/hero/hero', 'secondary');
	} else {
        // do nothing
    }
}

// adding main content to all necessary pages
function ql_do_content() {
	global $ql_custom_post_types_arr;

    if( is_single() ) {
        get_template_part('content-parts/main/main', 'single');
	} elseif( is_search() ) {
        get_template_part('content-parts/main/main', 'search');
	} elseif( is_post_type_archive( $ql_custom_post_types_arr ) || is_home() || is_tag() ) {
        get_template_part('content-parts/main/main', 'archive');
	} elseif( is_tax() || is_category() ) {
        get_template_part('content-parts/main/main', 'taxonomy');
    } else {
        get_template_part('content-parts/main/main', 'generic');
    }
}


//
//
// ----------------------------- Breadcrumb modifications ----------------------------- //
//
//


// Repositioning the breadcrumbs. Hooking into custom hook created on hero-secondary.php
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'ql_breadcrumb_hook', 'genesis_do_breadcrumbs' );

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'ql_breadcrumb_args' );
function ql_breadcrumb_args( $args ) {
	$args['sep'] = ' <span class="breadcrumb-separater"></span> ';
	// Replacing "You are here" with empty string
	$args['labels']['prefix'] = '';
	// Replacing "Archives for" with empty string
	$args['labels']['author'] = '';
	$args['labels']['category'] = '';
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['search'] = 'Search for ';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'Not found: ';

	return $args;
}

//
//
// ----------------------------- Archive modifications ----------------------------- //
//
//

// Add related posts section to blog posts
add_filter( 'genesis_after_entry', 'ql_add_related_posts_section' );
function ql_add_related_posts_section() {
	// Get the current post ID
	global $post;
	$exclusive_post = get_field('blog_post_exclusive_brand_post', $post->ID);

	if( !is_singular('blog_post') || $exclusive_post == 'rolex-post' ) {
		return;
	}

	// Get the categories and tags IDs of the current post
	$category_ids = wp_get_post_terms($post->ID, 'blog_category', ['fields' => 'ids']);
	$tag_ids = wp_get_post_terms($post->ID, 'blog_tag', ['fields' => 'ids']);

	// Query related posts based on categories and tags
	$related_posts_query = new WP_Query(array(
		'post_type' => 'blog_post',
		'posts_per_page' => 3,
		'post__not_in' => array($post->ID), // Exclude the current post
		'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'blog_category',
				'field' => 'id',
				'terms' => $category_ids,
				'operator' => 'IN',
			),
			array(
				'taxonomy' => 'blog_tag',
				'field' => 'id',
				'terms' => $tag_ids,
				'operator' => 'IN',
			),
		),
	));

	// Check if there are related posts
	if ($related_posts_query->have_posts()) :
		echo '<div class="related-blog-posts-section">';
			echo '<h2>Related Articles</h2>';
			echo '<div class="related-blog-posts-grid archive-post-grid">';
				while ($related_posts_query->have_posts()) : $related_posts_query->the_post();
					
					ob_start();
					post_class();
					$post_classes = ob_get_clean();

					// Get the categories and tags IDs of the current post
					$category_terms = wp_get_post_terms(get_the_ID(), 'blog_category');
					$tag_terms = wp_get_post_terms(get_the_ID(), 'blog_tag');

					echo '<article '.$post_classes.' aria-label="'.get_the_title().'" itemscope="" itemtype="https://schema.org/NewsArticle">';
						echo '<a class="entry-image-post-link" href="'.get_the_permalink().'">';
							echo '<div class="entry-image">'.get_the_post_thumbnail(get_the_ID(), 'genesis-singular-images').'</div>';
						echo '</a>';
						echo '<div class="entry-content-wrap">';
							echo '<header class="entry-header">';
								echo '<h2 class="entry-title" itemprop="headline">';
									echo '<a class="entry-title-link" rel="bookmark" href='.get_the_permalink().'">'.get_the_title().'</a>';
								echo '</h2>';

								echo '<p class="entry-meta"><time class="entry-time" itemprop="datePublished" datetime="'.get_the_date('c').'">'.get_the_date().'</time>';
									if( !empty($category_terms) ):
									echo '<span class="entry-terms">';
										foreach( $category_terms as $category ):
											echo '<a href="'.get_term_link($category->term_id).'" rel="tag">'.$category->name.'</a>';
										endforeach;
									echo '</span> ';
									endif;
									if( !empty($tag_terms) ):
									echo '<span class="entry-terms">';
										foreach( $tag_terms as $tag ):
											echo '<a href="'.get_term_link($tag->term_id).'" rel="tag">'.$tag->name.'</a>';
										endforeach;
									echo '</span> ';
									endif;
								echo '</p>';
							echo '</header>';
							echo '<div class="entry-content" itemprop="text">';
								do_action( 'ql_excerpt_hook' );
								echo modify_read_more_link();
							echo '</div>';
						echo '</div>';
					echo '</article>';
				endwhile;
			echo '</div>';
		echo '</div>';
		// Restore original post data
		wp_reset_postdata();
	endif;

}

// Add exclusive post class to single blog posts
add_filter( 'genesis_attr_entry', 'ql_blog_post_class_attr' );
function ql_blog_post_class_attr( $attributes ) {

	global $post;
	$blogPostTaxonomies = get_object_taxonomies('blog_post');

	if( !is_post_type_archive('blog_post') && !is_tax($blogPostTaxonomies) ) {
		return $attributes;
	}

	$exclusive_post = get_field('blog_post_exclusive_brand_post', $post->ID);
    if( $exclusive_post == 'rolex-post' ) {
        $attributes['class'] .= ' exclusive-post rolex-post';
    } elseif( $exclusive_post == 'tudor-post' ) {
        $attributes['class'] .= ' exclusive-post tudor-post';
    }
	
	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
	
	return $attributes;
}

// Add custom column to the admin panel
add_filter('manage_blog_post_posts_columns', 'custom_column_head');
function custom_column_head($columns) {
	$new_columns = array();

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key == 'title') {
            $new_columns['featured_post'] = 'Featured';
            $new_columns['exclusive_post'] = 'Exclusive Post';
        }
    }

	return $new_columns;
}

// Display data in the custom column
add_action('manage_blog_post_posts_custom_column', 'custom_column_content', 10, 2);
function custom_column_content($column_name, $post_id) {
    if ($column_name == 'featured_post') {
        $is_featured_post = get_post_meta($post_id, 'blog_post_is_featured_post', true);
        if( $is_featured_post ) {
			echo '<p><strong>True</strong></p>';
		} else {
			echo '<p class="text-colour-grey">False</p>';
		}
	} elseif ($column_name == 'exclusive_post') {
		$exclusive_post = get_post_meta($post_id, 'blog_post_exclusive_brand_post', true);

        if( $exclusive_post == 'rolex-post' ) {
			echo '<p>Rolex</p>';
		} elseif( $exclusive_post == 'tudor-post' ) {
			echo '<p>Tudor</p>';
		}
	}
}

// add_action('genesis_before_content', 'ql_get_featured_post_ids');
function ql_get_featured_post_ids() {

	$post_ids = get_posts( array(
		'fields'         => 'ids',
		'post_type'      => 'blog_post',
		'posts_per_page' => -1,
	));

	$featured_post_ids = [];

	foreach( $post_ids as $post_id ) {
		$featured_post = get_field('blog_post_is_featured_post', $post_id);

		if( $featured_post ) {
			array_push( $featured_post_ids, $post_id );
		}
	}

	return $featured_post_ids;
}

// Featured post reordering function
add_action( 'pre_get_posts', 'ql_custom_order_featured_post' );
function ql_custom_order_featured_post( $query ) {

    // Check if this is the main query for the custom post type
    if ( is_admin() || ! $query->is_main_query() || ! is_post_type_archive( 'blog_post' ) ) {
        return;
    }

	// Get the most recently published featured post
    $featured_post_id = ql_get_featured_post_ids()[0];
	$paged = $query->query_vars['paged'];

	// Get the IDs of all posts in the custom post type
	$all_post_ids = get_posts( array(
		'fields'         => 'ids',
		'post_type'      => 'blog_post',
		'posts_per_page' => -1,
	));

	// Remove the specific post ID from the array
	$all_post_ids = array_diff( $all_post_ids, array( $featured_post_id ) );

	// Prepend the specific post ID to the beginning of the array
	array_unshift( $all_post_ids, $featured_post_id );

	// Set the 'orderby' parameter to 'post__in'
	$query->set( 'orderby', 'post__in' );
	$query->set( 'post__in', $all_post_ids );

	// If there's at least 1 featured post and we're on the first page, set the posts_per_page to 7
	if( $featured_post_id && $paged < 2 ) {
		$query->set( 'posts_per_page', 7 );
	}
}


// Adding background colour archive modification to single work entry items
function ql_featured_post_class( $attributes ) {

    global $post;

    $is_featured = get_field('blog_post_is_featured_post', $post->ID);
	if($is_featured):
		$attributes['class'] .= ' is-featured-post';
	endif;
	
	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
	
	return $attributes;
}

// Add featured image on single post
add_action( 'ql_before_entry_header_hook', 'ql_featured_image');
function ql_featured_image() {

	global $post;
	global $ql_custom_post_types_arr;

	$hideFeaturedImage = get_field('hide_featured_image_' . $post->post_type, 'options', $post->ID);
	if( is_post_type_archive( $ql_custom_post_types_arr ) && $hideFeaturedImage || is_home() && $hideFeaturedImage || is_tax() && $hideFeaturedImage || is_category() && $hideFeaturedImage || is_tag() && $hideFeaturedImage ) {
		return;
	}

	if( is_single( $post->ID ) || is_singular( $ql_custom_post_types_arr ) ) {
		$class = 'hero-background-img';
		$imageSize = 'full';
	} else {
		$class = 'aligncenter';
		$imageSize = 'genesis-singular-images';
	}

	if($post->post_type == 'blog_post') {
		$imageAttr = array ( 'class' => $class, 'itemtype' => 'image' );
	} else {
		$imageAttr = array ( 'class' => $class );
	}
	
	$image = genesis_get_image( array( // more options here -> genesis/lib/functions/image.php
			'format'  => 'html',
			'size'    => $imageSize,
			'context' => '',
			'attr'    => $imageAttr,
	));

	$defaultHeroBgImageID = get_field('default_featured_image_single_post_' . $post->post_type, 'options', $post->ID);
	$defaultHeroBgImage = wp_get_attachment_image( $defaultHeroBgImageID, 'genesis-singular-images', '', ["class" => $class] );

	$imageNotSet = wp_get_attachment_image( '9175', 'full', '', ["class" => $class] );

	// Conditions: Must be on a single post template (blog and custom post type), post must have a native featured image set
	if( !is_front_page() && !is_page() && is_single($post->ID) && $image || !is_front_page() && !is_page() && is_singular( $ql_custom_post_types_arr ) && $image ) {
		printf( '<div class="hero-background-wrap">%s</div>', $image );
	// Conditions: Post must have a native featured image set
	} elseif( has_post_thumbnail() ) {
		printf( '<a class="entry-image-post-link" href="'.get_permalink($post->ID).'"><div class="entry-image">%s</div></a>', $image );
	// Conditions: Post must NOT have a native featured image set, the respecte archive options has a default image set for single posts
	} elseif( !has_post_thumbnail() && $defaultHeroBgImageID ) {
		printf( '<a class="entry-image-post-link" href="'.get_permalink($post->ID).'"><div class="entry-image">%s</div></a>', $defaultHeroBgImage );
	// Conditions: No featured or default image has been set
	} else {
		printf( '<a class="entry-image-post-link" href="'.get_permalink($post->ID).'"><div class="entry-image">%s</div></a>', $imageNotSet );
	}
}

// Creating custom function to retrieve custom taxonomy name
function ql_print_CT_terms( $key = '', $val = '' ) {

    $CTArray = get_object_taxonomies(get_post_type());

	if( !empty($val) ) {
		return $val;
	} elseif( empty($key) && $key != '0' ) {
		// if on index (blog) page, return
		if( is_home() || count($CTArray) > '2' ) {
			return;
		}
		
		// Check if post type array contains tags or not
		if( count($CTArray) == '2' ) {
			$CTT = $CTArray[1];
		} else {
			$CTT = $CTArray[0];
		}

	} elseif( isset($key) ) {
		$CTT = $CTArray[$key];
	} else {
		return;
	}

    return $CTT;
}

// Customizing post entry meta header
function ql_post_info_filter( $post_info ) {

	global $ql_custom_post_types_arr;
	$postType = get_post_type();

	$author_meta = '<span class="hide" itemtype="author">Global Watch Company</span>';

    // Different $post_info values depending on post type
	if( is_singular('blog_post') ) {
		$post_info = '[post_date format="F d, Y" before="<strong>Publish Date:</strong>"] [post_terms taxonomy="'.ql_print_CT_terms('0').'" before="<strong>Category:</strong> "] [post_terms taxonomy="'.ql_print_CT_terms('1').'" before="<strong>Tag:</strong> "]' . $author_meta;

	} elseif( $postType == 'blog_post' ) {
		$post_info = '[post_date format="F d, Y"] [post_terms taxonomy="'.ql_print_CT_terms('0').'" before=""] [post_terms taxonomy="'.ql_print_CT_terms('1').'" before=""]' . $author_meta;

	} elseif( in_array( $postType, $ql_custom_post_types_arr ) ) {
		$post_info = '[post_date format="F d, Y"] [post_terms taxonomy="'.ql_print_CT_terms().'" before=""]';

    } else {
        $post_info = '[post_date format="F d, Y"] [post_categories]';
    }

	return $post_info;

}

// Add Custom Micro Data To Specific Pages In Genesis
function ql_microdata_schema( $attributes ) {

    if( get_post_type() == 'blog_post' ) {
        $attributes['itemtype'] = 'https://schema.org/NewsArticle';
    }
    
    return $attributes;
        
}


// Functions to check if the $time is in the past or future based on the current time
function isPast($time) {
    return (strtotime($time) < current_time('timestamp'));
}
function isFuture($time){
    return (strtotime($time) > current_time('timestamp'));
}

// Function to modify the length of post excerpts to 30 words
function ql_excerpt_length( $length ) {
	return 30;
}

// Adding trailing dots to excerpts
function ql_excerpt_trailing_dots( $more ) {
    return '...';
}

// Creating excerpts that also include Gutenberg innerBlocks if the default excerpt function cannot retrieve any content
add_action( 'ql_excerpt_hook', 'ql_inclusive_excerpt');
function ql_inclusive_excerpt() {

    $post = get_post();
    $post_type_obj = get_post_type_object( $post->post_type );
	$blockContent = wp_strip_all_tags($post->post_content);

    if( get_the_excerpt() ) {
        echo '<p class="post-excerpt">' . get_the_excerpt() . '</p>';
    } elseif( $blockContent) {
        echo wp_trim_words($blockContent, 35);
    } else {
        echo '(...)';
    }

}

// Add a custom entry title to posts
function ql_entry_title() {

	global $post;

    $postTitle = get_the_title($post->ID);
	$postPermalink = get_the_permalink($post->ID);

	printf( '<h2 class="entry-title" itemprop="headline"><a href="%s" target="_self">%s</a></h2>', $postPermalink, $postTitle );
    
}

// Creates a custom read more link.
function modify_read_more_link( $templateType = 'archive' ) {

	if( $templateType == 'archive' ) {
		$readMore = '<a class="button button-minimal button-icon" href="'.get_permalink().'" target="_self">Read more</a>';
		
	} else {
		$readMore = '<a class="more-link" href="' . get_permalink() . '">Read more</a>';
	}

	return $readMore;
}

// Changing the colour palette for the Wysiwyg editor
add_filter('tiny_mce_before_init', 'ql_MCE4_colour_options');
function ql_MCE4_colour_options($init) {

    $custom_colours = '
		"245995", "Primary",
        "282828", "Black",
        "A4A4A4", "Grey Dark",
        "D8D8D8", "Grey",
        "f8f8f8", "Grey Light",
        "FFFFFF", "White",
    ';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 1;

    return $init;
}

// echo sticky back to top button before site header
add_action('genesis_after_header', 'ql_progress_bar');
function ql_progress_bar() {

	if( is_singular( array('blog_post') ) ):

		$output = '<div class="progress-bar-wrap"><div class="progress-bar"></div></div>';

		echo $output;

	endif;
}