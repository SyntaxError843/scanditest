<?php

/**
 * Home page controller class
 */

namespace Controllers\Home;

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

class HomeController {

    public static function index() {

        /**
         * Get a list of latest products
         */
        $products = get_products();

        require_once ABSPATH . 'views/home.php';

    }

}