<?php

class ezcGraphContext
{
    public $dataset = false;

    public $datapoint = false;
    
    /**
     * Empty constructor
     */
    public function __construct( $dataset = false, $datapoint = false )
    {
        $this->dataset = $dataset;
        $this->datapoint = $datapoint;
    }

    /**
     * Throws a BasePropertyNotFound exception.
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Throws a BasePropertyNotFound exception.
     */
    public function __get( $name )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }
}

?>
