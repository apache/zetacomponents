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
 * @property float $lineThickness
 *           Theickness of chart lines
 * @property mixed $fillLines
 *           Status wheather the space between line and axis should get filled.
 *            - FALSE to not fill the space at all.
 *            - (int) Opacity used to fill up the space with the lines color.
 * @property int $symbolSize
 *           Size of symbols in line chart.
 *
 * @package Graph
 */
class ezcGraphLineChartOptions extends ezcGraphChartOptions
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
        $this->properties['lineThickness'] = 2;
        $this->properties['fillLines'] = false;
        $this->properties['symbolSize'] = 8;

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
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'lineThickness':
                $this->properties['lineThickness'] = max( 1, (int) $propertyValue );
                break;
            case 'fillLines':
                if ( $propertyValue === false )
                {
                    $this->properties['fillLines'] = false;
                }
                else
                {
                    $this->properties['fillLines'] = min( 255, max( 0, (int) $propertyValue ) );
                }
                break;
            case 'symbolSize':
                $this->properties['symbolSize'] = max( 1, (int) $propertyValue );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
