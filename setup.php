<?php

/**
 * 
 * File to load setup scripts
 * 
 */

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

/**
 * Check if debug mode is enabled
 */
if ( DEBUG === TRUE ) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}

/**
 * Initialize database object
 */
require_once ABSPATH . 'includes/db.php';

/**
 * Require helper functions
 */
require_once ABSPATH . 'includes/functions.php';

/**
 * Require libraries
 */
require_once ABSPATH . 'libs/loader.php';

/**
 * Require models
 */
require_once ABSPATH . 'models/loader.php';

/**
 * Require controllers
 */
require_once ABSPATH . 'controllers/loader.php';

/**
 * Require the router
 */
require_once ABSPATH . 'router.php';