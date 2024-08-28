<?php





//Begin Really Simple SSL session cookie settings

@ini_set('session.cookie_httponly', true);

@ini_set('session.cookie_secure', true);

@ini_set('session.use_only_cookies', true);

//END Really Simple SSL cookie settings



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

 * @link https://wordpress.org/documentation/article/editing-wp-config-php/

 *

 * @package WordPress

 */



// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'qZ5ZX8EspHkT' );



/** Database username */

define( 'DB_USER', 'qZ5ZX8EspHkT' );



/** Database password */

define( 'DB_PASSWORD', 'K.eVKvEgVpJScZHj29Z14' );



/** Database hostname */

define( 'DB_HOST', '127.0.0.1' );



/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );



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

define('AUTH_KEY',         'JKvQWXYcgroyn0wBL276g0LoVYKBI5MPeLMpMbQvB6bXR3hbbOOY1OCdASOptHSF');

define('SECURE_AUTH_KEY',  'l7vzN8LR2HPfdWAxSq5r2QD2BerEHVUTOT121uxg4nZj9Huccch1wtpNo89YTSsS');

define('LOGGED_IN_KEY',    'ewyQ4qy5p6QNbXPj3otiRDTrXGJ5FcWMku0p4Tr7yPgsryl8bU2S8w42LgYp8nAM');

define('NONCE_KEY',        'kYvZl9WMtPGwWm3fISn9jmbWOmc2U5rYEblSgDzSAQa4IfQFNnlWNlydKxYRGYMg');

define('AUTH_SALT',        'dfOoezFrAUrx714SOSrXXpbPnBQtNyqkW0DICo8oKCXVxQksT0ZHZ6gZwKIG012r');

define('SECURE_AUTH_SALT', 'PLA5l1TPHbGkgK0QAFm7Nf3V8SI5Jp129hweUntwchTRiWB1zzVZPivBDMTcV2h1');

define('LOGGED_IN_SALT',   'cnVPc11LOLF58qLyNzYG3DgpJeWx0qgUDmdsm2PDDaJXi8yLuvQfotXJEzFEGaHg');

define('NONCE_SALT',       'rLDPrfLZFksipUOlXr3QmmbQDfUK7aSEkYI8FEfX6hrlS4RRkSKqDCBRO0DZDfDi');



/**

 * Other customizations.

 */

define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');





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

 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );

define( 'WP_DEBUG_DISPLAY', true );



/* Add any custom values between this line and the "stop editing" line. */







define( 'WP_REDIS_DATABASE', '4' );
define( 'DISABLE_WP_CRON', true );
/* That's all, stop editing! Happy publishing. */

/* Oodles Crm API*/
define( 'OODLES_API_BASEURL', 'https://portal.oodleswok.ae/' );
define( 'OODLES_CLIENT_ID', 3 );
define( 'OODLES_CLIENT_SECRET', 'vXIuT5Jbjwl7Cs8yd8LVyKzfzISL2IhiebF1dAme' );

/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

