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
define('DB_NAME', 'vnpt');

/** MySQL database username */
define('DB_USER', 'VNPT');

/** MySQL database password */
define('DB_PASSWORD', '123456');

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
define('AUTH_KEY',         'Dv25FquL/B1#TkJ9wcq5ITXD!B!yd4SO}yoW3Np}Le(,<wf}pu{<AOaZai]QFv:/');
define('SECURE_AUTH_KEY',  'w*,UrMu?N266<$C[b~3jL`!h!SHo.l*Mw>:$N9L?1Hf_vLUvLvP`BtX*O8-1O42)');
define('LOGGED_IN_KEY',    'b-{j/$&=T.f&}n6g*#BeVR!@Zt2yQELm#-K`Yj8-UV?/Y$BjwT)uy_Y B5USAS#_');
define('NONCE_KEY',        '`lNsG^0,aJuojE=,?L&YQQwTIUE2U?|z,RX]P?,P,uhzB]m[os({V=Y<Yw)-hW;E');
define('AUTH_SALT',        'F5|4J:y<8Nsi~U7^grC%R[Y1@P^cp%_#:E>8J*sIA 9l943J.1$/`R(.^V&jqgZN');
define('SECURE_AUTH_SALT', ':kj+267X]3M!6G[4[S,seO4.ms(M>bK%o%aX4#/dWXwn/Kqr1%F(iSDRJV cgmAl');
define('LOGGED_IN_SALT',   '[gu4kHYFN.yrjr/l/>s]/b>dK4}.;5D{UK=4@F==nL)[S3y@?,9Cn8 tSlyrl G}');
define('NONCE_SALT',       '$q% o|iU6{Br,*YW ;?loh|:s|N5$F;<T8q+6-bmB?bp/:XcPGj:h+H%EAK0!Qc(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
//define('WP_DEBUG', false);
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
