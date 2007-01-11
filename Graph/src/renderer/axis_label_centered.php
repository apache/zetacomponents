<?php
/**
 * File containing the ezcGraphAxisCenteredLabelRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Renders axis labels centered below the axis steps.
 *
 * @property bool $showZeroValue
 *           Show the value at the zero point of an axis. This value might be 
 *           crossed by the other axis which would result in an unreadable 
 *           label.
 *
 * @package Graph
 * @mainclass
 */
class ezcGraphAxisCenteredLabelRenderer extends ezcGraphAxisLabelRenderer
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
        $this->properties['showZeroValue'] = false;

        parent::__construct( $options );
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
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'showZeroValue':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'bool' );
                }

                $this->properties['showZeroValue'] = (bool) $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
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
        $this->majorStepCount = $axis->getMajorStepCount();
        $this->minorStepCount = $axis->getMinorStepCount();
        $minorStepsPerMajorStepCount = $this->minorStepCount / $this->majorStepCount - 1;
        
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

        if ( $this->minorStepCount )
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
                $boundings->x0 + $renderer->xAxisSpace,
                $boundings->y0 + $renderer->yAxisSpace,
                $boundings->x1 - $renderer->xAxisSpace,
                $boundings->y1 - $renderer->yAxisSpace
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
            if ( $this->showZeroValue || ! $axis->isZeroStep( $step ) )
            {
                $label = $axis->getLabel( $step );
                switch ( $axis->position )
                {
                    case ezcGraph::TOP:
                    case ezcGraph::BOTTOM:
                        $renderer->drawText(
                            new ezcGraphBoundings(
                                $start->x - $labelWidth + $this->labelPadding,
                                $start->y - $labelHeight / 2 + $this->labelPadding,
                                $start->x - $this->labelPadding,
                                $start->y + $labelHeight / 2 - $this->labelPadding
                            ),
                            $label,
                            ezcGraph::MIDDLE | ezcGraph::RIGHT
                        );
                        break;
                    case ezcGraph::LEFT:
                    case ezcGraph::RIGHT:
                        $renderer->drawText(
                            new ezcGraphBoundings(
                                $start->x - $labelWidth / 2 + $this->labelPadding,
                                $start->y + $this->labelPadding,
                                $start->x + $labelWidth / 2 - $this->labelPadding,
                                $start->y + $labelHeight - $this->labelPadding
                            ),
                            $label,
                            ezcGraph::CENTER | ezcGraph::TOP
                        );
                        break;
                }
            }

            // second iteration for minor steps, if wanted
            $minorStepNmbr = 0;
            if ( $this->minorStepCount &&
                 ( $step < $this->majorStepCount ) )
            {
                $minorGridPosition = new ezcGraphCoordinate(
                    $start->x + $minorStep->x,
                    $start->y + $minorStep->y
                );

                while ( $minorStepNmbr++ < $minorStepsPerMajorStepCount )
                {
                    // minor grid
                    if ( $axis->minorGrid )
                    {
                        $this->drawGrid( $renderer, $gridBoundings, $minorGridPosition, $majorStep, $axis->minorGrid );
                    }

                    // minor step
                    $this->drawStep( $renderer, $minorGridPosition, $direction, $axis->position, $this->minorStepSize, $axis->border );

                    $minorGridPosition->x += $minorStep->x;
                    $minorGridPosition->y += $minorStep->y;
                }
            }

            $start->x += $majorStep->x;
            $start->y += $majorStep->y;
            ++$step;
        }
    }
}
?>
