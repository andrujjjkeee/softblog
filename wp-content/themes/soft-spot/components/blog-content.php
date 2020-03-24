<?php

    $posts = getPostsByCategories( -1, 1, 4 );

?>

<main id="blog">

    <div id="blog__wrap">

        <div id="blog__list">

            <?php foreach ( $posts->posts as $post ):

                $postID = $post->ID;

                $thumb_id = get_post_thumbnail_id($postID);
                $thumb_url = wp_get_attachment_image_src($thumb_id,'full')[0];

                $link = get_permalink($postID);
                $title = get_the_title($postID);
                $content = get_field('short_description', $postID );
                $date = get_the_time('Y-m-d', $postID );
                $formatDate = get_the_time('M j, Y', $postID );

                ?>

                <article class="blog__item">

                    <?php if ($thumb_url): ?>
                        <a href="<?= $link ?>" class="blog__picture">
                            <img src="<?= $thumb_url ?>" alt="<?= $title ?>"/>
                        </a>
                    <?php endif; ?>

                    <div class="blog__item-wrap">

                        <div class="blog__info">
                            <time class="blog__date" datetime="<?= $date ?>"><?= $formatDate ?> </time>
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

                        <a href="<?= $link ?>" class="blog__content">

                            <h2 class="blog__topic"><span><?= $title ?></span></h2>

                            <div class="blog__text">
                                <p><?= $content ?></p>
                            </div>

                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

        <div id="blog__preload">
            <div class="loader">
                <div class="loader__wrap"></div>
            </div>
        </div>

        <div id="blog__empty">
            Nothing Found :(
        </div>

    </div>

    <div id="blog__btn-wrap">
        <a href="#" id="blog__load-more">Load more</a>
    </div>

</main>