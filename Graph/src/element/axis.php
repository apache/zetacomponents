<?php
/**
 * File containing the abstract ezcGraphChartElementAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
abstract class ezcGraphChartElementAxis extends ezcGraphChartElement
{
    
    /**
     * The position of the null value
     * 
     * @var float
     */
    protected $nullPosition;

    /**
     * Percent of the chart space used to display axis labels and arrowheads
     * instead of data values
     * 
     * @var float
     */
    protected $axisSpace = .1;

    /**
     * Padding between labels and axis in pixel
     * 
     * @var integer
     */
    protected $labelPadding = 2;

    /**
     * Color of major majorGrid 
     * 
     * @var ezcGraphColor
     */
    protected $majorGrid;

    /**
     * Color of minor majorGrid 
     * 
     * @var ezcGraphColor
     */
    protected $minorGrid;

    /**
     * Labeled major steps displayed on the axis 
     * 
     * @var float
     */
    protected $majorStep = false;

    /**
     * Non labeled minor steps on the axis
     * 
     * @var mixed
     * @access protected
     */
    protected $minorStep = false;

    /**
     * Formatstring to use for labeling og the axis
     * 
     * @var string
     */
    protected $formatString = '%s';

    /**
     * Maximum Size used to draw arrow heads
     * 
     * @var integer
     */
    protected $maxArrowHeadSize = 8;

    /**
     * Axis label renderer class
     * 
     * @var ezcGraphAxisLabelRenderer
     */
    protected $axisLabelRenderer;

    public function __construct( array $options = array() )
    {
        $this->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        parent::__construct( $options );
    }

    /**
     * Set colors and border fro this element
     * 
     * @param ezcGraphPalette $palette Palette
     * @return void
     */
    public function setFromPalette( ezcGraphPalette $palette )
    {
        $this->border = $palette->axisColor;
        $this->padding = $palette->padding;
        $this->margin = $palette->margin;
        $this->majorGrid = $palette->majorGridColor;
        $this->minorGrid = $palette->minorGridColor;
    }

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'nullPosition':
                $this->nullPosition = (float) $propertyValue;
                break;
            case 'axisSpace':
                $this->axisSpace = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'labelPadding':
                $this->labelPadding = min( 0, max( 0, (float) $propertyValue ) );
                break;
            case 'majorGrid':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->majorGrid = $propertyValue;
                }
                else
                {
                    $this->majorGrid = ezcGraphColor::create( $propertyValue );
                }
                break;
            case 'minorGrid':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->minorGrid = $propertyValue;
                }
                else
                {
                    $this->minorGrid = ezcGraphColor::create( $propertyValue );
                }
                break;
            case 'majorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'majorStep', $propertyValue, 'float > 0' );
                }
                $this->majorStep = (float) $propertyValue;
                break;
            case 'minorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'minorStep', $propertyValue, 'float > 0' );
                }
                $this->minorStep = (float) $propertyValue;
                break;
            case 'formatString':
                $this->formatString = (string) $propertyValue;
                break;
            case 'maxArrowHeadSize':
                $this->maxArrowHeadSize = max( 0, (int) $propertyValue );
                break;
            case 'axisLabelRenderer':
                if ( $propertyValue instanceof ezcGraphAxisLabelRenderer )
                {
                    $this->axisLabelRenderer = $propertyValue;
                }
                else
                {
                    throw new ezcBasePropertyNotFoundException( $propertyName );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    abstract public function getCoordinate( $value );

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    abstract public function getMinorStepCount();

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    abstract public function getMajorStepCount();

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    abstract public function getLabel( $step );

    /**
     * Add data for this axis
     * 
     * @param mixed $value Value which will be displayed on this axis
     * @return void
     */
    abstract public function addData( array $values );

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @abstract
     * @access public
     * @return void
     */
    abstract public function calculateAxisBoundings();

    /**
     * Render an axe
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $start = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    0
                );
                $end = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    $boundings->y1 - $boundings->y0
                );
                break;
            case ezcGraph::BOTTOM:
                $start = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    $boundings->y1 - $boundings->y0
                );
                $end = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    0
                );
                break;
            case ezcGraph::LEFT:
                $start = new ezcGraphCoordinate(
                    0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                $end = new ezcGraphCoordinate(
                    $boundings->x1 - $boundings->x0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                break;
            case ezcGraph::RIGHT:
                $start = new ezcGraphCoordinate(
                    $boundings->x1 - $boundings->x0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                $end = new ezcGraphCoordinate(
                    0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                break;
        }

        $renderer->drawAxis(
            $boundings,
            $start,
            $end,
            $this,
            $this->axisLabelRenderer
        );

        return $boundings;   
    }
}

?>
