<?php
/**
 * File containing the ezcGraphAxisBoxedLabelRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005,
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Renders axis labels centered between two axis steps like normally used for 
 * bar charts.
 *
 * @package Graph
 */
class ezcGraphAxisBoxedLabelRenderer extends ezcGraphAxisLabelRenderer
{
    /**
     * Normalized axis direction 
     * 
     * @var ezcGraphCoordinate
     */
    protected $direction;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        parent::__construct( $options );
        $this->properties['outerStep'] = true;
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
    public function renderLabels(
        ezcGraphRenderer $renderer,
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis )
    {
        // receive rendering parameters from axis
        $this->majorStepCount = $axis->getMajorStepCount() + 1;

        // Determine normalized axis direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;
        $this->direction = $direction;
        
        // Calculate stepsizes for mjor and minor steps
        $majorStep = new ezcGraphCoordinate(
            ( $end->x - $start->x ) / $this->majorStepCount,
            ( $end->y - $start->y ) / $this->majorStepCount
        );

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

        // Determine size of labels
        switch ( $axis->position )
        {
            case ezcGraph::RIGHT:
            case ezcGraph::LEFT:
                $labelWidth = min( 
                    abs( $majorStep->x ),
                    ( $boundings->x1 - $boundings->x0 ) * $axis->axisSpace * 2
                );
                $labelHeight = ( $boundings->y1 - $boundings->y0 ) * $axis->axisSpace;
                break;
            case ezcGraph::BOTTOM:
            case ezcGraph::TOP:
                $labelWidth = ( $boundings->x1 - $boundings->x0 ) * $axis->axisSpace;
                $labelHeight = min( 
                    abs( $majorStep->y ),
                    ( $boundings->y1 - $boundings->y0 ) * $axis->axisSpace * 2
                );
                break;
        }

        // Draw steps and grid
        $step = 0;
        while ( $step <= $this->majorStepCount )
        {
            if ( ! $axis->isZeroStep( $step ) )
            {
                // major grid
                if ( $axis->majorGrid )
                {
                    $this->drawGrid( $renderer, $gridBoundings, $start, $majorStep, $axis->majorGrid );
                }
                
                // major step
                $this->drawStep( $renderer, $start, $direction, $axis->position, $this->majorStepSize, $axis->border );
            }

            // draw label
            if ( $step < $this->majorStepCount )
            {
                $label = $axis->getLabel( $step );
                switch ( $axis->position )
                {
                    case ezcGraph::TOP:
                    case ezcGraph::BOTTOM:
                        $renderer->drawText(
                            new ezcGraphBoundings(
                                $start->x - $labelWidth + $this->labelPadding,
                                $start->y + $this->labelPadding,
                                $start->x - $this->labelPadding,
                                $start->y + $labelHeight - $this->labelPadding
                            ),
                            $label,
                            ezcGraph::MIDDLE | ezcGraph::RIGHT
                        );
                        break;
                    case ezcGraph::LEFT:
                    case ezcGraph::RIGHT:
                        $renderer->drawText(
                            new ezcGraphBoundings(
                                $start->x + $this->labelPadding,
                                $start->y + $this->labelPadding,
                                $start->x + $labelWidth - $this->labelPadding,
                                $start->y + $labelHeight - $this->labelPadding
                            ),
                            $label,
                            ezcGraph::CENTER | ezcGraph::TOP
                        );
                        break;
                }
            }

            $start->x += $majorStep->x;
            $start->y += $majorStep->y;
            ++$step;
        }
    }
    
    /**
     * Modify chart data position
     *
     * Optionally additionally modify the coodinate of a data point
     * 
     * @param ezcGraphCoordinate $coordinate Data point coordinate
     * @return ezcGraphCoordinate Modified coordinate
     */
    public function modifyChartDataPosition( ezcGraphCoordinate $coordinate )
    {
        return new ezcGraphCoordinate(
            $coordinate->x * abs( $this->direction->y ) +
            ( $coordinate->x * ( 1 - 1 / $this->majorStepCount ) + ( 1 / $this->majorStepCount / 2 ) ) * abs( $this->direction->x ),
            $coordinate->y * abs( $this->direction->x ) +
            ( $coordinate->y * ( 1 - 1 / $this->majorStepCount ) + ( 1 / $this->majorStepCount / 2 ) ) * abs( $this->direction->y )
        );
    }
}
?>
