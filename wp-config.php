<?php
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
$local_hosts = ['localhost', '127.0.0.1', '::1'];
$is_local = in_array($host, $local_hosts) || strpos($host, '.local') !== false;

if ($is_local) {
    $_SERVER['REMOTE_ADDR'] = '193.188.106.24';
    define( 'WP_HOME', 'http://localhost' );
    define( 'WP_SITEURL', 'http://localhost' );
    define('DB_NAME', 'dbmaster');
    define('DB_USER', 'dbmasteruser');
    define('DB_PASSWORD', '9j+:a~+*8)ChnG0V3k~#s?5TiH9:M%GC');
    define('DB_HOST', 'ls-6966b38bee91e6175b5c26a090c0fcdb5230a22d.c5ema0cewprd.eu-central-1.rds.amazonaws.com');
    define('WP_DEBUG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SCRIPT_DEBUG', true);
} else {
    define( 'WP_HOME', 'https://shahid.mbc-vip.net' );
    define( 'WP_SITEURL', 'https://shahid.mbc-vip.net' );

    define('DB_NAME', 'mbcv_shahed');
    define('DB_USER', 'mbcv_shahed_user');
    define('DB_PASSWORD', 'srv^5GjaAv5HMkcl');
    define('DB_HOST', 'localhost');
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
}



define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');


define( 'AUTH_KEY',         'G#@vLL6,K5~oO5b=Q[+yG.b/CFM8@x_h~}ieR$u6p_h2+,e0.`t~t.c39rc44 h1' );
define( 'SECURE_AUTH_KEY',  ',W0zX|ltfx~7V2KzOn2$^wM`-w$*?bEOoH6$#q`i ;p~8Xl-5 A)J;y5wCcbG)lq' );
define( 'LOGGED_IN_KEY',    'IrplL9|Un0-UyG1p#e}bjH:[F[VyE1 S(Kga<h>&#tnz9N**T_Y}5UJ3X*UU_Ig&' );
define( 'NONCE_KEY',        '.T0CdQTA6sEhItdyOA0f;]a8@6C|L{@I8i&|-ZKb &~Sfyc8|J^VH/wZHQpO4<Ul' );
define( 'AUTH_SALT',        '*$N*VsJ9~Z2&SIj!mDO2T}Bli.(&06efN,|I>3TjqB|#uZ}#|(y&xq-pft,fP`Q,' );
define( 'SECURE_AUTH_SALT', 't$+n?Y%~?kNss=tW] +A!_Ne>m(f3T4i ZD3=_lP0Ta^&|FPbhMyyNK<DblyKF?o' );
define( 'LOGGED_IN_SALT',   '+KIQhKs1v`//@/6)1j$CZyd.cpCeUW?K jZ&%,Xq@AA8NH;6PG~]lI$XmaKoBFVF' );
define( 'NONCE_SALT',       'ULmPtmJ;(diZ*@&<saY97P:umZ%bd]>aDt(`0IhWf,6>UV,~[Km5W1j71I:T7AoG' );

$table_prefix = 'wp_';

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}


require_once ABSPATH . 'wp-settings.php';
