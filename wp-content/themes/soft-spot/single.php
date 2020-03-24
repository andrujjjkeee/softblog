<?php

    get_header();

    $id = get_the_ID();

    $title = get_the_title();

    $thumb_id = get_post_thumbnail_id();
    $thumb_url = wp_get_attachment_image_src( $thumb_id,'full')[0];

    $postThumb = get_field( 'post_thumb', $id );
    $customThumb = get_field( 'post_picture', $id );

    $tagsArg = array(
        'taxonomy'      => 'category',
        'hide_empty'    => true,
        'get'           => '',
        'orderby'       => 'id',
        'order'         => 'ASC',
        'exclude'        => 1,
    );

    $tags = wp_get_post_categories( $id, $tagsArg );

    $date = get_the_time('Y-m-d' );
    $formatDate = get_the_time('M j, Y' );

?>

    <div id="site__wrap" data-action="<?php echo admin_url( 'admin-ajax.php' );?>">

        <!-- page-head -->
        <div id="page-head">
            <a href="<?= get_permalink(BLOG) ?>" id="page-head__back">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 68 44.3" style="enable-background:new 0 0 68 44.3;" xml:space="preserve">
                    <polyline points="41.5,3 65,22.6 42.4,41.3 "/>
                    <line x1="65" y1="22.6" x2="2.5" y2="22.6"/>
                </svg>
                Back to blog</a>

            <?php get_template_part('components/blog', 'social'); ?>

        </div>
        <!-- /page-head -->

        <!-- site__content -->
        <div id="site__content">

            <div id="post">

                <div id="post__head">

                    <div id="post__info">
                        <time id="post__date" datetime="<?= $date ?>"><?= $formatDate ?> </time>

                        <?php if( !is_null($tags) ): ?>
                            <ul id="post__tags">
                                <?php foreach ( $tags as $tagsID ): ?>
                                    <li><a href="<?= get_category_link( $tagsID ) ?>"><?= get_category( $tagsID )->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                    <h1 id="post__title"><?= $title ?></h1>

                    <a href="https://twitter.com/softspotapp" class="twttr">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 49.3 40" style="enable-background:new 0 0 49.3 40;" xml:space="preserve">
                                            <path d="M49.3,4.7c-1.8,0.8-3.8,1.3-5.8,1.6c2.1-1.2,3.7-3.2,4.4-5.6c-2,1.2-4.1,2-6.4,2.5C39.6,1.2,37,0,34.1,0
                                                C28.5,0,24,4.5,24,10.1c0,0.8,0.1,1.6,0.3,2.3C15.9,12,8.4,8,3.4,1.8C2.6,3.3,2.1,5.1,2.1,6.9c0,3.5,1.8,6.6,4.5,8.4
                                                c-1.7-0.1-3.2-0.5-4.6-1.3c0,0,0,0.1,0,0.1c0,4.9,3.5,9,8.1,9.9c-0.8,0.2-1.7,0.4-2.7,0.4c-0.7,0-1.3-0.1-1.9-0.2c1.3,4,5,6.9,9.4,7
                                                c-3.5,2.7-7.8,4.3-12.6,4.3c-0.8,0-1.6,0-2.4-0.1C4.5,38.4,9.8,40,15.5,40c18.6,0,28.8-15.4,28.8-28.8c0-0.4,0-0.9,0-1.3
                                                C46.2,8.5,47.9,6.8,49.3,4.7z"/>
                                        </svg>
                        Follow @softspotapp
                    </a>

                </div>

                <div id="post__thumb">

                    <?php if ($customThumb): ?>
                        <p><img src="<?= $customThumb['url'] ?>" alt="<?= $customThumb['alt'] ?>"/></p>
                    <?php elseif ($thumb_url): ?>
                        <p><img src="<?= $thumb_url; ?>" alt="<?= $title; ?>"/></p>
                    <?php endif; ?>

                </div>

                <article id="article">

                    <?php if( have_posts() ){ while( have_posts() ){ the_post();
                        the_content();
                    } } ?>

                </article>

            <?= do_shortcode('[Fancy_Facebook_Comments]'); ?>

            </div>

            <?php get_template_part('components/component', 'navigation'); ?>

        </div>
        <!-- /site__content -->

        <?php get_template_part('components/blog', 'aside'); ?>

    </div>

<?php

get_footer();