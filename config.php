<?php

/**
 * 
 * Basic configuration file
 * 
 */

/**
 * Absolute path for root directory
 */
if ( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . '/' );

// ** MySQL settings ** //
/** The name of the database */
define( 'DB_NAME', 'scanditest' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'toor' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/**
 * Proxy
 */
define( 'PROXY', '' );

/**
 * Debug mode
 */
define( 'DEBUG', true );

/**
 * Load setup
 */
require_once ABSPATH . 'setup.php';
