<?php
/**
 * File containing the ezcGraphChartElementLogarithmicalAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a numeric axis. The axis tries to calculate "nice" start
 * and end values for the axis scale. The used interval is considered as nice, 
 * if it is equal to [1,2,5] * 10^x with x in [.., -1, 0, 1, ..].
 *
 * The start and end value are the next bigger / smaller multiple of the 
 * intervall compared to the maximum / minimum axis value.
 *
 * @property float $min
 *           Minimum value of displayed scale on axis.
 * @property float $max
 *           Maximum value of displayed scale on axis.
 * @property float $base
 *           Base for logarithmical scaling.
 * @property string $logarithmicalFormatString
 *           Sprintf formatstring for the axis labels where
 *              $1 is the base and
 *              $2 is the exponent.
 * @property-read float $minValue
 *                Minimum Value to display on this axis.
 * @property-read float $maxValue
 *                Maximum value to display on this axis.
 *           
 * @package Graph
 * @mainclass
 */
class ezcGraphChartElementLogarithmicalAxis extends ezcGraphChartElementAxis
{

    /**
     * Constant used for calculation of automatic definition of major scaling 
     * steps
     */
    const MAX_STEPS = 9;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['min'] = null;
        $this->properties['max'] = null;
        $this->properties['base'] = 10;
        $this->properties['logarithmicalFormatString'] = '%1$d^%2$d';
        $this->properties['minValue'] = null;
        $this->properties['maxValue'] = null;

        parent::__construct( $options );
    }

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'min':
            case 'max':
                if ( !is_numeric( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;
            case 'base':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 0' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;
            case 'logarithmicalFormatString':
                $this->properties['logarithmicalFormatString'] = (string) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }
    
    /**
     * Add data for this axis
     * 
     * @param mixed $value Value which will be displayed on this axis
     * @return void
     */
    public function addData( array $values )
    {
        foreach ( $values as $value )
        {
            if ( $this->properties['minValue'] === null ||
                 $value < $this->properties['minValue'] )
            {
                $this->properties['minValue'] = $value;
            }

            if ( $this->properties['maxValue'] === null ||
                 $value > $this->properties['maxValue'] )
            {
                $this->properties['maxValue'] = $value;
            }
        }
    }

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @abstract
     * @access public
     * @return void
     */
    public function calculateAxisBoundings()
    {
        // Prevent division by zero, when min == max
        if ( $this->properties['minValue'] == $this->properties['maxValue'] )
        {
            if ( $this->properties['minValue'] == 0 )
            {
                $this->properties['maxValue'] = 1;
            }
            else
            {
                $this->properties['minValue'] -= ( $this->properties['minValue'] * .1 );
                $this->properties['maxValue'] += ( $this->properties['maxValue'] * .1 );
            }
        }

        if ( $this->properties['minValue'] <= 0 )
        {
            throw new ezcGraphOutOfLogithmicalBoundingsException( $this->properties['minValue'] );
        }

        // Use custom minimum and maximum if available
        if ( $this->properties['min'] !== null )
        {
            $this->properties['minValue'] = pow( $this->properties['base'], $this->properties['min'] );
        }

        if ( $this->properties['max'] !== null )
        {
            $this->properties['maxValue'] = pow( $this->properties['base'], $this->properties['max'] );
        }

        // Calculate "nice" values for scaling parameters
        if ( $this->properties['min'] === null )
        {
            $this->properties['min'] = floor( log( $this->properties['minValue'], $this->properties['base'] ) );
        }

        if ( $this->properties['max'] === null )
        {
            $this->properties['max'] = ceil( log( $this->properties['maxValue'], $this->properties['base'] ) );
        }

        $this->properties['minorStep'] = 1;
        if ( ( $modifier = ( ( $this->properties['max'] - $this->properties['min'] ) / self::MAX_STEPS ) ) > 1 )
        {
            $this->properties['majorStep'] = $modifier = ceil( $modifier );
            $this->properties['min'] = floor( $this->properties['min'] / $modifier ) * $modifier;
            $this->properties['max'] = floor( $this->properties['max'] / $modifier ) * $modifier;
        }
        else
        {
            $this->properties['majorStep'] = 1;
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( $value )
    {
        // Force typecast, because ( false < -100 ) results in (bool) true
        $floatValue = (float) $value;

        if ( $value === false )
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    return 0.;
                case ezcGraph::RIGHT:
                case ezcGraph::BOTTOM:
                    return 1.;
            }
        }
        else
        {
            $position = ( log( $value, $this->properties['base'] ) - $this->properties['min'] ) / ( $this->properties['max'] - $this->properties['min'] );

            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    return $position;
                case ezcGraph::RIGHT:
                case ezcGraph::BOTTOM:
                    return 1 - $position;
            }
        }
    }

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    public function getMinorStepCount()
    {
        return (int) ( ( $this->properties['max'] - $this->properties['min'] ) / $this->properties['minorStep'] );
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    public function getMajorStepCount()
    {
        return (int) ( ( $this->properties['max'] - $this->properties['min'] ) / $this->properties['majorStep'] );
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    public function getLabel( $step )
    {
        return sprintf( 
            $this->properties['logarithmicalFormatString'],
            $this->properties['base'],
            $this->properties['min'] + ( $step * $this->properties['majorStep'] )
        );
    }

    /**
     * Is zero step
     *
     * Returns true if the given step is the one on the initial axis position
     * 
     * @param int $step Number of step
     * @return bool Status If given step is initial axis position
     */
    public function isZeroStep( $step )
    {
        return ( $step == 0 );
    }
}

?>
