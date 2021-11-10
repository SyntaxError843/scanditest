<?php

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

use Vendor\Router\Router;

$router = new Router();

/**
 * Home page route
 * 
 * @method GET
 */
$router->get( PROXY.'/', array( '\Controllers\Home\HomeController', 'index' ) );

/**
 * Product add page
 * 
 * @method GET
 */
$router->get( PROXY.'/add-product', array( '\Controllers\Product\ProductController', 'index' ) );

/**
 * Product add page
 * 
 * @method POST
 */
$router->post( PROXY.'/add-product', array( '\Controllers\Product\ProductController', 'save' ) );

/**
 * Product delete page
 * 
 * @method POST
 */
$router->post( PROXY.'/delete-product', array( '\Controllers\Product\ProductController', 'delete' ) );
