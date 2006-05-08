<?php

class ezcGraphChartOption
{
    public $width = false;

    public $height = false;
    
    /**
     * Empty constructor
     */
    public function __construct()
    {
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

?

?>
