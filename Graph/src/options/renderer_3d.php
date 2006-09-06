<?php
/**
 * File containing the ezcGraphRenderer3dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @property bool $seperateLines
 *           Indicates wheather the full depth should be used for each line in
 *           the chart, or beeing seperated by the count of lines.
 * @property float $fillAxis
 *           Transparency used to fill the axis polygon.
 * @property float $fillGrid
 *           Transparency used to fill the grid lines.
 * @property float $depth
 *           Part of picture used to simulate depth of three dimensional chart.
 * @property float $pieChartHeight
 *           Height of the pie charts border.
 * @property float $pieChartRotation
 *           Rotation of pie chart. Defines the percent of width used to 
 *           calculate the height of the ellipse.
 * @property int $pieChartShadowSize
 *           Size of shadows.
 * @property float $pieChartShadowTransparency
 *           Used transparency for pie chart shadows.
 * @property float $pieChartShadowColor
 *           Color used for pie chart shadows.
 * @property float $pieChartGleam
 *           Enhance pie chart with gleam on top.
 * @property float $pieChartGleamColor
 *           Color used for gleam on pie charts.
 * @property float $barDarkenSide
 *           Factor to darken the color used for the bars side polygon.
 * @property float $barDarkenTop
 *           Factor to darken the color used for the bars top polygon.
 * @property float $barChartGleam
 *           Transparancy for gleam on bar charts
 * 
 * @package Graph
 */
class ezcGraphRenderer3dOptions extends ezcGraphRendererOptions
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
        $this->properties['seperateLines'] = true;
        $this->properties['fillAxis'] = .8;
        $this->properties['fillGrid'] = 0;
        $this->properties['depth'] = .1;
        $this->properties['pieChartHeight'] = 10;
        $this->properties['pieChartRotation'] = .6;
        $this->properties['pieChartShadowSize'] = 0;
        $this->properties['pieChartShadowTransparency'] = .3;
        $this->properties['pieChartShadowColor'] = ezcGraphColor::fromHex( '#000000' );
        $this->properties['pieChartGleam'] = false;
        $this->properties['pieChartGleamColor'] = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->properties['barDarkenSide'] = .2;
        $this->properties['barDarkenTop'] = .4;
        $this->properties['barChartGleam'] = false;

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
            case 'depth':
                $this->properties['depth'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'seperateLines':
                $this->properties['seperateLines'] = (bool) $propertyValue;
                break;
            case 'fillAxis':
                $this->properties['fillAxis'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'fillGrid':
                $this->properties['fillGrid'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'dataBorder':
                $this->properties['dataBorder'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartHeight':
                $this->properties['pieChartHeight'] = (float) $propertyValue;
                break;
            case 'pieChartRotation':
                $this->properties['pieChartRotation'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartGleam':
                $this->properties['pieChartGleam'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartShadowSize':
                $this->properties['pieChartShadowSize'] = max( 0, (int) $propertyValue );
                break;
            case 'pieChartShadowTransparency':
                $this->properties['pieChartShadowTransparency'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartShadowColor':
                if ( !$propertyValue instanceof ezcGraphColor )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphColor' );
                }
                $this->properties['pieChartShadowColor'] = $propertyValue;
                break;
            case 'barDarkenSide':
                $this->properties['barDarkenSide'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barDarkenTop':
                $this->properties['barDarkenTop'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barChartGleam':
                $this->properties['barChartGleam'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
