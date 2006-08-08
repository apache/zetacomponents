<?php
/**
 * File containing the ezcGraphSvgDriverOption class
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
class ezcGraphSvgDriverOptions extends ezcGraphDriverOptions
{

    /**
     * Assumed percentual average width of chars with the used font
     * 
     * @var float
     */
    protected $assumedCharacterWidth = .55;

    /**
     * This specifies the shape to be used at the end of open subpaths when 
     * they are stroked.
     * 
     * @var string
     */
    protected $strokeLineCap = 'round';

    /**
     * "The creator of SVG content might want to provide a hint to the 
     * implementation about what tradeoffs to make as it renders vector 
     * graphics elements such as 'path' elements and basic shapes such as 
     * circles and rectangles."
     * 
     * @var string
     */
    protected $shapeRendering = 'geometricPrecision';

    /**
     * "The creator of SVG content might want to provide a hint to the 
     * implementation about how to make speed vs. quality tradeoffs as it 
     * performs color interpolation and compositing. The 'color-rendering' 
     * property provides a hint to the SVG user agent about how to optimize 
     * its color interpolation and compositing operations."
     * 
     * @var string
     */
    protected $colorRendering = 'optimizeQuality';

    /**
     * "The creator of SVG content might want to provide a hint to the 
     * implementation about what tradeoffs to make as it renders text." 
     * 
     * @var string
     */
    protected $textRendering = 'optimizeLegibility';

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
            case 'assumedCharacterWidth':
                $this->assumedCharacterWidth = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'strokeLineCap':
                $values = array(
                    'round',
                    'butt',
                    'square',
                    'inherit',
                );

                if ( in_array( $propertyValue, $values, true ) )
                {
                    $this->strokeLineCap = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, implode( $values, ', ' ) );
                }
                break;
            case 'shapeRendering':
                $values = array(
                    'auto',
                    'optimizeSpeed',
                    'crispEdges',
                    'geometricPrecision',
                    'inherit',
                );

                if ( in_array( $propertyValue, $values, true ) )
                {
                    $this->shapeRendering = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, implode( $values, ', ' ) );
                }
                break;
            case 'colorRendering':
                $values = array(
                    'auto',
                    'optimizeSpeed',
                    'optimizeQuality',
                    'inherit',
                );

                if ( in_array( $propertyValue, $values, true ) )
                {
                    $this->colorRendering = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, implode( $values, ', ' ) );
                }
                break;
            case 'textRendering':
                $values = array(
                    'auto',
                    'optimizeSpeed',
                    'optimizeLegibility',
                    'geometricPrecision',
                    'inherit',
                );

                if ( in_array( $propertyValue, $values, true ) )
                {
                    $this->textRendering = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, implode( $values, ', ' ) );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    protected function checkFont( $font )
    {
    }
}

?>
