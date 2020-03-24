<nav id="menu">
    <ul>

        <?php

        $currentSingleType = null;

        if ( is_singular('post') || is_category() ) {
            $currentSingleType = BLOG;
        }

        $locations = get_nav_menu_locations();
        $menu_items = wp_get_nav_menu_items( $locations[ 'header_menu' ] );

        foreach ( (array)$menu_items as $key => $menu_item ):

            $active = '';

            if( $post -> ID == $menu_item -> object_id || $menu_item->object_id == $currentSingleType  ){
                $active = 'class="is-active is-loading"';
            }

            ?>

            <li <?= $active; ?>>

                <a href="<?= $menu_item -> url; ?>"><?= $menu_item->title; ?></a>

                <?php
                if ( $active ){
                    echo '<div class="menu__cat"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26.76 22.2">
                                            <path d="M3.09,15.5a11.72,11.72,0,0,0,1.6,6.4.86.86,0,0,0,.6.3h0c.1,0,.2-.1.3-.1a21.65,21.65,0,0,0,3.8-4c.4.1.9.1,1.6.2h2.7a20.9,20.9,0,0,0,2.5-.1,5.21,5.21,0,0,0,1.4-.2,21.33,21.33,0,0,0,3.8,4,.52.52,0,0,0,.4.2c.2,0,.3-.1.4-.3a11.94,11.94,0,0,0,1.6-6.4c3.4-5.9,3.1-10.1,2.8-14.5V.5A.56.56,0,0,0,26,0h0a.56.56,0,0,0-.5.6v.6c.3,4.4.6,8.2-2.7,13.9a.37.37,0,0,0-.1.3,12.57,12.57,0,0,1-1.1,5.3,18.48,18.48,0,0,1-3.3-3.5.78.78,0,0,0-.7-.3,4.23,4.23,0,0,1-1.6.2,19.27,19.27,0,0,1-2.4.1H11a5.42,5.42,0,0,1-1.7-.2.52.52,0,0,0-.7.3,17,17,0,0,1-3.2,3.5,12.78,12.78,0,0,1-1.2-5.2.76.76,0,0,0-.1-.4C.39,8.6.89,5,1.49.8a.6.6,0,0,0-.1-.4A.52.52,0,0,0,1,.2a.6.6,0,0,0-.4.1.52.52,0,0,0-.2.4C-.31,5.4-.41,9.1,3.09,15.5Z"></path>
                                            <path d="M12.39,12.1a.76.76,0,0,0,.4-.2,4.35,4.35,0,0,1,.6-.7l.7.7a.52.52,0,0,0,.4.2c.2,0,.3,0,.4-.1a.52.52,0,0,0,.2-.4c0-.2,0-.3-.1-.4a3.18,3.18,0,0,0-1-1V9.3c.1-.2.1-.3.2-.5a3,3,0,0,1,.4-.8.6.6,0,0,0,.1-.4.76.76,0,0,0-.2-.4.37.37,0,0,0-.3-.1c-.2,0-.3.1-.5.2a2.19,2.19,0,0,1-.3.5c-.1-.2-.2-.3-.3-.5a.66.66,0,0,0-.7-.2.72.72,0,0,0-.2.8.76.76,0,0,1,.2.4,3.51,3.51,0,0,0,.5.8V10a6.47,6.47,0,0,0-.8.9l-.1.2a.64.64,0,0,0,0,.6C12,12.1,12.19,12.2,12.39,12.1Z"></path>
                                        </svg>
                                        <span class="menu__cat-eye-left"></span>
                                        <span class="menu__cat-eye-right"></span>
                                    </div>';
                }
                ?>

            </li>

        <?php endforeach; ?>

    </ul>
</nav>