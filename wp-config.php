<?php
//Begin Really Simple SSL JetPack fix
define( "JETPACK_SIGNATURE__HTTPS_PORT", 80 );
//END Really Simple SSL

define('WP_CACHE', false); // Added by WP Rocket
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
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/minhmark/public_html/sushitony.com/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'sushitony_com');
/** MySQL database username */
define('DB_USER', 'sushitony_com');
/** MySQL database password */
define('DB_PASSWORD', 'Z0iuQ3r3j');
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
define('AUTH_KEY',         'ezt2pocwqwzrfgld0tpawabzkolgl2hnpxz54vx9j1gn0mhzmspfedd98hm61qai');
define('SECURE_AUTH_KEY',  'c2lrseqkcbnuzqitugclbjgnu2xxyspwmirpbb39z1epmai9crqilbjci06a1dch');
define('LOGGED_IN_KEY',    'fxdfrl1rzpwgylzliibptnuerjrwarxp7iz4zs8ajhsnteadklsvqez2vf2wk54g');
define('NONCE_KEY',        '6wboj2ok7w1t6eiqk2mazkjvwkfdlm2jvcr8l6xebeo2pksdhfjnnb1zm4cyfmtp');
define('AUTH_SALT',        'yqusejsgrclsbuqpcrosvshw2ekx9ognd0j1tkuewuei3ssyo3xgjis2ljudjpij');
define('SECURE_AUTH_SALT', '8qcujzluyr7dlg1jsbxe9nf90xerzvqpseagjzc1syqgcvzh6tflteanvdylhd5l');
define('LOGGED_IN_SALT',   'eriaankyep8yrm3apctuygkq0tmup8zmpskbo7owuezqrjglnd8p6r3celsajli2');
define('NONCE_SALT',       'dzwv1i0g18j5dmspv5esudao3mxbjzb3rckzqh0jsggiabekdrscu91myyppgpii');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wplm_';
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
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
