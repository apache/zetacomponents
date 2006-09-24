<?php
/**
 * File containing the ezcGraphChartOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @property int $width
 *           Width of the chart.
 * @property int $heigh
 *           Height of the chart.
 * @property int $font
 *           Font used in the graph.
 *
 * @package Graph
 */
class ezcGraphChartOptions extends ezcBaseOptions
{
    public function __construct( array $options = array() )
    {
        $this->properties['font'] = new ezcGraphFontOptions();

        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'width':
                $this->properties['width'] = max( 1, (int) $propertyValue );
                break;
            case 'height':
                $this->properties['height'] = max( 1, (int) $propertyValue );
                break;
            case 'font':
                $this->properties['font']->path = $propertyValue;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
