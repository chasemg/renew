<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'renew_my_healthcare');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '~4VgQ|<GL-9;b >ln&KT.ELz+.$C&rWw:{ NQL/K8^TE-,.zw!tPk;p#?5tf{z[i');
define('SECURE_AUTH_KEY',  'z8BLKF#fS+-I@o|7s0Rz0~7}J)_Rly^x+0:!Of,?yf:8+q1B5[)b7#-Rl1oaVbv]');
define('LOGGED_IN_KEY',    'PO#(/T5A[9$]bzGNQzX<`-cv4mU)Ll!]B7<LI|Ql*sLw0w]CtKuk-b}fDv1gUVz]');
define('NONCE_KEY',        'QSPVf(<R|ne*-bOWna#W3u&-iw+dxeR<t|o(Nkbw1%IFI)R]f}AO,{B5l2BM_Eel');
define('AUTH_SALT',        '9XacH0JRwiRqY@{qzG`*y&2Qh$JSkgO`-aN}cs5Se#vtduN{: v2mB:hv*OmXpzh');
define('SECURE_AUTH_SALT', 'Sf!:}q#J7Wcce!c.a@]B3ll,T;tS)63>ei-V&Ww o-%j%I|l//ad1-3!TL6ssTSY');
define('LOGGED_IN_SALT',   'lQbKjR#Ft$BEiKJB.H|#>?2y %RnHaCj&mX)v%%{#W6W<[zlut(b0$!dq6|v~mX4');
define('NONCE_SALT',       '_3htw[T3NF{!m@[!nlT||a,wY6`Y~72yFQUn&Pl#MTCz.(|g.!`$Bc aX@I-xK+z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rmh_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
