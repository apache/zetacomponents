<?php

class ezcGraphBoundings
{
    public $x0 = 0;

    public $y0 = 0;
    
    public $x1 = false;

    public $y1 = false;
    
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

?>
