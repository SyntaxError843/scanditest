<?php

/**
 * Main router class
 */

namespace Vendor\Router;

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

class Router {

    /**
     * Function to map template files to routes
     * 
     * @param string  $route        Required, The route.
     * @param string  $callback     Required, The callback to run.
     * 
     */
    public function route( $route, $callback ) {

        if ( $route === '/404' ) {

            call_user_func( $callback );

        }

        $request_url = filter_var( $_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL );

        // $request_url = rtrim( $request_url, ( basename( ABSPATH ) . '/' ) );

        $request_url = trim( $request_url, '/' );

        $request_url = strtok( $request_url, '?' );

        $route_parts = explode( '/', $route );

        $request_url_parts = explode( '/', $request_url );

        array_shift( $route_parts );

        array_shift( $request_url_parts );

        if( $route_parts[0] === '' && count( $request_url_parts ) === 0 ) {

            call_user_func( $callback );

        }

        if ( count( $route_parts ) !== count( $request_url_parts ) ) return;

        $parameters = [];

        for( $__i__ = 0; $__i__ < count( $route_parts ); $__i__++ ) {

            $route_part = $route_parts[ $__i__ ];

            if( preg_match( "/^[$]/", $route_part ) ) {

                $route_part = ltrim( $route_part, '$' );

                array_push( $parameters, $request_url_parts[ $__i__ ] );

                $$route_part = $request_url_parts[ $__i__ ];

            } else if ( $route_parts[ $__i__ ] !== $request_url_parts[ $__i__ ] ) return;

        }

        call_user_func( $callback );

    }

    public function get( $route, $callback ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) $this->route( $route, $callback );

    }

    public function post( $route, $callback ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) $this->route( $route, $callback );

    }

    public function put( $route, $callback ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'PUT' ) $this->route( $route, $callback );

    }

    public function patch( $route, $callback ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'PATCH' ) $this->route( $route, $callback );

    }

    public function delete( $route, $callback ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'DELETE' ) $this->route( $route, $callback );

    }

    public function any( $route, $callback ) { $this->route($route, $callback); }

}