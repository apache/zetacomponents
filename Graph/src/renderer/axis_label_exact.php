<?php
/**
 * File containing the abstract ezcGraphAxisExactLabelRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005,
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Renders axis labels like known from charts drawn in analysis
 *
 * @package Graph
 */
class ezcGraphAxisExactLabelRenderer extends ezcGraphAxisLabelRenderer
{

    /**
     * Show the last value on the axis, which will be aligned different than
     * all other values, to not interfere with the arrow head of the axis.
     * 
     * @var boolean
     */
    protected $showLastValue = true;

    /**
     * Render Axis labels
     *
     * Render labels for an axis.
     *
     * @param ezcGraphBoundings $boundings Boundings of the axis
     * @param ezcGraphCoordinate $start Axis starting point
     * @param ezcGraphCoordinate $end Axis ending point
     * @param ezcGraphChartElementAxis $axis Axis instance
     * @param int $position Position of axis (left, right, or center)
     * @return void
     */
    public function renderLabels(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis,
        $axisPosition )
    {
        // Determine normalized axis direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;
        
        // Calculate stepsizes for mjor and minor steps
        $majorStep = new ezcGraphCoordinate(
            ( $end->x - $start->x ) / $this->majorStepCount,
            ( $end->y - $start->y ) / $this->majorStepCount
        );

        if ( $this->minorStepCount !== false )
        {
            $minorStep = new ezcGraphCoordinate(
                ( $end->x - $start->x ) / $this->minorStepCount,
                ( $end->y - $start->y ) / $this->minorStepCount
            );
        }

        if ( $this->outerGrid )
        {
            $gridBoundings = $boundings;
        }
        else
        {
            $gridBoundings = new ezcGraphBoundings(
                $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $axis->axisSpace,
                $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) * $axis->axisSpace,
                $boundings->x1 - ( $boundings->x1 - $boundings->x0 ) * $axis->axisSpace,
                $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $axis->axisSpace
            );
        }

        // Draw steps and grid
        while ( $start->x <= $end->x )
        {
            // major step
            $this->drawStep( $start, $direction, $axisPosition, $this->majorStepSize, $axis->border );

            // major grid
            if ( $this->majorGrid )
            {
                $this->drawGrid( $gridBoundings, $start, $majorStep, $axis->majorGrid );
            }

            // second iteration for minor steps, if wanted
            if ( $this->minorStepCount !== false )
            {
                $minorGridPosition = new ezcGraphCoordinate(
                    $start->x + $minorStep->x,
                    $start->y + $minorStep->y
                );

                while ( $minorGridPosition->x < ( $start->x + $majorStep->x ) )
                {
                    // minor step
                    $this->drawStep( $minorGridPosition, $direction, $axisPosition, $this->minorStepSize, $axis->border );

                    // minor grid
                    if ( $this->minorGrid )
                    {
                        $this->drawGrid( $gridBoundings, $minorGridPosition, $majorStep, $axis->minorGrid );
                    }

                    $minorGridPosition->x += $minorStep->x;
                    $minorGridPosition->y += $minorStep->y;
                }
            }

            $start->x += $majorStep->x;
            $start->y += $majorStep->y;
        }
    }
}
?>
