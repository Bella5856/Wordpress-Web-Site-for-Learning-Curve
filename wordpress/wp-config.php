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
define( 'DB_NAME', 'learning_curve' );

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
define( 'AUTH_KEY',         '$w5MwWO/);QeoK?WTEI} @{@#K/=6>b0%y(gNI YGR)RDM_U,z8AN2u1y-u8<ENj' );
define( 'SECURE_AUTH_KEY',  'Nx_ufQYv60E0}=#0bpf}KlM)*dlPEcYnj^(182]h<.ozgiKfsRm=p/*.g1pT)^&R' );
define( 'LOGGED_IN_KEY',    'H 2zJBx!&NCV=bUOXl%epI2O/,z>Qp% y yqdaI0!%[xu=)B0pqCE$K:D:C;eaM?' );
define( 'NONCE_KEY',        'ylavSFj@`=Atm@OizCMs]CPcMj,o/.}E?$CjUmziofKQldI2 8jsQ`obsM@L?Q#O' );
define( 'AUTH_SALT',        'mNJB11L.Fxx5K!5FgGl%PXdqe-nr<$Zz!*3!3C~5$TR(SvpM2MJ h;>3WfW$c>]T' );
define( 'SECURE_AUTH_SALT', 'B_*$ _+qU<52yCL.$z>}h<1F4[,^V0}CHpoSc#;0`$c(L3k,A=1&m-Ko?XQa>n &' );
define( 'LOGGED_IN_SALT',   '_uhb.AJf$-B%4aLb:A*+XQgnU<(4<ySuh*x+,j$q?uC7mO0GqSqR$={Lh4x4RzPk' );
define( 'NONCE_SALT',       ']^ms%a7~jJ| UvP k;<((ey831(Z5A%>UD3^,K@b,0$2s&[R8M>3vWyb9LAN$>B!' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
