<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'studimky_rollcoblog_app' );

/** Database username */
define( 'DB_USER', 'studimky_rolbusr' );

/** Database password */
define( 'DB_PASSWORD', 'Tbra@#12aa' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );
//define( 'DB_HOST', '18.212.59.161' );


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
define( 'AUTH_KEY',         'spFbV@nflr3%iAkqQ_Q$ISj|YRjF:3:xRNvW~0]5>c-cT;km!Z}>UZ)*9BC8>2zL' );
define( 'SECURE_AUTH_KEY',  '7pQ4[[/<PK#[U/J(/CB_*R0[c+jtU9e=(X lRkldB`*zE5f-Nq%^yW;x%RK&=RaA' );
define( 'LOGGED_IN_KEY',    'F44_A4}fXT7woj:XI}4SxJaBK=vb@A^qQZH|E@<kgBr=wGh=W#@j{)Y3S?4JS.r8' );
define( 'NONCE_KEY',        'B4[l3Q,%cH9suM48pmjEP3SLN~=`l,5_Euc1k$EVr0{H.=z4R$+C><fqUfdtL3-{' );
define( 'AUTH_SALT',        '}PkZK6|U|c(`M%?9ceR[TJJ{E].#o]OB3(o2)Oyp:p>siq@P7]MZgr`}nu*|pVT:' );
define( 'SECURE_AUTH_SALT', 'V}$MeU)G>QM-]f04MWDM@H`o3>?d*v/;$?}?[^7ro.yj}o1CR.>m0NVCnf}Z+Y: ' );
define( 'LOGGED_IN_SALT',   '(N/BZKjjXeY:To>M^E2z_bR2:l,O?+DM$XvEUhr[*$%5v~tt/<b$4QQkNt?&W2/j' );
define( 'NONCE_SALT',       'Rt8!s3qF1Shi*$02W{ }}&}q<9^G3YHYC*|C=nQN_*OU4?KkvOKD(%x_y8Yu3Ofi' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
