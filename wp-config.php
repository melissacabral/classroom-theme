<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mc_classroom_theme');

/** MySQL database username */
define('DB_USER', 'mc_classroom');

/** MySQL database password */
define('DB_PASSWORD', 'ByHwK6v8EnxpHhwU');

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
define('AUTH_KEY',         'ayhYy.Bem3u*AD8Gy-~0+)uB!L?5AL|e]OP|gJ{Z[g-o_8%ng*{+iG!a2A9P.4nj');
define('SECURE_AUTH_KEY',  '~,c1pyXp=y33d&=Po,L-a?o+MlgudCnS4d-AV*}%1.n/po6Etio9SxZBRQ!]c5j0');
define('LOGGED_IN_KEY',    'dRQGh0th4=v$fWrrRV>)&@JSMoTBA!+#*BP;ufecyxOm|D~.rx|s56t+-9tk=~:k');
define('NONCE_KEY',        '|ARE0s7&|gtXn5}%l0NG#Ov*=+|[)|OD@>$juKjyWLS_~k#O2PT_%_5@$|AKH<=f');
define('AUTH_SALT',        '{%i5.0.r?9+.#[[9`rz*pzm<bO#TB$(||=>kx w j(=0/xOYyaw;?:}W^O#)mM1)');
define('SECURE_AUTH_SALT', 'WskMljE/u8vo6]iH9s#u1gi{(HZUZbQxt1R62F#!UoC<kYW/j-VJ$nLFFqg^W_!-');
define('LOGGED_IN_SALT',   '](-$xApo/+n^jB:fJ>f-fS@&^zdrAp$^cU-!]fa[3;n,Pz]lhQ+[]OHBG_5.m SY');
define('NONCE_SALT',       's15M;Prj-znBd&`0WE]D-9t@ZT+Z4CutEatRZ1?x0i9^dJ/}3$/LlqGt*m^KZ~id');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
// $table_prefix  = 'class_';
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
