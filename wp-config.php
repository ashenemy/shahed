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
define( 'DB_NAME', 'shahed' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'G#@vLL6,K5~oO5b=Q[+yG.b/CFM8@x_h~}ieR$u6p_h2+,e0.`t~t.c39rc44 h1' );
define( 'SECURE_AUTH_KEY',  ',W0zX|ltfx~7V2KzOn2$^wM`-w$*?bEOoH6$#q`i ;p~8Xl-5 A)J;y5wCcbG)lq' );
define( 'LOGGED_IN_KEY',    'IrplL9|Un0-UyG1p#e}bjH:[F[VyE1 S(Kga<h>&#tnz9N**T_Y}5UJ3X*UU_Ig&' );
define( 'NONCE_KEY',        '.T0CdQTA6sEhItdyOA0f;]a8@6C|L{@I8i&|-ZKb &~Sfyc8|J^VH/wZHQpO4<Ul' );
define( 'AUTH_SALT',        '*$N*VsJ9~Z2&SIj!mDO2T}Bli.(&06efN,|I>3TjqB|#uZ}#|(y&xq-pft,fP`Q,' );
define( 'SECURE_AUTH_SALT', 't$+n?Y%~?kNss=tW] +A!_Ne>m(f3T4i ZD3=_lP0Ta^&|FPbhMyyNK<DblyKF?o' );
define( 'LOGGED_IN_SALT',   '+KIQhKs1v`//@/6)1j$CZyd.cpCeUW?K jZ&%,Xq@AA8NH;6PG~]lI$XmaKoBFVF' );
define( 'NONCE_SALT',       'ULmPtmJ;(diZ*@&<saY97P:umZ%bd]>aDt(`0IhWf,6>UV,~[Km5W1j71I:T7AoG' );

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
