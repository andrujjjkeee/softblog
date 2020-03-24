<?php

get_header();

?>

    <div id="site__wrap" data-action="<?php echo admin_url( 'admin-ajax.php' );?>">

        <!-- page-head -->
        <div id="page-head">
            <h1 id="page-head__title"><?= $blog_title ?></h1>

            <?php get_template_part('components/blog', 'social'); ?>

        </div>
        <!-- /page-head -->

        <!-- site__content -->
        <div id="site__content">


            <?php get_template_part('components/blog', 'content'); ?>

        </div>
        <!-- /site__content -->

        <?php get_template_part('components/blog', 'aside'); ?>

        <a href="#" id="to-top">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 68 44.3" style="enable-background:new 0 0 68 44.3;" xml:space="preserve">
                    <polyline class="st0" points="41.5,3 65,22.6 42.4,41.3 "/>
                <line class="st1" x1="65" y1="22.6" x2="2.5" y2="22.6"/>
            </svg>
        </a>

    </div>

<?php

get_footer();