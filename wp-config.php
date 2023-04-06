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
define( 'DB_NAME', 'portfolio_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '9BkN&AeNS7 W 1I)jfZz]yxkW^v~zVK=oRaei^=0X3uPZ[)p;G Y/AmY$lJ<qS0/' );
define( 'SECURE_AUTH_KEY',  'W~4u`/~Fr2{) |uRT8B2{F`hbU;y}-^0(FK}UJ&CaG);2/ydpma],{zd<&6%e/OB' );
define( 'LOGGED_IN_KEY',    'snuRP=f5z{^mE}%m;x$t&^CEFdMA`N@cPdbC1S5T{sJgP6E_(Azz+pr{c2{|Tb&V' );
define( 'NONCE_KEY',        '`lQLXky)ya$hfH8d=#U bK)6ue- J2WQe3~?;YnhqaD.aH{m %<{/If%RE!mMc:O' );
define( 'AUTH_SALT',        'J&8v &jeTn,-qOO`N{+6f:>M%!2sa nqaE$n<~%L%ClZ/[4z9ZC35=0Kq5KM{pi6' );
define( 'SECURE_AUTH_SALT', 'I=,s (VnXfSe]mE1:*yD-B|5M7^D7{Aj*!kC:?dQKc{(LgT,Gen Ug^c7KV@o0kL' );
define( 'LOGGED_IN_SALT',   'K?X7>3tJ;)3OER_1oZoHF/PaRsL64[ +0hI8_!zQU[06):;qsnKU@?>;L,#ZsF/e' );
define( 'NONCE_SALT',       '8Rd3)=yoYsxqrer1gv/->P#rv.@:9Wlh`Z/.if Awt&x!B{=?<5aF5-!29D``?r!' );

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
