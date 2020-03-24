<?php

show_admin_bar( false );

// remove content editor
function remove_content_editor() {
    if( HOME == get_the_ID() ) {
        remove_post_type_support('page', 'editor');
    }
}

add_action( 'admin_head', 'remove_content_editor');

// Prevent Update Plugins
function filter_plugin_updates( $update ) {
    global $DISABLE_UPDATE;

    if( !is_array($DISABLE_UPDATE) || count($DISABLE_UPDATE) == 0 ){  return $update;  }

    foreach( $update->response as $name => $val ){
        foreach( $DISABLE_UPDATE as $plugin ){
            if( stripos($name,$plugin) !== false ){
                unset( $update->response[ $name ] );
            }
        }
    }

    return $update;
}

add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// Register Custom Post Type
function custom_post_type() {

    $services_labels = array(
        'name' => 'Services',
        'singular_name' => 'Services',
        'menu_name' => 'Services',
        'all_items' => 'All Services',
        'view_item' => 'View Service',
        'add_new_item' => 'Add Service',
        'add_new' => 'Add Service',
        'edit_item' => 'Edit',
        'update_item' => 'Update',
        'search_items' => 'Search'
    );
    $services_args = array(
        'labels' => $services_labels,
        'supports' => array('title','editor'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-welcome-write-blog',
        'rewrite' => array(
            'with_front' => true
        )
    );
    register_post_type('services', $services_args);

}

add_action('init', 'custom_post_type', 0);

// Add Favicon
function add_favicon() {
    $favicon_url = get_stylesheet_directory_uri() . '/favicon/favicon.ico';
    echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}

add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');

// Add Thumbnails
if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'post-thumbnails' );

// Init Global ACF fields
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page( array (
        'page_title' 	=> 'Global Information',
        'menu_title'	=> 'Global Information',
        'menu_slug' 	=> 'theme-general-settings',
        'redirect' => true,
        'post_id' => 'options'
    ));

    acf_add_options_sub_page( array (
        'page_title' 	=> 'Information',
        'menu_title'	=> 'Information',
        'menu_slug' 	=> 'theme-general-data',
        'parent_slug'	=> 'theme-general-settings',
    ) );

}

add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_version_check');