<?php
/**
 * File containing the ezcGraphRenderer2dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for renderers.
 *
 * <code>
 *   $wikidata = include 'tutorial_wikipedia_data.php';
 *   
 *   $graph = new ezcGraphBarChart();
 *   $graph->title = 'Wikipedia articles';
 *   
 *   // Add data
 *   foreach ( $wikidata as $language => $data )
 *   {
 *       $graph->data[$language] = new ezcGraphArrayDataSet( $data );
 *   }
 *   
 *   // $graph->renderer = new ezcGraphRenderer2d();
 *   
 *   $graph->renderer->options->barMargin = .2;
 *   $graph->renderer->options->barPadding = .2;
 *   
 *   $graph->renderer->options->dataBorder = 0;
 *   
 *   $graph->render( 400, 150, 'tutorial_bar_chart_options.svg' );
 * </code>
 *
 * @property float $maxLabelHeight
 *           Percent of chart height used as maximum height for pie chart 
 *           labels.
 * @property bool $showSymbol
 *           Indicates wheather to show the line between pie elements and 
 *           labels.
 * @property float $symbolSize
 *           Size of symbols used to connect a label with a pie.
 * @property float $moveOut
 *           Percent to move pie chart elements out of the middle on highlight.
 * @property int $titlePosition
 *           Position of title in a box.
 * @property int $titleAlignement
 *           Alignement of box titles.
 * @property float $dataBorder
 *           Factor to darken border of data elements, like lines, bars and 
 *           pie segments.
 * @property float $barMargin
 *           Procentual distance between bar blocks.
 * @property float $barPadding
 *           Procentual distance between bars.
 * @property float $pieChartOffset
 *           Offset for starting with first pie chart segment in degrees.
 * @property float $legendSymbolGleam
 *           Opacity of gleam in legend symbols
 * @property float $legendSymbolGleamSize
 *           Size of gleam in legend symbols
 * @property float $legendSymbolGleamColor
 *           Color of gleam in legend symbols
 * @property float $pieVerticalSize
 *           Percent of vertical space used for maximum pie chart size.
 * @property float $pieHorizontalSize
 *           Percent of horizontal space used for maximum pie chart size.
 * @property float $pieChartSymbolColor
 *           Color of pie chart symbols
 * @property float $pieChartGleam
 *           Enhance pie chart with gleam on top.
 * @property float $pieChartGleamColor
 *           Color used for gleam on pie charts.
 * @property float $pieChartGleamBorder
 *           Do not draw gleam on an outer border of this size.
 * @property bool $syncAxisFonts
 *           Synchronize fonts of axis. With the defaut true value, the only
 *           the fonts of the yAxis will be used.
 * @property bool $axisEndStyle
 *           Style of axis end markers. Defauls to arrow heads, but you may
 *           also use all symbol constants defined ein the ezcGraph class,
 *           especially ezcGraph::NO_SYMBOL.
 * 
 * @version //autogentag//
 * @package Graph
 */
class ezcGraphRendererOptions extends ezcGraphChartOptions
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
        $this->properties['maxLabelHeight'] = .10;
        $this->properties['showSymbol'] = true;
        $this->properties['symbolSize'] = 6;
        $this->properties['moveOut'] = .1;
        $this->properties['titlePosition'] = ezcGraph::TOP;
        $this->properties['titleAlignement'] = ezcGraph::MIDDLE | ezcGraph::CENTER;
        $this->properties['dataBorder'] = .5;
        $this->properties['barMargin'] = .1;
        $this->properties['barPadding'] = .05;
        $this->properties['pieChartOffset'] = 0;
        $this->properties['pieChartSymbolColor'] = ezcGraphColor::fromHex( '#000000' );
        $this->properties['pieChartGleam'] = false;
        $this->properties['pieChartGleamColor'] = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->properties['pieChartGleamBorder'] = 0;
        $this->properties['legendSymbolGleam'] = false;
        $this->properties['legendSymbolGleamSize'] = .9;
        $this->properties['legendSymbolGleamColor'] = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->properties['pieVerticalSize'] = .5;
        $this->properties['pieHorizontalSize'] = .25;
        $this->properties['syncAxisFonts'] = true;
        $this->properties['axisEndStyle'] = ezcGraph::ARROW;

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
            case 'dataBorder':
            case 'pieChartGleam':
            case 'legendSymbolGleam':
                if ( $propertyValue !== false &&
                     !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) || 
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'false OR 0 <= float <= 1' );
                }

                $this->properties[$propertyName] = ( 
                    $propertyValue === false
                    ? false
                    : (float) $propertyValue );
                break;

            case 'maxLabelHeight':
            case 'moveOut':
            case 'barMargin':
            case 'barPadding':
            case 'legendSymbolGleamSize':
            case 'pieVerticalSize':
            case 'pieHorizontalSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 1' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;

            case 'symbolSize':
            case 'titlePosition':
            case 'titleAlignement':
            case 'pieChartGleamBorder':
            case 'axisEndStyle':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }

                $this->properties[$propertyName] = (int) $propertyValue;
                break;

            case 'showSymbol':
            case 'syncAxisFonts':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'bool' );
                }
                $this->properties[$propertyName] = (bool) $propertyValue;
                break;

            case 'pieChartOffset':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 360 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 360' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;

            case 'pieChartSymbolColor':
            case 'pieChartGleamColor':
            case 'legendSymbolGleamColor':
                $this->properties[$propertyName] = ezcGraphColor::create( $propertyValue );
                break;

            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
