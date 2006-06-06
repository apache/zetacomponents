<?php

/**
 * ezcGraphColor 
 *
 * Struct for representing colors in ezcGraph. A color is defined using the
 * common RGBA model with integer values between 0 and 255. An alpha value 
 * of zero means full opacity, while 255 means full transparency.
 */
class ezcGraphColor
{
    /**
     * Red color value.
     *
     * Contains a value between 0 and 255
     * 
     * @var integer
     */
    public $red = 0;

    /**
     * Green color value.
     *
     * Contains a value between 0 and 255
     * 
     * @var integer
     */
    public $green = 0;

    /**
     * Blue color value.
     *
     * Contains a value between 0 and 255
     * 
     * @var integer
     */
    public $blue = 0;

    /**
     * Alpha color value.
     *
     * Contains a value between 0 and 255. 0 means full opacity and 255 full 
     * transparency.
     * 
     * @var integer
     */
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
                $color->$key = hexdec( $hexValue ) % 256;
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
                $color->$key = ( (int) $colorValue ) % 256;
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
                $color->$key = ( (float) $colorValue * 255 ) % 256;
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
        if ( $color instanceof ezcGraphColor )
        {
            return $color;
        }
        elseif ( is_string( $color ) )
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

    /**
     * Darkens the color
     * 
     * @param float $value Percent to darken the color
     * @return void
     */
    public function darken( $value )
    {
        $color = clone $this;

        $value = 1 - $value;
        $color->red *= $value;
        $color->green *= $value;
        $color->blue *= $value;

        return $color;
    }
}

?>
