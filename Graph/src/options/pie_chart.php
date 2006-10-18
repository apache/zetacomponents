<?php
/**
 * File containing the ezcGraphPieChartOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @property string $label
 *           String used to label pies
 *              %$1s    Name of pie
 *              %2$d    Value of pie
 *              %3$.1f  Percentage
 * @property float $sum
 *           Fixed sum of values. This should be used for incomplete pie 
 *           charts.
 *
 * @package Graph
 */
class ezcGraphPieChartOptions extends ezcGraphChartOptions
{
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['label'] = '%1$s: %2$d (%3$.1f%%)';
        $this->properties['sum'] = false;

        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'label':
                $this->properties['label'] = (string) $propertyValue;
                break;
            case 'sum':
                $this->properties['sum'] = (float) $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
