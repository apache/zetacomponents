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
class ezcGraphRenderer3dOptions extends ezcGraphChartOptions
{
    /**
     * Percent of chart height used as maximum height for pie chart labels
     * 
     * @var float
     * @access protected
     */
    protected $maxLabelHeight = .15;

    /**
     * Indicates wheather to show the line between pie elements and labels
     * 
     * @var bool
     */
    protected $showSymbol = true;

    /**
     * Size of symbols used concat a label with a pie
     * 
     * @var float
     * @access protected
     */
    protected $symbolSize = 6;

    /**
     * Percent to move pie chart elements out of the middle on highlight
     * 
     * @var float
     * @access protected
     */
    protected $moveOut = .1;

    /**
     * Position of title in a box
     * 
     * @var int
     */
    protected $titlePosition = ezcGraph::TOP;

    /**
     * Alignement of box titles 
     * 
     * @var int
     */
    protected $titleAlignement = 48; // ezcGraph::MIDDLE | ezcGraph::CENTER

    /**
     * Part of picture used to simulate depth of three dimensional chart
     * 
     * @var float
     */
    protected $depth = .1;

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
    protected $fillGrid = .95;

    /**
     * Factor to darken border of data elements, like lines, bars and pie 
     * segments
     * 
     * @var float
     */
    protected $dataBorder = .5;

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
            case 'maxLabelHeight':
                $this->maxLabelHeight = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'symbolSize':
                $this->symbolSize = (int) $propertyValue;
                break;
            case 'moveOut':
                $this->moveOut = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'showSymbol':
                $this->showSymbol = (bool) $propertyValue;
                break;
            case 'titlePosition':
                $this->titlePosition = (int) $propertyValue;
                break;
            case 'titleAlignement':
                $this->titleAlignement = (int) $propertyValue;
                break;
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
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
