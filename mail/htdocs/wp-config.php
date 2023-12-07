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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'epiz_25689729_w484' );

/** MySQL database username */
define( 'DB_USER', '25689729_1' );

/** MySQL database password */
define( 'DB_PASSWORD', '5]Sp4(d399' );

/** MySQL hostname */
define( 'DB_HOST', 'sql109.byetcluster.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'vxfh5sslaaaykgznqneqyk6s1louxfxfwbttelvousvvtla3vq9ap9icq15v8pke' );
define( 'SECURE_AUTH_KEY',  '45u9459ofczb2k8dkikrlylpqh4lwsls830ksifcqgk84y2njx0rmqxelpmfatdg' );
define( 'LOGGED_IN_KEY',    '0y9eu7kb218bnp4cxni9dg4hlx8pjsw9y98nyuliqdzvryhyqmbykg1nqu2i47in' );
define( 'NONCE_KEY',        'zt9m9yj1om20bne9d2v0hx1wj6kzhognjkzp6llzd1kyvtywewtnucx2ea9ashkk' );
define( 'AUTH_SALT',        'sqtd7efpxaavbvixxajfuvjxx7a7pbmal8u66yl0ueb5nmq6y8e6u8rccsawpkyp' );
define( 'SECURE_AUTH_SALT', 'o8mwcylcu2j2xuibmy5buez37ebzvrwgebwkenspblf9vkiwvuzbq7dsmkxqaj2z' );
define( 'LOGGED_IN_SALT',   'owalcng71m8brasoradinpmn2dncednlbearlh7lpeu3isnpckhu4s9chmvdp8kr' );
define( 'NONCE_SALT',       'ototmfijgunytx1cppomod7giojkftwmm0efmbtrlripaavenufrz00ir2thnxib' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpvp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
