<?php
/**
 * File containing the abstract ezcGraphChartElementLabeledAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a axe as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementLabeledAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Array with labeles for data 
     * 
     * @var array
     */
    protected $labels = array();

    protected function increaseKeys( $array, $startKey )
    {
        foreach ( $array as $key => $value )
        {
            if ( $key === $startKey )
            {
                // Recursive check, if next key should be increased, too
                if ( isset ( $array[$key + 1] ) )
                {
                    $array = $this->increaseKeys( $array, $key + 1 );
                }

                // Increase key
                $array[$key + 1] = $array[$key];
                unset( $array[$key] );
            }
        }

        return $array;
    }

    /**
     * Get labels from datasets in right order to be rendered later
     *
     * @param array $datasets 
     * @return void
     */
    public function calculateFromDataset(array $datasets)
    {
        foreach ( $datasets as $dataset )
        {
            $position = 0;
            foreach ( $dataset as $label => $value )
            {
                $label = (string) $label;

                if ( !in_array( $label, $this->labels, true ) )
                {
                    if ( isset( $this->labels[$position] ) )
                    {
                        $this->labels = $this->increaseKeys( $this->labels, $position );
                        $this->labels[$position++] = $label;
                    }
                    else
                    {
                        $this->labels[$position++] = $label;
                    }
                }
                else 
                {
                    $position = array_search( $label, $this->labels, true ) + 1;
                }
            }
            ksort( $this->labels );
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param string $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( ezcGraphBoundings $boundings, $value )
    {
        if ( $value === false || 
             $value === null  ||
             ( $key = array_search( $value, $this->labels ) ) === false )
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 );
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 );
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 );
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 );
            }
        }
        else
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) +
                            ( $boundings->y1 - $boundings->y0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) -
                            ( $boundings->y1 - $boundings->y0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) +
                            ( $boundings->x1 - $boundings->x0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) -
                            ( $boundings->x1 - $boundings->x0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
            }
        }
    }

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    protected function getMinorStepCount()
    {
        return 0;
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    protected function getMajorStepCount()
    {
        return count( $this->labels ) - 1;
    }

    /**
     * Draw labels for an axis
     * 
     * @param ezcGraphRenderer $renderer 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphBoundings $boundings 
     * @return void
     */
    protected function drawLabels( ezcGraphRenderer $renderer, ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphBoundings $boundings )
    {
        // Draw major steps
        $steps = $this->getMajorStepCount() + 1;

        // Calculate stepsize
        $xStepsize = ( $end->x - $start->x ) / $steps;
        $yStepsize = ( $end->y - $start->y ) / $steps;

        // Caluclate datafree chart border
        $xBorder = abs ( ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) );
        $yBorder = abs ( ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) );

        for ( $i = 0; $i <= $steps; ++$i )
        {
            $label = $this->getLabel( $i );

            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                    if ( $i === 0 )
                    {
                        $align = ezcGraph::LEFT;
                    }
                    elseif ( $i >= ( $steps - 1 ) )
                    {
                        $align = ezcGraph::RIGHT;
                    }
                    else
                    {
                        $align = ezcGraph::CENTER;
                    }

                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            (int) round( $start->x + $i * $xStepsize + $this->labelPadding ),
                            (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                        ),
                        $label,
                        (int) round( $xStepsize ) - $this->labelPadding,
                        $yBorder - $this->labelPadding,
                        $align | ezcGraph::TOP
                    );
                    break;
                case ezcGraph::RIGHT:
                    if ( $i === 0 )
                    {
                        $align = ezcGraph::RIGHT;
                    }
                    elseif ( $i >= ( $steps - 1 ) )
                    {
                        $align = ezcGraph::LEFT;
                    }
                    else
                    {
                        $align = ezcGraph::CENTER;
                    }

                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            (int) round( $start->x + $i * $xStepsize + $xStepsize ),
                            (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                        ),
                        $label,
                        (int) round( -$xStepsize ) - $this->labelPadding,
                        $yBorder - $this->labelPadding,
                        $align | ezcGraph::TOP
                    );
                    break;
                case ezcGraph::BOTTOM:
                    if ( $i === 0 )
                    {
                        $align = ezcGraph::BOTTOM;
                    }
                    elseif ( $i >= ( $steps - 1 ) )
                    {
                        $align = ezcGraph::TOP;
                    }
                    else
                    {
                        $align = ezcGraph::MIDDLE;
                    }

                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            (int) round( $start->x + $i * $xStepsize - $xBorder ),
                            (int) round( $start->y + $i * $yStepsize + $yStepsize )
                        ),
                        $label,
                        $xBorder - $this->labelPadding,
                        (int) round( -$yStepsize ) - $this->labelPadding,
                        ezcGraph::RIGHT | $align
                    );
                    break;
                case ezcGraph::TOP:
                    if ( $i === 0 )
                    {
                        $align = ezcGraph::TOP;
                    }
                    elseif ( $i >= ( $steps - 1 ) )
                    {
                        $align = ezcGraph::BOTTOM;
                    }
                    else
                    {
                        $align = ezcGraph::MIDDLE;
                    }

                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            (int) round( $start->x + $i * $xStepsize - $xBorder ),
                            (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                        ),
                        $label,
                        $xBorder - $this->labelPadding,
                        (int) round( $yStepsize ) - $this->labelPadding,
                        ezcGraph::RIGHT | $align
                    );
                    break;
            }
        }
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    protected function getLabel( $step )
    {
        if ( isset( $this->labels[$step] ) )
        {
            return $this->labels[$step];
        }
        else
        {
            return false;
        }
    }
}

?>
