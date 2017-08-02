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
define('DB_NAME', 'techdouc_cztawp');

/** MySQL database username */
define('DB_USER', 'techdouc_cztawp');

/** MySQL database password */
define('DB_PASSWORD', 'qL853-cpS.');

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
define('AUTH_KEY',         'auiaqgsx5dfcj5i4gbwttmo7yue82gvrjvtc4dazswcjt51wf5cy27msbntk1kad');
define('SECURE_AUTH_KEY',  '1nkgpk3vs7pzw5owejjhszstv1ynb22h5px9s6xyf9v8r7lgzlwfcekvfoxvqvyz');
define('LOGGED_IN_KEY',    'mttsawilvsectgvyqzpsxldbdkihgnfjilbfslad8bvn5zo9a25kn6lhe1avdmqy');
define('NONCE_KEY',        'ojvdkea4500gr01eac5kcjfcuqkuxc9zwrnac6ecefutwlspq42hr9nll9zcflti');
define('AUTH_SALT',        'cxac7h8ku19kgbrvzlc7c5quf2vliq4jllqhurvtatyrzm6gfb4ngdcdqusnydem');
define('SECURE_AUTH_SALT', 'fcfuknm5ui8xkep1mjdwx8alohvbt9br6ex9rl56mbscws0phg4kj1nscds9rkwo');
define('LOGGED_IN_SALT',   'gn14mdkq3pipgx7nshwrapcz17iicfguhfyr5kkfygcduqr9gqoml4ixfahbsstv');
define('NONCE_SALT',       'ug0jqz1ujismrtf3gvmaecbjrjvyasxdnf6bysznevvg2fhcmd26nzkbfkwjpk4h');

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
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_AUTO_UPDATE_CORE', false );

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.calizota.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
