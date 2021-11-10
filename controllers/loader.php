<?php

/**
 * 
 * File to load scripts
 * 
 */

foreach ( array(

    'class-controller-home.php',
    'class-controller-product.php',

) as $file ) require_once __DIR__ . '/' . $file;