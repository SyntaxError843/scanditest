<?php

/**
 * 
 * File to initialize database object
 * 
 */

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

/**
 * Initialize global database object
 */
$GLOBALS['db'] = new mysqli(

    DB_HOST,
    DB_USER,
    DB_PASSWORD,
    DB_NAME

);