<?php
error_reporting(E_ALL);

// System
define( 'DS', DIRECTORY_SEPARATOR );
define( 'EXT', '.php' );

// Paths
define( 'SYS_PATH', dirname(__FILE__) . '/system/' );
define( 'APP_PATH', dirname(__FILE__) . '/application/' );
define( 'SITE_URL', 'http://localhost/' );

// Database
define( 'DB_TYPE', 'mysql' );
define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'test' );
define( 'DB_USER', 'test' );
define( 'DB_PASS', 'k0k0fj0ng' );

// Site
define( 'CHARSET', 'utf8' );

// Extra
define( 'TOKEN_TIMEOUT', 120 );
define( 'DEVELOPMENT', true );
