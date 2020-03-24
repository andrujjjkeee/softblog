<?php

function getPostsCategories() {

    $result = get_terms( array(
        'taxonomy'      => 'category',
        'hide_empty'    => true,
        'get'           => '',
        'orderby'       => 'id',
        'order'         => 'ASC',
        'exclude'        => 1
    ) );

    return $result;

}

function getPostsByCategories( $taxonomyId, $page, $quantity ) {

    $args = array (
        'paged'             => $page,
        'post_type'         => 'post',
        'posts_per_page'    => $quantity,
        'orderby'           => 'date',
        'order'             => 'DESC',
        'post_status'       => 'publish',
        'suppress_filters'  => true
    );

    if ($taxonomyId != -1) {

        $taxQuery = array(
            array (
                'taxonomy'      => 'category',
                'field'         => 'term_id',
                'terms'         => $taxonomyId
            ) );

        $args['tax_query'] = $taxQuery;

    }

    return new WP_Query( $args );

}

function getSearchResult( $val ) {

    $args = array (
        'post_type'         => array( 'post' ),
        'posts_per_page'    => -1,
        'orderby'           => 'date',
        'order'             => 'ASC',
        'post_status'       => 'publish',
        's'                 => $val
    );

    return new WP_Query( $args );
}

add_action('wp_ajax_get_posts_by_category','get_posts_by_category');

add_action('wp_ajax_nopriv_get_posts_by_category', 'get_posts_by_category');

add_action('wp_ajax_get_search_result','get_search_result');

add_action('wp_ajax_nopriv_get_search_result', 'get_search_result');

//Ajax Response to pots by category
function get_posts_by_category() {

    $page = $_POST['page'];

    $taxonomyId = $_POST['taxId'];

    $posts = getPostsByCategories( $taxonomyId, $page, 4);

    $result = [];
    $result["maxPages"] = $posts->max_num_pages;

    foreach ($posts->posts as $post) {

        $postID = $post->ID;

        $thumb_id = get_post_thumbnail_id($postID);
        $thumb_url = wp_get_attachment_image_src($thumb_id,'full')[0];

        $postItem = [];
        $postItem['link'] = get_permalink($postID);
        $postItem['image'] = $thumb_url;
        $postItem['title'] = get_the_title($postID);
        $postItem['content'] = get_field('short_description', $postID );
        $postItem['date'] = get_the_time('Y-m-d', $postID );

        $result['blog'][] =  $postItem;
    }

    $out = json_encode($result);

    echo $out;
    exit;

}

//Ajax Search
function get_search_result() {

    $search_value = $_POST['search_value'];

    $posts = getSearchResult( $search_value );

    $result = [];

    foreach ($posts->posts as $post) {

        $postID = $post->ID;

        if ( get_post_status( $postID ) != 'publish' ){
            continue;
        }

        $postItem = [];

        $postItem['title'] = get_the_title($postID);
        $postItem['link'] = get_permalink($postID);

        $result['result'][] = $postItem;

    }

    $out = json_encode($result);

    echo $out;
    exit;

}