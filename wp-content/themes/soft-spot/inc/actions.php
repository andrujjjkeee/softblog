<?php
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_action('wp_head', 'signuppageheaders');

show_admin_bar( false );

// Init Menu
register_nav_menus( array(
    'header_menu' => 'header_menu'
) );

// Init Shortcodes
add_filter( 'the_content', 'do_shortcode' );
add_filter( 'wpcf7_form_elements', 'do_shortcode' );

// Move Files To Footer
remove_action('wp_head', 'wp_print_scripts');
remove_action('wp_head', 'wp_print_head_scripts', 9);
remove_action('wp_head', 'wp_enqueue_scripts', 1);
add_action('wp_footer', 'wp_print_scripts', 5);
add_action('wp_footer', 'wp_print_head_scripts', 5);
add_action('wp_footer', 'wp_enqueue_scripts', 5);

// Add Styles and Scripts
function add_files() {

    // scripts
    wp_deregister_script('jquery');

    wp_register_script('jquery', get_template_directory_uri() . '/assets/dist/js/vendors/jquery-3.3.1.min.js', false, false, true);
    wp_register_script('swiper_js',get_template_directory_uri().'/assets/dist/js/vendors/swiper.min.js', false, false, true);
    wp_register_script('scrollbar',get_template_directory_uri().'/assets/dist/js/vendors/perfect-scrollbar.min.js', false, false, true);

    wp_register_script('index-script', get_template_directory_uri() . '/assets/dist/js/index.min.js', false, false, true);
    wp_register_script('blog-script', get_template_directory_uri() . '/assets/dist/js/blog.min.js', false, false, true);

    // styles
    wp_register_style('main-styles', get_template_directory_uri() . '/assets/dist/css/common.css' );
    wp_register_style('swiper-styles', get_template_directory_uri() . '/assets/dist/css/swiper.min.css' );

    // enqueue scripts
    wp_enqueue_script('jquery');

    if ( is_page_template('pages/page-home.php') ) {

        wp_enqueue_script('index-script');

        wp_enqueue_style( 'swiper-styles' );

    }

    if ( is_page_template( 'pages/page-blog.php' ) || is_singular('post') || is_category() ) {

        wp_enqueue_script('scrollbar');
        wp_enqueue_script('blog-script');

    }

    wp_enqueue_style( 'main-styles' );

}

add_action( 'wp_enqueue_scripts', 'add_files' );

// Custom Logo
function add_logo() {
    $logo_img = '';
    if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
        $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
            'class'    => 'custom-logo',
            'itemprop' => 'logo',
        ) );
    }
    echo $logo_img;
};

add_theme_support( 'custom-logo' );

// Format Phone
function format_phone( $country, $phone ) {
    $function = 'format_phone_' . $country;

    if( function_exists( $function ) ) {
        return $function( $phone );
    }

    return $phone;
}

function format_phone_us( $phone ) {

    if(!isset($phone{3})) { return ''; }

    $phone = preg_replace("/[^0-9]/", "", $phone);

    $length = strlen($phone);

    switch($length) {
        case 7:
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
            break;
        case 10:
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
            break;
        case 11:
            return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
            break;
        default:
            return $phone;
            break;
    }

}