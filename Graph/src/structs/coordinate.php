<?php

class ezcGraphCoordinate
{
    public $x = 0;

    public $y = 0;
    
    /**
     * Empty constructor
     */
    public function __construct( $x, $y )
    {
        $this->x = $x;
        $this->y = $y;
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
