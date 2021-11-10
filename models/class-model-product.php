<?php

/**
 * Home page controller class
 */

namespace Models\Product;

use ErrorException;

/**
 * Exit if accessed directly
 */
! defined( 'ABSPATH' ) && exit();

class Product {

    /**
     * Datatable name
     * 
     * @var string
     */
    public const DATATABLE_NAME = 'products';

    /**
     * Child datatable name
     * 
     * @var string
     */
    protected const CHILD_DATATABLE_NAME = 'product_attributes';

    /**
     * Foreign key
     * 
     * @var string
     */
    protected const FOREIGN_KEY = 'attribute_id';

    /**
     * Product ID
     * 
     * @var int
     */
    protected $id;

    /**
     * Product Type
     * 
     * @var string
     */
    protected $type;

    /**
     * Product SKU
     * 
     * @var string
     */
    protected $sku;

    /**
     * Product name
     * 
     * @var string
     */
    protected $name;

    /**
     * Product price
     * 
     * N.B price is converted to cents when stored in the database
     * 
     * @var int
     */
    protected $price;

    /**
     * Product attributes
     * 
     * @var ProductAttributes
     */
    protected $attributes;

    /**
     * Constructor to fetch product from database by id or leave empty template
     * 
     * @param   int|array     $product     Required, id of product in the database, can also be assoc array to map to object.
     */
    public function __construct( $product = 0 ) {

        $this->attributes = new ProductAttributes();
        
        if ( $product != 0 ) {

            if ( is_array( $product ) ) {

                $this->load( $product );

            } else {

                $this->set_id( absint( $product ) );
                $this->load();

            }


        }

    }

    /**
     * Function to load product from database and assign to object
     * 
     * @param array     $product    Optional, product associative array to map to object.
     */
    public function load( $product = '' ) {

        /**
         * Fetch product record from database
         */
        $record = ( ! empty( $product ) ? $product : $this->fetch()->fetch_all( MYSQLI_ASSOC )[0] );

        /**
         * Assign values to object
         */
        $this->set_id( $record['id'] );
        $this->set_type( $record['type'] );
        $this->set_sku( $record['sku'] );
        $this->set_name( $record['name'] );
        $this->set_price( $record['price'] );
        $this->set_attributes( new ProductAttributes( $record[ $this::FOREIGN_KEY ] ) );

    }

    /**
     * Function to fetch product record from database
     * 
     * @param   string  $sql    Optional, the sql query.
     * 
     * @return object    mysqli_result.
     */
    public function fetch( $sql = '' ) {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;

        if ( empty( $sql ) ) {

            $sql = "SELECT * FROM {$datatable_name} WHERE id = {$this->get_id()}";

        }

        $sql = $db->prepare( $sql );

        $sql->execute();

        return $sql->get_result();

    }

    /**
     * Function to save product to database
     */
    public function save() {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;
        $foreign_key    = $this::FOREIGN_KEY;
        $sku            = $this->get_sku();
        $name           = $this->get_name();
        $price          = $this->get_price();
        $type           = $this->get_type();

        $this->attributes->save();

        /**
         * Check if product already exists in database
         */
        if ( ! empty( $this->get_id() ) && $this->get_id() !== 0 ) {

            /**
             * If product exists then update it
             */
            $sql = $db->prepare( "UPDATE $datatable_name SET sku=?, name=?, price=?, type=? WHERE id={$this->get_id()}" );

            $sql->bind_param( 'ssss', $sku, $name, $price, $type );

            $sql->execute();

        } else {

            $attribute_id = $this->attributes->get_id();

            /**
             * Otherwise insert new product
             */
            $sql = $db->prepare( "INSERT INTO $datatable_name ( sku, name, price, type, $foreign_key ) VALUES( ?, ?, ?, ?, ? )" );

            $sql->bind_param( 'sssss', $sku, $name, $price, $type, $attribute_id );

            $sql->execute();

            /**
             * Get the latest id
             */
            $this->set_id( $sql->insert_id );

        }

    }

    /**
     * Function to delete product in database
     */
    public function delete() {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;

        $this->attributes->delete();

        /**
         * Check if product already exists in database
         */
        if ( ! empty( $this->get_id() ) && $this->get_id() !== 0 ) {

            /**
             * If product exists then delete it
             */
            $sql = $db->prepare( "DELETE FROM $datatable_name WHERE id={$this->get_id()}" );

            $sql->execute();

            /**
             * Clear object
             */
            $this->set_id( NULL );
            $this->set_sku( NULL );
            $this->set_name( NULL );
            $this->set_type( NULL );
            $this->set_price( NULL );
            $this->set_attributes( new ProductAttributes() );

        }

    }

    /**
     * Getter for id
     */
    public function get_id() {

        return $this->id;

    }

    /**
     * Setter for id
     * 
     * @param int $id
     */
    public function set_id( $id ) {

        $this->id = $id;

    }

    /**
     * Getter for type
     */
    public function get_type() {

        return $this->type;

    }

    /**
     * Setter for type
     * 
     * @param string $type
     */
    public function set_type( $type ) {

        $this->type = $type;

    }

    /**
     * Getter for sku
     */
    public function get_sku() {

        return $this->sku;

    }

    /**
     * Setter for sku
     * 
     * @param string $sku
     */
    public function set_sku( $sku ) {

        $this->sku = $sku;

    }

    /**
     * Getter for name
     */
    public function get_name() {

        return $this->name;

    }

    /**
     * Setter for name
     * 
     * @param string $name
     */
    public function set_name( $name ) {

        $this->name = $name;

    }

    /**
     * Getter for price
     */
    public function get_price() {

        return $this->price;

    }

    /**
     * Getter for display price
     */
    public function get_display_price() {

        return sprintf( '%1$s $', format_money( $this->price/100 ) );

    }

    /**
     * Setter for price
     * 
     * @param int $price
     */
    public function set_price( $price ) {

        $this->price = $price;

    }

    /**
     * Getter for attributes
     */
    public function get_attributes() {

        return $this->attributes;

    }

    /**
     * Setter for attributes
     * 
     * @param ProductAttributes $attributes
     */
    public function set_attributes( $attributes ) {

        $this->attributes = $attributes;

    }

    /**
     * Method to create database table if it doesn't already exist
     * 
     * @uses $db
     */
    public function maybe_create_datatable() {

        global $db;

        $datatable_name         = $this::DATATABLE_NAME;
        $foreign_key            = $this::FOREIGN_KEY;
        $child_datatable_name   = $this::CHILD_DATATABLE_NAME;

        if ( ! datatable_exists( $datatable_name ) ) {

            $query = "CREATE TABLE {$datatable_name} (

                id                      mediumint(9)            NOT NULL    AUTO_INCREMENT,
                type                    varchar(255)            NOT NULL,
                sku                     varchar(255)            NOT NULL,
                name                    varchar(255)            NOT NULL,
                price                   mediumint   UNSIGNED    NOT NULL,
                {$foreign_key}          mediumint(9)            NOT NULL,

                PRIMARY KEY (id),

                FOREIGN KEY ({$foreign_key}) REFERENCES {$child_datatable_name} (id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE,

                CONSTRAINT PRICE_POSITIVE CHECK( price >= 0 ),
                CONSTRAINT SKU_UNIQUE UNIQUE( sku )

            )";

            if ( $db->query( $query ) === false ) throw new ErrorException( "Failed to create {$datatable_name} datatable, `$query`." );

        }

    }

}

/**
 * Attempt to create datatable on load
 */
(new Product())->maybe_create_datatable();