<?php
/**
 * File containing the abstract ezcGraphLineChart class
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
class ezcGraphLineChart extends ezcGraphChart
{
 
    public function __construct()
    {
        parent::__construct();

        $this->elements['X_axis'] = new ezcGraphChartElementLabeledAxis();
        $this->elements['Y_axis'] = new ezcGraphChartElementNumericAxis();
    }

    /**
     * Render a line chart
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render()
    {
        // Calculate axis scaling and labeling
        $this->elements['X_axis']->calculateFromDataset( $this->data );
        $this->elements['Y_axis']->calculateFromDataset( $this->data );

        // Generate legend
        $this->elements['legend']->generateFromDatasets( $this->data );
    }
}
?>
