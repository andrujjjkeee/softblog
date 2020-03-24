<?php

$footerText = get_field( 'footer-text', HOME );

?>

<!-- site__footer -->
<footer id="site__footer">
    <p>© <?= date("Y"); ?> <?= $footerText ?></p>

    <?php if( is_front_page() ): ?>
        <div id="footer-menu">
            <a href="#app-promo" class="anchor">Download app</a>
        </div>
    <?php else: ?>
        <div id="footer-menu">
            <a href="<?= get_permalink(HOME) ?>/#app-promo" class="anchor">Download app</a>
        </div>
    <?php endif; ?>

</footer>
<!-- /site__footer -->

</div>
<!-- /site -->

<!-- popup -->
<div id="popup" class="is-loading">

    <!-- popup__wrap -->
    <div id="popup__wrap">

        <!-- popup__content -->
        <section class="popup__content popup__subscribe popup_subscribe">

            <div class="popup__subscribe-frame">

                <div class="popup__subscribe-text">
                    <h3>Subscribe</h3>
                    <p>We're still building! Subscribe to get updates and offers for when we launch!</p>
                </div>

                <?= do_shortcode('[contact-form-7 id="110" title="Contact form 1"]'); ?>

                <div class="loader">
                    <div class="loader__wrap"></div>
                </div>

            </div>

            <div class="popup__subscribe-thanks">

                <div class="popup__subscribe-text">
                    <h3>Thank you.</h3>
                    <p>We’ll reach out to you shortly.</p>
                </div>

            </div>

            <span class="popup__close"></span>

        </section>
        <!-- /popup__content -->

    </div>
    <!-- /popup__wrap -->

</div>
<!-- /popup -->

<?php if( !is_front_page() ): ?>
    <script src="//widget.manychat.com/818284335046615.js" async="async"></script>
<?php endif;
wp_footer(); ?>

</body>
</html>