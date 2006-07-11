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
abstract class ezcGraphAxisLabelRenderer
{
    /**
     * Render Axis labels
     *
     * Render labels for an axis.
     *
     * @param ezcGraphBoundings $boundings Boundings of the axis
     * @param ezcGraphCoordinate $start Axis starting point
     * @param ezcGraphCoordinate $end Axis ending point
     * @param ezcGraphChartElementAxis $axis Axis instance
     * @return void
     */
    abstract function renderLabels(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis
    );
}
?>
