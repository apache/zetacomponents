<?php
/**
 * File containing the abstract ezcGraphChartElementAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
abstract class ezcGraphChartElementAxis extends ezcGraphChartElement
{
    
    /**
     * The position of the null value
     * 
     * @var float
     */
    protected $nullPosition;

    /**
     * Percent of the chart space not used to display values
     * 
     * @var float
     */
    protected $padding = .1;

    /**
     * Color of the rastering 
     * 
     * @var ezcGraphColor
     */
    protected $raster = false;

    /**
     * Raster minor steps on axis
     * 
     * @var ezcGraphColor
     */
    protected $rasterMinor = false;

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
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'nullPosition':
                $this->nullPosition = (float) $propertyValue;
                break;
            case 'padding':
                $this->padding = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'raster':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->raster = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphColor' );
                }
            case 'rasterMinor':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->rasterMinor = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphColor' );
                }
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    abstract public function getCoordinate( ezcGraphBoundings $boundings, $value );

    /**
     * Render an axe
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        return $boundings;   
    }
}

?>
