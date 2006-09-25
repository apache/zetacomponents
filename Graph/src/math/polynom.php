<?php
/**
 * File containing the abstract ezcGraphPolynom class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Provides a class for generic operations on polynoms
 *
 * @package Graph
 * @access private
 */
class ezcGraphPolynom
{
    protected $values;

    /**
     * Constructor
     *
     * Constructs a polynom object from given array, where the key is the 
     * exponent and the value the factor.
     * An example:
     *  Polynom:
     *      2 * x^3 + .5 * x - 3
     *  Array:
     *      array (
     *          (int) 3 => (float) 2,
     *          (int) 1 => (float) .5,
     *          (int) 0 => (float) -3,
     *      )
     * 
     * @param array $values Array with values
     * @return ezcGraphPolynom
     */
    public function __construct( array $values = array() )
    {
        foreach ( $values as $exponent => $factor )
        {
            $this->values[(int) $exponent] = (float) $factor;
        }
    }

    /**
     * Initialise a polygon
     *
     * Initialise a polygon of the given order. Sets all factors to 0.
     * 
     * @param int $order Order of polygon
     * @return ezcGraphPolynom Created polynom
     */
    public function init( $order )
    {
        for ( $i = 0; $i <= $order; ++$i )
        {
            $this->values[$i] = 0;
        }

        return $this;
    }

    /**
     * Return factor for one exponent
     * 
     * @param int $exponent Exponent
     * @return float Factor
     */
    public function get( $exponent )
    {
        if ( !isset( $this->values[$exponent] ) )
        {
            return 0;
        }
        else
        {
            return $this->values[$exponent];
        }
    }

    /**
     * Set the factor for one exponent
     * 
     * @param int $exponent Exponent
     * @param float $factor Factor
     * @return ezcGraphPolynom Modified polynom
     */
    public function set( $exponent, $factor )
    {
        $this->values[(int) $exponent] = (float) $factor;

        return $this;
    }

    /**
     * Returns the order of the polynom
     * 
     * @return int Polynom order
     */
    public function getOrder()
    {
        return max( array_keys( $this->values ) );
    }

    /**
     * Adds polynom to current polynom
     * 
     * @param ezcGraphPolynom $polynom Polynom to add 
     * @return ezcGraphPolynom Modified polynom
     */
    public function add( ezcGraphPolynom $polynom )
    {
        $order = max(
            $this->getOrder(),
            $polynom->getOrder()
        );

        for ( $i = 0; $i <= $order; ++$i )
        {
            $this->set( $i, $this->get( $i ) + $polynom->get( $i ) );
        }

        return $this;
    }

    /**
     * Evaluate Polynom with a given value
     * 
     * @param float $x Value
     * @return float Result
     */
    public function evaluate( $x )
    {
        $value = 0;
        foreach ( $this->values as $exponent => $factor )
        {
            $value += $factor * pow( $x, $exponent );
        }

        return $value;
    }

    /**
     * Returns a string represenation of the polynom
     * 
     * @return string String representation of polynom
     */
    public function __toString()
    {
        krsort( $this->values );
        $string = '';

        foreach ( $this->values as $exponent => $factor )
        {
            if ( $factor == 0 )
            {
                continue;
            }
            elseif ( $factor != 1 )
            {
                $string .= sprintf( '%.2f * ', $factor );
            }

            $string .= ( $exponent > 1 ? sprintf( 'x^%d + ', $exponent ) : 
                        ( $exponent === 1 ? 'x + ' : '' ) 
                    );
        }

        return substr( $string, 0, -3 );
    }
}
?>
