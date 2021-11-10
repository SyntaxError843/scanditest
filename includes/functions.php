<?php

/**
 * 
 * Helper functions
 * 
 */

use Models\Product\Product;

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

if ( ! function_exists( 'dd' ) ) {

    /**
     * Function to dump&die
     * 
     * @param   mixed   $variable       Required, variable to dump before dying.
     */
    function dd( $variable ) {

        die( var_dump( $variable ) );

    }

}

if ( ! function_exists( 'datatable_exists' ) ) {

    /**
     * Function to check if a given datatable exists in the database
     * 
     * @param   string   $datatable_name       Required, name of datatable.
     * 
     * @return  bool    True if datatable was found in the database, false otherwise.
     * 
     * @uses $db
     */
    function datatable_exists( $datatable_name ) {

        global $db;

        return $db->query( sprintf(

            'SELECT count(*)
            FROM information_schema.TABLES
            WHERE (TABLE_SCHEMA = "%1$s") AND (TABLE_NAME = "%2$s")',
            DB_NAME,
            $datatable_name

        ) )->fetch_array( MYSQLI_NUM )[0] > 0;

    }

}

if ( ! function_exists( 'absint' ) ) {

    /**
     * Function to return absolute int of value
     * 
     * @param   mixed   $variable       Required, variable to parse.
     */
    function absint( $variable ) {

        return abs( (int) $variable );

    }

}

if ( ! function_exists( 'format_money' ) ) {

    /**
     * Function to format money with 2 decimal points
     * 
     * @param   int   $money       Required, money to format.
     */
    function format_money( $money ) {

        return number_format( $money, 2 );

    }

}

if ( ! function_exists( 'esc_html' ) ) {

    /**
     * Function to escape html
     * 
     * @param   string   $text       Required, text to escape.
     */
    function esc_html( $text ) {

        return htmlspecialchars( $text );

    }

}

if ( ! function_exists( 'esc_html_e' ) ) {

    /**
     * Function to escape html and echo
     * 
     * @param   string   $text       Required, text to escape and echo.
     */
    function esc_html_e( $text ) {

        echo esc_html( $text );

    }

}

if ( ! function_exists( 'set_csrf' ) ) {

    /**
     * Function to generate, store and output a csrf token
     */
    function set_csrf() {

        $csrf_token = bin2hex( random_bytes( 25 ) );
        $_SESSION['csrf'] = $csrf_token;
        echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';

    }

}

if ( ! function_exists( 'is_csrf_valid' ) ) {

    /**
     * Function to validate csrf token in post array
     */
    function is_csrf_valid() {

        if ( ! isset( $_SESSION['csrf'] ) || ! isset( $_POST['csrf'] ) ) return false;
        if ( $_SESSION['csrf'] !== $_POST['csrf'] ) return false;
        return true;

    }

}

if ( ! function_exists( 'get_products' ) ) {

    /**
     * Function to return array of products as objects
     * 
     * @param   array   $args   Optional, query args.
     */
    function get_products( $args = array() ) {

        global $db;

        $datatable_name = Product::DATATABLE_NAME;

        /**
         * Fetch products
         */
        $sql = $db->prepare( "SELECT * FROM $datatable_name" );

        $sql->execute();

        $products = $sql->get_result()->fetch_all( MYSQLI_ASSOC );

        /**
         * Initialize empty products objects list
         */
        $products_objects = [];

        foreach ( $products as $product ) {

            $products_objects[] = new Product( $product );

        }

        return $products_objects;

    }

}
