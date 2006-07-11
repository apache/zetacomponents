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
    public function __construct( $x0 = 0, $y0 = 0, $x1 = false, $y1 = false )
    {
        $this->x0 = $x0;
        $this->y0 = $y0;
        $this->x1 = $x1;
        $this->y1 = $y1;
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
