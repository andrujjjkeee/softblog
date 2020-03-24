<?php

    $next_post = get_adjacent_post(0, '', 0) -> ID;
    $prev_post = get_adjacent_post() -> ID;

    function get_last_post_link(){
        $args = array (
            'paged' => 1,
            'post_type'  => 'post',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'suppress_filters' => true
        );
        $query = new WP_Query;
        $my_posts = $query -> query($args);
        return $my_posts[0];
    }

    function get_latest_post_link(){
        $args = array (
            'paged' => 1,
            'post_type'  => 'post',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'orderby' => 'date',
            'order' => 'ASC',
            'post_status' => 'publish',
            'suppress_filters' => true
        );
        $query = new WP_Query;
        $my_posts = $query -> query($args);
        return $my_posts[0];
    }

//    if ( !$prev_post ){ $prev_post = get_last_post_link(); };
//    if ( !$next_post ){ $next_post = get_latest_post_link(); };

?>

<div id="post-navigation" data-action="<?php echo admin_url( 'admin-ajax.php' );?>">
    <?php if ( $prev_post ){ ?>
    <a href="<?= get_permalink( $prev_post ) ?>" data-id="<?= $prev_post ?>" title="<?= get_the_title( $prev_post ) ?>">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 68 44.3" style="enable-background:new 0 0 68 44.3;" xml:space="preserve">
                <polyline points="41.5,3 65,22.6 42.4,41.3 "/>
                <line x1="65" y1="22.6" x2="2.5" y2="22.6"/>
            </svg>
            <span>Previous</span>
        </span>
        <p><?= get_the_title( $prev_post ) ?></p>
    </a>
    <?php }
    if ( $next_post ){?>
    <a href="<?= get_permalink( $next_post ) ?>" data-id="<?= $next_post ?>" title="<?= get_the_title( $next_post ) ?>">
        <span>
            <span>Next</span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 68 44.3" style="enable-background:new 0 0 68 44.3;" xml:space="preserve">
                <polyline points="41.5,3 65,22.6 42.4,41.3 "/>
                <line x1="65" y1="22.6" x2="2.5" y2="22.6"/>
            </svg>
        </span>
        <p><?= get_the_title( $next_post ) ?></p>
    </a>
    <?php } ?>
</div>
