<?php
/**
 * File containing the ezcGraphOdometerRenderer interface
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface which adds the methods required for rendering radar charts to a
 * renderer
 *
 * @version //autogentag//
 * @package Graph
 */
interface ezcGraphOdometerRenderer
{
    /**
     * Render odometer chart
     * 
     * @param ezcGraphBoundings $boundings 
     * @param ezcGraphOdometerChartOptions $options
     * @return ezcGraphBoundings
     */
    public function drawOdometer( 
        ezcGraphBoundings $boundings, 
        ezcGraphChartElementAxis $axis,
        ezcGraphOdometerChartOptions $options
    );

    /**
     * Draw a single odometer marker.
     *
     * @param ezcGraphBoundings $boundings
     * @param ezcGraphCoordinate $position
     * @param int $symbol
     * @param ezcGraphColor $color
     * @param int $width
     */
    public function drawOdometerMarker(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $position,
        $symbol,
        ezcGraphColor $color,
        $width
    );
}

?>
