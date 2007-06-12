<?php
/**
 * File containing the ezcGraphContext struct
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct to represent the context of a renderer operation
 *
 * @version //autogentag//
 * @package Graph
 */
class ezcGraphContext extends ezcBaseStruct
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
     * Associated URL for datapoint
     * 
     * @var string
     */
    public $url;

    /**
     * Simple constructor 
     * 
     * @param string $dataset
     * @param string $datapoint
     * @param string $url
     * @return void
     * @ignore
     */
    public function __construct( $dataset = null, $datapoint = null, $url = null )
    {
        $this->dataset = $dataset;
        $this->datapoint = $datapoint;
        $this->url = $url;
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

        // Check to keep BC
        // @TODO: Remvove unnesecary check on next major version
        if ( array_key_exists( 'url', $properties ) )
        {
            $this->url = (string) $properties['url'];
        }
    }
}

?>
