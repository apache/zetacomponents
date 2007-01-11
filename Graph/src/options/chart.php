<?php
/**
 * File containing the ezcGraphChartOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @property int $width
 *           Width of the chart.
 * @property int $height
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
        $this->properties['width'] = null;
        $this->properties['height'] = null;
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
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 1 ) ) 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 1' );
                }

                $this->properties['width'] = (int) $propertyValue;
                break;
            case 'height':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 1 ) ) 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 1' );
                }

                $this->properties['height'] = (int) $propertyValue;
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
