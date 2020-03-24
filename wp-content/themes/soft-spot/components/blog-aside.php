<?php

    $id = get_the_ID();

    $categories = getPostsCategories();
    $count = wp_count_posts()->publish;

    if ( is_page_template( 'pages/page-blog.php' ) || is_category() ) {
        $id = BLOG;
    }

    $recommended_posts = get_field('recommended_posts', $id);

    $recommendedPostsShow = false;

    if ( !empty($recommended_posts) ) {
        foreach ($recommended_posts as $itemID) {
            if ( get_post_status($itemID) == 'publish' && $id !== $itemID ) {
                $recommendedPostsShow = true;
                break;
            }
        }
    }

?>
<!-- site__aside -->
<aside id="site__aside">

    <div id="fb-widget">

        <div class="fb-page" data-animclass="fadeIn " data-href="https://www.facebook.com/softspotvet" data-hide-cover=false data-width="260" data-height="" data-show-facepile=false  data-show-posts=false data-adapt-container-width=false data-hide-cta=false data-small-header="false"></div>

        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.async=true;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=395202813876688";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

    </div>

    <!-- search -->
    <div id="search">

        <!-- search__form -->
        <div id="search__form">

            <input type="text" placeholder="Search" />
            <button type="submit" id="search__btn-find">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 62.2 60.2" style="enable-background:new 0 0 62.2 60.2;" xml:space="preserve">
                                <g>
                                    <circle cx="29" cy="29" r="26"/>
                                    <line x1="49" y1="47" x2="59.2" y2="57.2"/>
                                </g>
                            </svg>
            </button>

        </div>
        <!-- /search__form -->

        <!-- search__popup -->
        <div id="search__popup">
            <div id="search__popup-scroll-wrap">
                <div id="search__result"></div>
            </div>
            <div id="search__preloader">
                <div class="loader">
                    <div class="loader__wrap"></div>
                </div>
            </div>
            <div id="search__empty">
                Nothing Found :(
            </div>
        </div>
        <!-- /search__popup -->

    </div>
    <!-- /search -->

    <?php if(!is_null($categories)): ?>

        <!-- blog-categories -->
        <section class="aside-section categories">

            <h3 class="aside-section__topic">Categories</h3>

            <?php

            $js_category = '';

            if ( is_page_template( 'pages/page-blog.php' ) || is_category() ){
                $js_category = ' categories';
            }

            ?>

            <div class="aside-section__list <?= $js_category ?>">
                <?php

                    $active = '';

                    if ( is_page_template( 'pages/page-blog.php' ) ){
                        $active = ' is-active';
                    }
                ?>
                <a href="<?= get_permalink(BLOG) ?>" class="aside-section__item categories__item <?= $active ?>" data-id="-1">All (<?= $count ?>)</a>
                <?php foreach ($categories as $key => $category):

                    $active = '';

                    if( $category -> term_id === get_queried_object() -> term_id ) {
                        $active = ' is-active';
                    }

                    ?>
                    <a href="<?= get_category_link( $category ) ?>" class="aside-section__item categories__item <?= $active ?>" data-id="<?= $category->term_id; ?>"><?= $category->name; ?> (<?= $category->count ?>)</a>
                <?php endforeach; ?>
            </div>

        </section>
        <!-- /blog-categories -->

    <?php endif; ?>


    <?php if( $recommendedPostsShow ): ?>
    <!-- top-articles -->
    <section class="aside-section">

        <h3 class="aside-section__topic">Recommended posts</h3>

        <div class="aside-section__list">
            <?php foreach ( $recommended_posts as $itemID ):
                if ( get_post_status($itemID) != 'publish' || $id == $itemID ){
                    continue;
                };

            ?>
            <a href="<?= get_permalink( $itemID ) ?>" class="aside-section__item"><?= get_the_title( $itemID ) ?></a>
            <?php endforeach; ?>

        </div>

    </section>
    <!-- /top-articles -->
    <?php endif; ?>

</aside>
<!-- s/ite__aside -->