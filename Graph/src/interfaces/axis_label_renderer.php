<?php
/**
 * File containing the abstract ezcGraphAxisLabelRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005,
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class to render labels and grids on axis. Will be extended to
 * make it possible using different algorithms for rendering axis labels.
 *
 * @package Graph
 */
abstract class ezcGraphAxisLabelRenderer extends ezcBaseOptions
{

    protected $driver;

    protected $majorStepCount = false;

    protected $minorStepCount = false;

    protected $majorStepSize = 3;

    protected $minorStepSize = 1;

    protected $innerStep = true;

    protected $outerStep = false;

    protected $outerGrid = false;

    protected $labelPadding = 2;

    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'driver':
                if ( $propertyValue instanceof ezcGraphDriver )
                {
                    $this->driver = $propertyValue;
                }
                else
                {
                    throw new ezcGraphInvalidDriverException( $propertyValue );
                }
                break;
            case 'majorStepCount':
                $this->majorStepCount = (int) $propertyValue;
                break;
            case 'minorStepCount':
                $this->minorStepCount = (int) $propertyValue;
                break;
            case 'majorStepSize':
                $this->majorStepSize = (int) $propertyValue;
                break;
            case 'minorStepSize':
                $this->minorStepSize = (int) $propertyValue;
                break;
            case 'innerStep':
                $this->innerStep = (bool) $propertyValue;
                break;
            case 'outerStep':
                $this->outerStep = (bool) $propertyValue;
                break;
            case 'outerGrid':
                $this->outerGrid = (bool) $propertyValue;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
    }

    public function determineLineCuttingPoint( ezcGraphCoordinate $aStart, ezcGraphCoordinate $aDir, ezcGraphCoordinate $bStart, ezcGraphCoordinate $bDir )
    {
        // Check if line are parallel
        if ( ( ( $aDir->x == 0 ) && ( $bDir->x == 0 ) ) ||
             ( ( $aDir->y == 0 ) && ( $bDir->y == 0 ) ) || 
             ( ( ( $aDir->x * $bDir->x * $aDir->y * $bDir->y ) != 0 ) && 
               ( ( $aDir->x / $aDir->y ) == ( $bDir->x / $bDir->y ) ) 
             )
           )
        {
            return false;
        }

        // Use ? : to prevent division by zero
        $denominator = 
            ( $aDir->y != 0 ? $bDir->y / $aDir->y : 0 ) - 
            ( $aDir->x != 0 ? $bDir->x / $aDir->x : 0 );

        // Solve equatation
        if ( $denominator == 0 )
        {
            return - ( 
                ( $aDir->y != 0 ? $bStart->y / $aDir->y : 0 ) -
                ( $aDir->y != 0 ? $aStart->y / $aDir->y : 0 ) -
                ( $aDir->x != 0 ? $bStart->x / $aDir->x : 0 ) +
                ( $aDir->x != 0 ? $aStart->x / $aDir->x : 0 )
                );
        }
        else 
        {
            return - ( 
                ( $aDir->y != 0 ? $bStart->y / $aDir->y : 0 ) -
                ( $aDir->y != 0 ? $aStart->y / $aDir->y : 0 ) -
                ( $aDir->x != 0 ? $bStart->x / $aDir->x : 0 ) +
                ( $aDir->x != 0 ? $aStart->x / $aDir->x : 0 )
            ) / $denominator;

        }
    }

    /**
     * Draw single step on a axis
     *
     * Draws a step on a axis at the current position
     * 
     * @param ezcGraphRenderer $renderer Renderer to draw the step with
     * @param ezcGraphCoordinate $position Position of step
     * @param ezcGraphCoordinate $direction Direction of axis
     * @param int $axisPosition Position of axis
     * @param int $size Step size
     * @param ezcGraphColor $color Color of axis
     * @return void
     */
    public function drawStep( ezcGraphRenderer $renderer, ezcGraphCoordinate $position, ezcGraphCoordinate $direction, $axisPosition, $size, ezcGraphColor $color )
    {
        if ( ! ( $this->innerStep || $this->outerStep ) )
        {
            return false;
        }

        $drawStep = false;
        if ( ( ( $axisPosition === ezcGraph::CENTER ) && $this->innerStep ) ||
             ( ( $axisPosition === ezcGraph::BOTTOM ) && $this->outerStep ) ||
             ( ( $axisPosition === ezcGraph::TOP ) && $this->innerStep ) ||
             ( ( $axisPosition === ezcGraph::RIGHT ) && $this->outerStep ) ||
             ( ( $axisPosition === ezcGraph::LEFT ) && $this->innerStep ) )
        {
            // Turn direction vector to left by 90 degrees and multiply 
            // with major step size
            $stepStart = new ezcGraphCoordinate(
                $position->x - $direction->y * $size,
                $position->y + $direction->x * $size
            );
            $drawStep = true;
        }
        else
        {
            $stepStart = $position;
        }

        if ( ( ( $axisPosition === ezcGraph::CENTER ) && $this->innerStep ) ||
             ( ( $axisPosition === ezcGraph::BOTTOM ) && $this->innerStep ) ||
             ( ( $axisPosition === ezcGraph::TOP ) && $this->outerStep ) ||
             ( ( $axisPosition === ezcGraph::RIGHT ) && $this->innerStep ) ||
             ( ( $axisPosition === ezcGraph::LEFT ) && $this->outerStep ) )
        {
            // Turn direction vector to right by 90 degrees and multiply 
            // with major step size
            $stepEnd = new ezcGraphCoordinate(
                $position->x + $direction->y * $size,
                $position->y - $direction->x * $size
            );
            $drawStep = true;
        }
        else
        {
            $stepEnd = $position;
        }

        if ( $drawStep )
        {
            $renderer->drawStepLine(
                $stepStart,
                $stepEnd,
                $color
            );
        }
    }
    
    /**
     * Draw grid
     *
     * Draws a grid line at the current position
     * 
     * @param ezcGraphRenderer $renderer Renderer to draw the grid with
     * @param ezcGraphBoundings $boundings Boundings of axis
     * @param ezcGraphCoordinate $position Position of step
     * @param ezcGraphCoordinate $direction Direction of axis
     * @param ezcGraphColor $color Color of axis
     * @return void
     */
    protected function drawGrid( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings, ezcGraphCoordinate $position, ezcGraphCoordinate $direction, ezcGraphColor $color )
    {
        // Direction of grid line is direction of axis turned right by 90 
        // degrees
        $gridDirection = new ezcGraphCoordinate(
            $direction->y,
            - $direction->x
        );

        $cuttingPoints = array();
        foreach ( array( // Bounding lines
                array(
                    'start' => new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                    'dir' => new ezcGraphCoordinate( 0, $boundings->y1 - $boundings->y0 )
                ),
                array(
                    'start' => new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                    'dir' => new ezcGraphCoordinate( $boundings->x1 - $boundings->x0, 0 )
                ),
                array(
                    'start' => new ezcGraphCoordinate( $boundings->x1, $boundings->y1 ),
                    'dir' => new ezcGraphCoordinate( 0, $boundings->y0 - $boundings->y1 )
                ),
                array(
                    'start' => new ezcGraphCoordinate( $boundings->x1, $boundings->y1 ),
                    'dir' => new ezcGraphCoordinate( $boundings->x0 - $boundings->x1, 0 )
                ),
            ) as $boundingLine )
        {
            // Test for cutting points with bounding lines, where cutting 
            // position is between 0 and 1, which means, that the line is hit
            // on the bounding box rectangle. Use these points as a start and
            // ending point for the grid lines. There should *always* be two
            // points returned.
            $cuttingPosition = $this->determineLineCuttingPoint(
                $boundingLine['start'],
                $boundingLine['dir'],
                $position,
                $gridDirection
            );

            if ( $cuttingPosition === false )
            {
                continue;
            }
            // Round to prevent minor float incorectnesses
            $cuttingPosition = abs( round( $cuttingPosition, 2 ) );

            if ( ( $cuttingPosition >= 0 ) && 
                 ( $cuttingPosition <= 1 ) )
            {
                $cuttingPoints[] = new ezcGraphCoordinate(
                    $boundingLine['start']->x + $cuttingPosition * $boundingLine['dir']->x,
                    $boundingLine['start']->y + $cuttingPosition * $boundingLine['dir']->y
                );
            }
        }

        if ( count( $cuttingPoints ) < 2 )
        {
            return false;
        }

        // Finally draw grid line
        $renderer->drawGridLine(
            $cuttingPoints[0],
            $cuttingPoints[1],
            $color
        );
    }

    /**
     * Modify chart boundings
     *
     * Optionally modify boundings of 
     * 
     * @param ezcGraphBoundings $boundings Current boundings of chart
     * @param ezcGraphCoordinate $direction Direction of the current axis
     * @return ezcGraphBoundings Modified boundings
     */
    public function modifyChartBoundings( ezcGraphBoundings $boundings, ezcGraphCoordinate $direction )
    {
        return $boundings;
    }
    
    /**
     * Modify chart data position
     *
     * Optionally additionally modify the coodinate of a data point
     * 
     * @param ezcGraphCoordinate $coordinate Data point coordinate
     * @param ezcGraphCoordinate $direction Direction of the current axis
     * @return ezcGraphCoordinate Modified coordinate
     */
    public function modifyChartDataPosition( ezcGraphCoordinate $coordinate, ezcGraphCoordinate $direction )
    {
        return $coordinate;
    }

    /**
     * Render Axis labels
     *
     * Render labels for an axis.
     *
     * @param ezcGraphRenderer $renderer Renderer used to draw the chart
     * @param ezcGraphBoundings $boundings Boundings of the axis
     * @param ezcGraphCoordinate $start Axis starting point
     * @param ezcGraphCoordinate $end Axis ending point
     * @param ezcGraphChartElementAxis $axis Axis instance
     * @return void
     */
    abstract public function renderLabels(
        ezcGraphRenderer $renderer,
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis
    );
}
?>
