<?php
/**
 * File containing the ezcGraphHorizontalBarRenderer interface
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface which adds the methods reqired to render horizontal bar charts to
 * the renderer.
 *
 * @version //autogentag//
 * @package Graph
 */
interface ezcGraphHorizontalBarRenderer
{
    /**
     * Draw horizontal bar
     *
     * Draws a horizontal bar as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphContext $context Context of call
     * @param ezcGraphColor $color Color of line
     * @param ezcGraphCoordinate $position Position of data point
     * @param float $stepSize Space which can be used for bars
     * @param int $dataNumber Number of dataset
     * @param int $dataCount Count of datasets in chart
     * @param int $symbol Symbol to draw for line
     * @param float $axisPosition Position of axis for drawing filled lines
     * @return void
     */
    public function drawHorizontalBar(
        ezcGraphBoundings $boundings,
        ezcGraphContext $context,
        ezcGraphColor $color,
        ezcGraphCoordinate $position,
        $stepSize,
        $dataNumber = 1,
        $dataCount = 1,
        $symbol = ezcGraph::NO_SYMBOL,
        $axisPosition = 0.
    );
}

?>
