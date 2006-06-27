<?php
/**
 * File containing the ezcGraphLineChartOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for line charts
 *
 * @package Graph
 */
class ezcGraphLineChartOptions extends ezcGraphChartOptions
{
    /**
     * Theickness of chart lines
     * 
     * @var float
     * @access protected
     */
    protected $lineThickness = 2;

    /**
     * Status wheather the space between line and axis should get filled.
     *  - FALSE to not fill the space at all
     *  - (int) Opacity used to fill up the space with the lines color
     *
     * @var mixed
     */
    protected $fillLines = false;

    /**
     * Size of symbols in line chart
     * 
     * @var integer
     */
    protected $symbolSize = 8;

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
            case 'lineThickness':
                $this->lineThickness = max( 1, (int) $propertyValue );
                break;
            case 'fillLines':
                if ( $propertyValue === false )
                {
                    $this->fillLines = false;
                }
                else
                {
                    $this->fillLines = min( 255, max( 0, (int) $propertyValue ) );
                }
                break;
            case 'symbolSize':
                $this->symbolSize = max( 1, (int) $propertyValue );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
