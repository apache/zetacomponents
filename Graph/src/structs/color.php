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
    public function __set( $name, $key )
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
        // Remove trailing #
        if ( $string[0] === '#' )
        {
            $string = substr( $string, 1 );
        }
        
        // Iterate over chunks and convert to integer
        $color = new ezcGraphColor();
        $keys = array( 'red', 'green', 'blue', 'alpha' );
        foreach ( str_split( $string, 2) as $nr => $hexValue )
        {
            if ( isset( $keys[$nr] ) ) 
            {
                $key = $keys[$nr];
                $color->$key = hexdec( $hexValue ) % 255;
            }
        }
        
        // Set missing values to zero
        for ( ++$nr; $nr < count( $keys ); ++$nr )
        {
            $key = $keys[$nr];
            $color->$key = 0;
        }

        return $color;
    }

    /**
     * Creates an ezcGraphColor object from an array of integers
     * 
     * @param array $array Array of integer color values
     * @return ezcGraphColor
     */
    static public function fromIntegerArray( array $array )
    {
        // Iterate over array elements
        $color = new ezcGraphColor();
        $keys = array( 'red', 'green', 'blue', 'alpha' );
        $nr = 0;
        foreach ( $array as $colorValue )
        {
            if ( isset( $keys[$nr] ) ) 
            {
                $key = $keys[$nr++];
                $color->$key = ( (int) $colorValue ) % 255;
            }
        }
        
        // Set missing values to zero
        for ( ++$nr; $nr < count( $keys ); ++$nr )
        {
            $key = $keys[$nr];
            $color->$key = 0;
        }

        return $color;
    }

    /**
     * Creates an ezcGraphColor object from an array of floats
     * 
     * @param array $array Array of float color values
     * @return ezcGraphColor
     */
    static public function fromFloatArray( array $array )
    {
        // Iterate over array elements
        $color = new ezcGraphColor();
        $keys = array( 'red', 'green', 'blue', 'alpha' );
        $nr = 0;
        foreach ( $array as $colorValue )
        {
            if ( isset( $keys[$nr] ) ) 
            {
                $key = $keys[$nr++];
                $color->$key = ( (float) $colorValue * 255 ) % 255;
            }
        }
        
        // Set missing values to zero
        for ( ++$nr; $nr < count( $keys ); ++$nr )
        {
            $key = $keys[$nr];
            $color->$key = 0;
        }

        return $color;
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
        if ( is_string( $color ) )
        {
            return ezcGraphColor::fromHex( $color );
        }
        elseif ( is_array( $color ) )
        {
            $testElement = reset( $color );
            if ( is_int( $testElement ) )
            {
                return ezcGraphColor::fromIntegerArray( $color );
            } 
            else 
            {
                return ezcGraphColor::fromFloatArray( $color );
            }
        }
        else
        {
            throw new ezcGraphUnknownColorDefinitionException( $color );
        }
    }
}

?>
