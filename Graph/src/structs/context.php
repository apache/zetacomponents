<?php
/**
 * File containing the ezcGraphContext struct
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct to represent the context of a renderer operation
 *
 * @package Graph
 */
class ezcGraphContext
{
    /**
     * Name of dataset
     * 
     * @var string
     */
    public $dataset = false;

    /**
     * Name of datapoint 
     * 
     * @var string
     */
    public $datapoint = false;
    
    /**
     * Simple constructor 
     * 
     * @param string $dataset Name of dataset
     * @param string $datapoint Name of datapoint
     * @return void
     * @ignore
     */
    public function __construct( $dataset = false, $datapoint = false )
    {
        $this->dataset = $dataset;
        $this->datapoint = $datapoint;
    }

    /**
     * Throws a BasePropertyNotFound exception.
     *
     * @ignore
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Throws a BasePropertyNotFound exception.
     *
     * @ignore
     */
    public function __get( $name )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * __set_state 
     * 
     * @param array $properties Struct properties
     * @return void
     * @ignore
     */
    public function __set_state( array $properties )
    {
        $this->dataset = (string) $properties['dataset'];
        $this->datapoint = (string) $properties['datapoint'];
    }
}

?>
