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
 * @property float $pieChartShadow
 *           Used transparency for pie chart shadows
 * @property float $barDarkenSide
 *           Factor to darken the color used for the bars side polygon.
 * @property float $barDarkenTop
 *           Factor to darken the color used for the bars top polygon.
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
        $this->properties['pieChartShadow'] = .6;
        $this->properties['barDarkenSide'] = .2;
        $this->properties['barDarkenTop'] = .4;

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
            case 'pieChartShadow':
                $this->properties['pieChartShadow'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barDarkenSide':
                $this->properties['barDarkenSide'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barDarkenTop':
                $this->properties['barDarkenTop'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
