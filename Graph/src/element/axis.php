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
     * Color of the griding 
     * 
     * @var ezcGraphColor
     */
    protected $grid = false;

    /**
     * Raster minor steps on axis
     * 
     * @var ezcGraphColor
     */
    protected $minorGrid = false;

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
     * Length of lines for the major steps on the axis
     * 
     * @var integer
     */
    protected $majorScalingLineLength = 4;
    
    /**
     * Length of lines for the minor steps on the axis
     * 
     * @var integer
     */
    protected $minorScalingLineLength = 2;

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

    public function __construct( array $options = array() )
    {
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
        $this->grid = $palette->gridColor;
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
            case 'grid':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->grid = $propertyValue;
                }
                else
                {
                    $this->grid = ezcGraphColor::create( $propertyValue );
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
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    abstract public function getCoordinate( ezcGraphBoundings $boundings, $value );

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    abstract protected function getMinorStepCount();

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    abstract protected function getMajorStepCount();

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    abstract protected function getLabel( $step );

    /**
     * Draw labels for an axis
     * 
     * @param ezcGraphRenderer $renderer 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphBoundings $boundings 
     * @return void
     */
    abstract protected function drawLabels( ezcGraphRenderer $renderer, ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphBoundings $boundings );

    /**
     * Draw a axis from a start point to an end point. They do not need to be 
     * placed in-plane.
     * 
     * @param ezcGraphRenderer $renderer 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param float $major 
     * @param float $minor 
     * @return void
     */
    protected function drawAxis( ezcGraphRenderer $renderer, ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphBoundings $boundings ) 
    {
        // Determine normalized direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;

        // Draw axis
        $renderer->drawLine(
            $this->border,
            $start,
            $end,
            false
        );

        // Draw small arrowhead
        $size = min(
            $this->maxArrowHeadSize,
            abs( ceil( ( ( $end->x - $start->x ) + ( $end->y - $start->y ) ) * $this->axisSpace / 4 ) )
        );

        $renderer->drawPolygon(
            array(
                new ezcGraphCoordinate(
                    (int) round( $end->x ),
                    (int) round( $end->y )
                ),
                new ezcGraphCoordinate(
                    (int) round( $end->x
                        + $direction->y * $size / 2
                        + $direction->x * $size ),
                    (int) round( $end->y
                        + $direction->x * $size / 2
                        + $direction->y * $size )
                ),
                new ezcGraphCoordinate(
                    (int) round( $end->x
                        - $direction->y * $size / 2
                        + $direction->x * $size ),
                    (int) round( $end->y
                        - $direction->x * $size / 2
                        + $direction->y * $size )
                ),
            ),
            $this->border,
            true
        );

        // Apply axisSpace to start and end
        $start->x += ( $end->x - $start->x ) * ( $this->axisSpace / 2 );
        $start->y += ( $end->y - $start->y ) * ( $this->axisSpace / 2 );
        $end->x -= ( $end->x - $start->x ) * ( $this->axisSpace / 2 );
        $end->y -= ( $end->y - $start->y ) * ( $this->axisSpace / 2 );

        // Draw major steps
        $steps = $this->getMajorStepCount();

        // Calculate stepsize
        $xStepsize = ( $end->x - $start->x ) / $steps;
        $yStepsize = ( $end->y - $start->y ) / $steps;

        // Calculate grid boundings
        $negGrid = ( $boundings->x0 - $start->x ) * $direction->y + ( $boundings->y0 - $end->y ) * $direction->x;
        $posGrid = ( $boundings->x1 - $end->x ) * $direction->y + ( $boundings->y1 - $start->y ) * $direction->x;

        // Draw major steps
        for ( $i = 0; $i <= $steps; ++$i )
        {
            if ( $this->grid && $this->grid->alpha < 255 )
            {
                $renderer->drawLine(
                    $this->grid,
                    new ezcGraphCoordinate(
                        (int) round( $start->x + $i * $xStepsize
                            + $direction->y * $negGrid ),
                        (int) round( $start->y + $i * $yStepsize
                            + $direction->x * $negGrid )
                    ),
                    new ezcGraphCoordinate(
                        (int) round( $start->x + $i * $xStepsize
                            + $direction->y * $posGrid ),
                        (int) round( $start->y + $i * $yStepsize
                            + $direction->x * $posGrid )
                    ),
                    false
                );
            }

            $renderer->drawLine(
                $this->border,
                new ezcGraphCoordinate(
                    (int) round( $start->x + $i * $xStepsize
                        + $direction->y * $this->majorScalingLineLength ),
                    (int) round( $start->y + $i * $yStepsize
                        + $direction->x * -$this->majorScalingLineLength )
                ),
                new ezcGraphCoordinate(
                    (int) round( $start->x + $i * $xStepsize
                        + $direction->y * -$this->majorScalingLineLength ),
                    (int) round( $start->y + $i * $yStepsize
                        + $direction->x * $this->majorScalingLineLength )
                ),
                false
            );
        }

        // Draw minor steps if wanted
        if ( $this->minorStep )
        {
            $steps = $this->getMinorStepCount();
            for ( $i = 0; $i < $steps; ++$i )
            {
                if ( $this->minorGrid && $this->minorGrid->alpha < 255 )
                {
                    $renderer->drawLine(
                        $this->minorGrid,
                        new ezcGraphCoordinate(
                            (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                                + $direction->y * $negGrid ),
                            (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                                + -$direction->x * $negGrid )
                        ),
                        new ezcGraphCoordinate(
                            (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                                + $direction->y * $posGrid ),
                            (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                                + -$direction->x * $posGrid )
                        ),
                        false
                    );
                }

                $renderer->drawLine(
                    $this->border,
                    new ezcGraphCoordinate(
                        (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                            + $direction->y * $this->minorScalingLineLength),
                        (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                            + $direction->x * -$this->minorScalingLineLength)
                    ),
                    new ezcGraphCoordinate(
                        (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                            + $direction->y * -$this->minorScalingLineLength),
                        (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                            + $direction->x * $this->minorScalingLineLength)
                    ),
                    false
                );
            }
        }

        $this->drawLabels( $renderer, $start, $end, $boundings );
    }

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
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        (int) $this->nullPosition,
                        (int) $boundings->y0
                    ),
                    new ezcGraphCoordinate(
                        (int) $this->nullPosition,
                        (int) $boundings->y1
                    ),
                    $boundings
                );
                break;
            case ezcGraph::BOTTOM:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        (int) $this->nullPosition,
                        (int) $boundings->y1
                    ),
                    new ezcGraphCoordinate(
                        (int) $this->nullPosition,
                        (int) $boundings->y0
                    ),
                    $boundings
                );
                break;
            case ezcGraph::LEFT:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        (int) $boundings->x0,
                        (int) $this->nullPosition
                    ),
                    new ezcGraphCoordinate(
                        (int) $boundings->x1,
                        (int) $this->nullPosition
                    ),
                    $boundings
                );
                break;
            case ezcGraph::RIGHT:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        (int) $boundings->x1,
                        (int) $this->nullPosition
                    ),
                    new ezcGraphCoordinate(
                        (int) $boundings->x0,
                        (int) $this->nullPosition
                    ),
                    $boundings
                );
                break;
        }
        return $boundings;   
    }
}

?>
