<?php
/**
 * File containing the ezcGraphRenderer2dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @property float $maxLabelHeight
 *           Percent of chart height used as maximum height for pie chart 
 *           labels.
 * @property bool $showSymbol
 *           Indicates wheather to show the line between pie elements and 
 *           labels.
 * @property float $symbolSize
 *           Size of symbols used concat a label with a pie.
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
 * 
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
        $this->properties['pieVerticalSize'] = .5;
        $this->properties['pieHorizontalSize'] = .25;

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
            case 'maxLabelHeight':
                $this->properties['maxLabelHeight'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'symbolSize':
                $this->properties['symbolSize'] = (int) $propertyValue;
                break;
            case 'moveOut':
                $this->properties['moveOut'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'showSymbol':
                $this->properties['showSymbol'] = (bool) $propertyValue;
                break;
            case 'titlePosition':
                $this->properties['titlePosition'] = (int) $propertyValue;
                break;
            case 'titleAlignement':
                $this->properties['titleAlignement'] = (int) $propertyValue;
                break;
            case 'dataBorder':
                $this->properties['dataBorder'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barMargin':
                $this->properties['barMargin'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barPadding':
                $this->properties['barPadding'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartOffset':
                $this->properties['pieChartOffset'] = $propertyValue % 360;
                break;
            case 'pieChartSymbolColor':
                $this->properties['pieChartSymbolColor'] = ezcGraphColor::create( $propertyValue );
                break;
            case 'pieChartGleam':
                $this->properties['pieChartGleam'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartGleamColor':
                $this->properties['pieChartGleamColor'] = ezcGraphColor::create( $propertyValue );
                break;
            case 'pieChartGleamBorder':
                $this->properties['pieChartGleamBorder'] = max( 0, (int) $propertyValue );
                break;
            case 'legendSymbolGleam':
                $this->properties['legendSymbolGleam'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'legendSymbolGleamSize':
                $this->properties['legendSymbolGleamSize'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'legendSymbolGleamColor':
                $this->properties['legendSymbolGleamColor'] = ezcGraphColor::create( $propertyValue );
                break;
            case 'pieVerticalSize':
                $this->properties['pieVerticalSize'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieHorizontalSize':
                $this->properties['pieHorizontalSize'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
