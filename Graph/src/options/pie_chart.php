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
 * @package Graph
 */
class ezcGraphPieChartOptions extends ezcGraphChartOptions
{
    /**
     * String used to label pies
     *      %$1s    Name of pie
     *      %2$d    Value of pie
     *      %3$.1f  Percentage
     * 
     * @var string
     * @access protected
     */
    protected $label = '%1$s: %2$d (%3$.1f%%)';

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'label':
                $this->label = (string) $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
