<?php
/**
 * File containing the ezcGraphDriverOption class
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
 * @property int $height
 *           Height of the chart.
 * @property float $shadeCircularArc
 *           Percent to darken circular arcs at the sides
 * @property int $font
 *           Font used in the graph.
 * @property float $lineSpacing
 *           Percent of font size used for line spacing
 *
 * @package Graph
 */
abstract class ezcGraphDriverOptions extends ezcBaseOptions
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
        $this->properties['lineSpacing'] = .1;
        $this->properties['shadeCircularArc'] = .5;
        $this->properties['font'] = new ezcGraphFontOptions();
        $this->properties['font']->color = ezcGraphColor::fromHex( '#000000' );

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
            case 'width':
                $this->properties['width'] = max( 1, (int) $propertyValue );
                break;
            case 'height':
                $this->properties['height'] = max( 1, (int) $propertyValue );
                break;
            case 'shadeCircularArc':
                $this->properties['shadeCircularArc'] = max( 0, min( 1, (float) $propertyValue ) );
                break;
            case 'font':
                if ( $propertyValue instanceof ezcGraphFontOptions )
                {
                    $this->properties['font'] = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphFontOptions' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
