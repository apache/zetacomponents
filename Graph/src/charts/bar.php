<?php
/**
 * File containing the abstract ezcGraphBarChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a line chart.
 *
 * @package Graph
 */
class ezcGraphBarChart extends ezcGraphLineChart
{
 
    public function __construct( array $options = array() )
    {
        parent::__construct();

        $this->elements['xAxis']->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
    }

    /**
     * Returns the default display type of the current chart type.
     * 
     * @return int Display type
     */
    public function getDefaultDisplayType()
    {
        return ezcGraph::BAR;
    }
}
?>
