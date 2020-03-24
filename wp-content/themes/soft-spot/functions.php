<?php
define( 'TEMPLATEINC', TEMPLATEPATH . '/inc' );
define( 'TEMPLATEURI', get_template_directory_uri() );
define( 'DIRECT', TEMPLATEURI.'/assets/dist/' );

define( 'HOME', 8 );
define( 'BLOG', 181 );
define( 'OPTIONS', 'options' );

require_once( TEMPLATEINC . '/cpt.php' );
require_once( TEMPLATEINC . '/actions.php' );
require_once( TEMPLATEINC . '/ajaxes.php' );