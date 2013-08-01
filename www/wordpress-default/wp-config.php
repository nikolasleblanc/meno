<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_default');

/** MySQL database username */
define('DB_USER', 'wp');

/** MySQL database password */
define('DB_PASSWORD', 'wp');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 */
define('AUTH_KEY',         ':Y:_ii46hnH!&DbiHjtf-1$L :AK^~XMpmc;Ec}<-^%}A#b_q#x6u 2Meko])V`6');
define('SECURE_AUTH_KEY',  'A^`AK|m5>T<F-Re~C-tOmI`xw_oY=)|jK1-V}#!b{tj7FWIPuU_d2r/V*/&jzndi');
define('LOGGED_IN_KEY',    '2{sn2;U y5]//,`{b|(Q?_Y;exOFo+rRT9Po4[()r?<L66_)lctefNQ=sH_)%&T!');
define('NONCE_KEY',        'hDJiK5|e6V|.-*wv~I:-I$`N>4>%Isvm}xx&7A]N?b-IKbhB5vpA$te|e8l9NY:F');
define('AUTH_SALT',        'De(-/UC;Zl_CK`,0m>+K>p|`TZ!E-t!f*F[5+4>SDmYGi_Dq}q|?@_x?Wuig8-#Z');
define('SECURE_AUTH_SALT', 'D0RE~)!-)?,BRI}vF%tQ;WEEM&+RDF>-zF+p_)N/1#(0aK=DiQ):=]4U.|<lofFR');
define('LOGGED_IN_SALT',   'VJ*%YdVp#AIJ|Rl#)x#I$ul&u&47PBf[E.>|T[E-,]rv|&?5.KUPOT(rNRk9E{/]');
define('NONCE_SALT',       '+o7/]<X{dc8TU{5yq;G}(GNUd#`H7u72|-XDSISZOI]DZVL/A9sK5t3J<8;VL5p?');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

define( "WP_DEBUG", true );


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
