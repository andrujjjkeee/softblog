<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <?php if ( is_front_page() ): ?>
        <title><?= get_bloginfo( 'name' ) .' - '. get_bloginfo( 'description' ); ?></title>
    <?php else:  ?>
        <title><?php wp_title(''); ?></title>
    <?php endif; ?>

    <link rel="apple-touch-icon" sizes="57x57" href="<?= DIRECT ?>favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= DIRECT ?>favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= DIRECT ?>favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= DIRECT ?>favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= DIRECT ?>favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= DIRECT ?>favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= DIRECT ?>favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= DIRECT ?>favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= DIRECT ?>favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= DIRECT ?>favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= DIRECT ?>favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= DIRECT ?>favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= DIRECT ?>favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= DIRECT ?>favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <?php
        wp_head();
        if( is_front_page() ):
    ?>
        <style>
            <?php echo file_get_contents( DIRECT .'css/preload.css' ) ?>
        </style>
    <?php else: ?>
        <style>
            <?php echo file_get_contents( DIRECT .'css/preload-blog.css' ) ?>
        </style>
    <?php

        endif;

        define( 'PET_PARENT_LINK', get_field( 'link-pet-parent', HOME ) );
        define( 'VET_LINK', get_field( 'link-vet', HOME ) );

        $contactPhone = get_field( 'phone', HOME );
        $phone = format_phone('us', $contactPhone);

    ?>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124686835-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-124686835-2');
    </script>

</head>
<body>

<!-- preload -->
<div id="preload">
    <span id="preload__loading-line"></span>
</div>
<!-- /preload -->

<!-- site -->
<main id="site">

    <!-- site-header -->
    <header id="site-header" <?php if( is_front_page() ): ?> class="is-loading" <?php endif; ?>>

        <?php if( is_front_page() ): ?>
            <h1 id="logo">
                <img src="<?= DIRECT ?>img/logo-soft-spot.svg" alt="Soft-Spot"/>
            </h1>
        <?php else: ?>
            <a href="<?= get_home_url(); ?>" id="logo">
                <img src="<?= DIRECT ?>img/logo-soft-spot.svg" alt="Soft-Spot"/>
            </a>
        <?php endif; ?>

        <div id="site-header__mobile-wrap">

            <div id="site-header__mobile-layout">

                <div id="site-header__sign-up">
                    <p>sign up as</p>

                    <div>
                        <a href="#" class="popup__open" data-popup="subscribe"><span>Pet Parent</span></a>
                        <a href="#" class="popup__open" data-popup="subscribe"><span>Vet</span></a>
                    </div>

                </div>

                <div id="site-header__wrap">

                    <a href="tel:<?= $contactPhone ?>" id="site-header__phone"><?= $phone ?></a>

                    <?php get_template_part('components/component', 'menu'); ?>

                </div>

            </div>

        </div>

        <span id="hamburger">
                <span></span>
            </span>

    </header>
    <!-- /site__header -->