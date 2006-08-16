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
 * @package Graph
 */
class ezcGraphRenderer3dOptions extends ezcGraphRendererOptions
{

    /**
     * Indicates wheather the full depth should be used for each line in the
     * chart, or beeing seperated by the count of lines
     * 
     * @var bool
     */
    protected $seperateLines = true;

    /**
     * Transparency used to fill the axis polygon
     * 
     * @var float
     */
    protected $fillAxis = .8;

    /**
     * Transparency used to fill the grid lines
     * 
     * @var float
     */
    protected $fillGrid = 0;

    /**
     * Part of picture used to simulate depth of three dimensional chart
     *
     * @var float
    */
    protected $depth = .1;

    /**
     * Height of the pie charts border
     * 
     * @var float
     */
    protected $pieChartHeight = 10;

    /**
     * Rotation of pie chart. Defines the percent of width used to calculate
     * the height of the ellipse.
     * 
     * @var float
     */
    protected $pieChartRotation = .6;

    /**
     * Used transparency for pie chart shadows
     * 
     * @var float
     */
    protected $pieChartShadow = .6;

    /**
     * Procentual distance between bar blocks
     * 
     * @var float
     */
    protected $barMargin = .1;

    /**
     * Procentual distance between bars
     * 
     * @var float
     */
    protected $barPadding = .05;

    /**
     * Factor to darken the color used for the bars side polygon
     * 
     * @var float
     */
    protected $barDarkenSide = .2;

    /**
     * Factor to darken the color used for the bars top polygon
     * 
     * @var float
     */
    protected $barDarkenTop = .4;

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
            case 'depth':
                $this->depth = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'seperateLines':
                $this->seperateLines = (bool) $propertyValue;
                break;
            case 'fillAxis':
                $this->fillAxis = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'fillGrid':
                $this->fillGrid = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'dataBorder':
                $this->dataBorder = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartHeight':
                $this->pieChartHeight = (float) $propertyValue;
                break;
            case 'pieChartRotation':
                $this->pieChartRotation = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartShadow':
                $this->pieChartShadow = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barDarkenSide':
                $this->barDarkenSide = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'barDarkenTop':
                $this->barDarkenTop = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
