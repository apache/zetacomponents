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
 * Class containing the basic options for charts
 *
 * @package Graph
 */
class ezcGraphPieChartOptions extends ezcGraphChartOptions
{
    /**
     * Percent of chart height used as maximum height for pie chart labels
     * 
     * @var float
     * @access protected
     */
    protected $maxLabelHeight = .15;

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
     * Size of symbols used concat a label with a pie
     * 
     * @var float
     * @access protected
     */
    protected $symbolSize = 6;

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
            case 'maxLabelHeight':
                $this->maxLabelHeight = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'label':
                $this->label = (string) $propertyValue;
                break;
            case 'symbolSize':
                $this->symbolSize = (int) $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
