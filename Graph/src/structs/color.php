<?php

class ezcGraphColor
{
    public $red = 0;

    public $green = 0;

    public $blue = 0;

    public $alpha = 0;
    
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

    /**
     * Creates an ezcGraphColor object from a hexadecimal color representation
     * 
     * @param mixed $string Hexadecimal color representation
     * @return ezcGraphColor
     */
    static public function fromHex( $string ) 
    {
    }

    /**
     * Creates an ezcGraphColor object from an array of integers
     * 
     * @param array $array Array of integer color values
     * @return ezcGraphColor
     */
    static public function fromIntegerArray( array $array )
    {
    }

    /**
     * Creates an ezcGraphColor object from an array of floats
     * 
     * @param array $array Array of float color values
     * @return ezcGraphColor
     */
    static public function fromFloatArray( array $array )
    {
    }

    /**
     * Tries to detect type of color color definition and returns an
     * ezcGraphColor object
     * 
     * @param mixed $color Some kind of color definition
     * @return ezcGraphColor
     */
    static public function create( $color )
    {
    }
}

?

?>
