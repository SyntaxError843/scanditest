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

class ProductAttributes {

    /**
     * Datatable name
     * 
     * @var string
     */
    protected const DATATABLE_NAME = 'product_attributes';

    /**
     * Attribute ID
     * 
     * @var int
     */
    protected $id;

    /**
     * Attribute name
     * 
     * @var string
     */
    protected $name;

    /**
     * Attribute value
     * 
     * @var string
     */
    protected $value;

    /**
     * Constructor to fetch product attribute from database by id or leave empty template
     * 
     * @param   int     $attribute_id     Required, id of attribute in the database.
     */
    public function __construct( $attribute_id = 0 ) {

        if ( $attribute_id != 0 ) {

            $this->set_id( absint( $attribute_id ) );
            $this->load();

        }

    }

    /**
     * Function to load product attribute from database and assign to object
     * 
     * @param array     $attribute    Optional, attribute associative array to map to object.
     */
    public function load( $attribute = '' ) {

        /**
         * Fetch attribute record from database
         */
        $record = ( ! empty( $attribute ) ? $attribute : $this->fetch()->fetch_all( MYSQLI_ASSOC )[0] );

        /**
         * Assign values to object
         */
        $this->set_id( $record['id'] );
        $this->set_name( $record['name'] );
        $this->set_value( $record['value'] );

    }

    /**
     * Function to fetch product attribute record from database
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
     * Function to save product attribute to database
     */
    public function save() {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;
        $name           = $this->get_name();
        $value          = $this->get_value();

        /**
         * Check if product attribute already exists in database
         */
        if ( ! empty( $this->get_id() ) && $this->get_id() !== 0 ) {

            /**
             * If product attribute exists then update it
             */
            $sql = $db->prepare( "UPDATE $datatable_name SET name=?, value=? WHERE id={$this->get_id()}" );

            $sql->bind_param( 'ss', $name, $value );

            $sql->execute();

        } else {

            /**
             * Otherwise insert new product attribute
             */
            $sql = $db->prepare( "INSERT INTO $datatable_name ( name, value ) VALUES( ?, ? )" );

            $sql->bind_param( 'ss', $name, $value );

            $sql->execute();

            /**
             * Get the latest id
             */
            $this->set_id( $sql->insert_id );

        }

    }

    /**
     * Function to delete product attribute in database
     */
    public function delete() {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;

        /**
         * Check if product attribute already exists in database
         */
        if ( ! empty( $this->get_id() ) && $this->get_id() !== 0 ) {

            /**
             * If product attribute exists then delete it
             */
            $sql = $db->prepare( "DELETE FROM $datatable_name WHERE id={$this->get_id()}" );

            $sql->execute();

            /**
             * Clear object
             */
            $this->set_id( NULL );
            $this->set_name( NULL );
            $this->set_value( NULL );

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
     * Getter for value
     */
    public function get_value() {

        return $this->value;

    }

    /**
     * Setter for value
     * 
     * @param int $value
     */
    public function set_value( $value ) {

        $this->value = $value;

    }

    /**
     * Method to create database table if it doesn't already exist
     * 
     * @uses $db
     */
    public function maybe_create_datatable() {

        global $db;

        $datatable_name = $this::DATATABLE_NAME;

        if ( ! datatable_exists( $datatable_name ) ) {

            $query = "CREATE TABLE {$datatable_name} (

                id      mediumint(9)    NOT NULL    AUTO_INCREMENT,
                name    varchar(255)    NOT NULL,
                value   varchar(255)    NOT NULL,

                PRIMARY KEY (id)

            )";

            if ( $db->query( $query ) === false ) throw new ErrorException( "Failed to create {$datatable_name} datatable, `$query`." );

        }

    }

}

/**
 * Attempt to create datatable on load
 */
(new ProductAttributes())->maybe_create_datatable();