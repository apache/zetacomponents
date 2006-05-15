<?php
/**
 * File containing the abstract ezcGraphChartElementNumericAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a axe as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementNumericAxis extends ezcGraphChartElement
{
    
    protected $min = false;

    protected $max = false;

    protected $majorStep = false;

    protected $minorStep = false;

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
            case 'min':
                $this->min = (float) $propertyValue;
                break;
            case 'max':
                $this->max = (float) $propertyValue;
                break;
            case 'majorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'majorStep', $propertyValue, 'float > 0' );
                }
                $this->majorStep = (float) $propertyValue;
                break;
            case 'minorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'minorStep', $propertyValue, 'float > 0' );
                }
                $this->minorStep = (float) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Calculate steps, min and max values from given datasets, if not set 
     * manually before. receives an array of array( ezcGraphDataset )
     * 
     * @param array $datasets 
     * @return void
     */
    public function calculateFromDataset(array $datasets)
    {

    }
    
    /**
     * Render an axe
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer )
    {
        
    }

}
