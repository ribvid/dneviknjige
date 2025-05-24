<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dneviknjige' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/}r/542NnCc0^Q{?/.4O_7&sCl9Zj0IzXbMVd_B}#_*HA{=M,!ys;pZZi0V!mZJO' );
define( 'SECURE_AUTH_KEY',  'vh;)zfw&>%@[$&)CchUnr}xs,Z. ::G*e!c^PCzcTRn?6=S/2A$3L!XK0,Y2it!;' );
define( 'LOGGED_IN_KEY',    'ZFxc>=/H_7!%!+]kD|xNWwdN4/.wiFVjf&;qbxTStiEjoTE6NJIyLe#tO;/#OT~I' );
define( 'NONCE_KEY',        'v-r>L{W[N=t7{((P)H8A:A(~/y;.8;~kc5$2HT-:,#z6H6CwK`t&*^k]>Vd<)?b+' );
define( 'AUTH_SALT',        'XsPNGXR#/QObeZfOz4]]++L{Ms:-T[1HM37M@8~{?,U%3MM}#C*$A{T0n Q6o3:0' );
define( 'SECURE_AUTH_SALT', '8QBUT:Xil.Q``h_HI?2 {0=WSO@*9SxlR[OQuB,DdkIjBCJG&n=X>;c_S%6y9ko`' );
define( 'LOGGED_IN_SALT',   ':m]I9WCi:wh&c)`S5I.(@C=5Q}&tI1utBbGaJb~$&?Z,C6>A`a)JxEC]r6~,ZJ@(' );
define( 'NONCE_SALT',       'jex}0#O:UwU2:CfwH/5oG?)li)Gh7MT8>R>_>?7g<)iT`?MFI]g{#8G>=By(TU95' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
