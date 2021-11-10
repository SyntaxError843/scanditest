<?php

/**
 * Product controller class
 */

namespace Controllers\Product;

use Models\Product\ProductAttributes;
use Models\Product\Product;

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

class ProductController {

    public static function index() {

        require_once ABSPATH . 'views/add-product.php';

    }

    public static function save() {

        /**
         * Validate csrf token
         */
        // if ( is_csrf_valid() ) {

            /**
             * Extract product info from post array
             */
            $product_sku = (string) filter_input( INPUT_POST, 'sku' );
            $product_name = (string) filter_input( INPUT_POST, 'name' );
            $product_price = ( absint( filter_input( INPUT_POST, 'price' ) ) )*100;
            $product_type = (string) filter_input( INPUT_POST, 'product_type' );
            $product_attribute = new ProductAttributes();

            switch ($product_type) {

                case 'DVD':
                    
                    $product_attribute->set_name( 'Size' );
                    $product_attribute->set_value( sprintf( '%1$s MB', filter_input( INPUT_POST, 'size' ) ) );
                    break;

                case 'Furniture':
                    
                    $product_attribute->set_name( 'Dimension' );
                    $product_attribute->set_value( sprintf(

                        '%1$sx%2$sx%3$s',
                        filter_input( INPUT_POST, 'height' ),
                        filter_input( INPUT_POST, 'width' ),
                        filter_input( INPUT_POST, 'length' )

                    ) );
                    break;

                case 'Book':
                    
                    $product_attribute->set_name( 'Weight' );
                    $product_attribute->set_value( sprintf( '%1$sKG', filter_input( INPUT_POST, 'weight' ) ) );
                    break;
                
                default:
                    
                    $product_attribute->set_name( 'unknown' );
                    $product_attribute->set_value( 'n/a' );
                    break;
            }

            /**
             * Construct new product object
             */
            $product = new Product();

            $product->set_sku( $product_sku );
            $product->set_name( $product_name );
            $product->set_price( $product_price );
            $product->set_type( $product_type );
            $product->set_attributes( $product_attribute );

            $product->save();

        // }

        header( 'Location: /'.PROXY );

    }

    public static function delete() {

        /**
         * Validate csrf token
         */
        // if ( is_csrf_valid() ) {

            /**
             * Check if there are any products to delete
             */
            if ( ! empty( $_POST['products_to_delete'] ) ) {
    
                foreach ( $_POST['products_to_delete'] as $product_id => $text ) {
    
                    $product = new Product( $product_id );
    
                    $product->delete();
    
                }
    
            }

        // }

        header( 'Location: /'.PROXY );

    }

}