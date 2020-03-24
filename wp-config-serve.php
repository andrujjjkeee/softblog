<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'soft-spot');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(,F;d@EB<0.mM_v4Hl9Fwu_8$[TUO#_NecceQ8ve8weEOz  621Y@68n-nP9hW;E');
define('SECURE_AUTH_KEY',  '](GUx=}Ia&P=r0 ?d`5BnnJt,euRAXW^4+3oc^Rn=,=_fH3q;bi`>f&8p: <~D%T');
define('LOGGED_IN_KEY',    '^&>f NQk tB*p2z.S-_?eLHV_N:9}vC._{(Ex,Gzw04l|zoYrc_jP@QAH4.o$JC ');
define('NONCE_KEY',        '<BvB7G|Qcx%+-SnQ(g+&[Owi9^i3SOl!GnGdo/6~ub=)t]g]1RRv?swAFgwiKiJu');
define('AUTH_SALT',        'g[<3A{=zA F1$(;0Xw_~1u=.9V0~d5X8:Dt:BK3 `G`K]d[`BTIx6^-~)^{$U,~t');
define('SECURE_AUTH_SALT', 'wRN*He7]h48R-a#XIJh(0f<PR`dxb?]np,IC[3RCO^kkqe)U]eWQjkl~K:g1KlDH');
define('LOGGED_IN_SALT',   'hfcHcq,-MQaVg@6m5TsEY>pae_hdGH(_CGs2L+d@l(#YX}:zLpv+ `X5acj{iDg;');
define('NONCE_SALT',       'emiQv|X`N&^st_[bo>^6/wP@7ACNjzhD]0QO46wk/@sfrg-oK.[wc0&21y%9O%:i');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'stsp';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Prevent update plugins. */
$DISABLE_UPDATE = array( 'advanced-custom-fields-pro' );

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
