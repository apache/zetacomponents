<?php
/**
 * File containing the ezcGraphDriverOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic driver options.
 *
 * <code>
 *   require_once 'tutorial_autoload.php';
 *   
 *   $graph = new ezcGraphPieChart();
 *   $graph->palette = new ezcGraphPaletteEzBlue();
 *   $graph->title = 'Access statistics';
 *   
 *   $graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
 *       'Mozilla' => 19113,
 *       'Explorer' => 10917,
 *       'Opera' => 1464,
 *       'Safari' => 652,
 *       'Konqueror' => 474,
 *   ) );
 *
 *   $graph->driver->options->autoShortenString = false;
 *   
 *   $graph->render( 400, 150, 'tutorial_chart_title.svg' );
 * </code>
 *
 * @property int $width
 *           Width of the chart.
 * @property int $height
 *           Height of the chart.
 * @property float $shadeCircularArc
 *           Percent to darken circular arcs at the sides
 * @property float $lineSpacing
 *           Percent of font size used for line spacing
 * @property int $font
 *           Font used in the graph.
 * @property bool $autoShortenString
 *           Automatically shorten string if it does not fit into a box
 * @property string $autoShortenStringPostFix
 *           String to append to shortened strings, if there is enough space
 *
 * @version //autogentag//
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
        $this->properties['width'] = null;
        $this->properties['height'] = null;

        $this->properties['lineSpacing'] = .1;
        $this->properties['shadeCircularArc'] = .5;
        $this->properties['font'] = new ezcGraphFontOptions();
        $this->properties['font']->color = ezcGraphColor::fromHex( '#000000' );

        $this->properties['autoShortenString'] = true;
        $this->properties['autoShortenStringPostFix'] = '..';

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
            case 'lineSpacing':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) || 
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 1' );
                }

                $this->properties['lineSpacing'] = (float) $propertyValue;
                break;
            case 'shadeCircularArc':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) || 
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 1' );
                }

                $this->properties['shadeCircularArc'] = (float) $propertyValue;
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
            case 'autoShortenString':
                if ( is_bool( $propertyValue ) )
                {
                    $this->properties['autoShortenString'] = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'boolean' );
                }
                break;
            case 'autoShortenStringPostFix':
                $this->properties['autoShortenStringPostFix'] = (string) $propertyValue;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
