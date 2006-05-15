<?php
/**
 * File containing the abstract ezcGraphChartElementLegend class
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
class ezcGraphChartElementLegend extends ezcGraphChartElement
{

    /**
     * Contains datasets which should be shown in legend
     * 
     * @var array
     */
    protected $dataset;

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
            case 'dataset':
                if ( $propertyValue instanceof ezcGraphDataset )
                {
                    $this->dataset[] = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( 'dataset' , $propertyValue, ezcGraphDataset );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }
    
    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer )
    {
        
    }
}

?>
