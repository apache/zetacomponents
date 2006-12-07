<?php
/**
 * File containing the ezcGraphBarChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class for bar charts. Can make use of an unlimited amount of datasets and 
 * will display them as bars by default.
 * X axis:
 *  - Labeled axis
 *  - Boxed axis label renderer
 * Y axis:
 *  - Numeric axis
 *  - Exact axis label renderer
 *
 * <code>
 *  // Create a new line chart
 *  $chart = new ezcGraphBarChart();
 *
 *  // Add data to line chart
 *  $chart->data['sample dataset'] = new ezcGraphArrayDataSet(
 *      array(
 *          '100' => 1.2,
 *          '200' => 43.2,
 *          '300' => -34.14,
 *          '350' => 65,
 *          '400' => 123,
 *      )   
 *  );
 *
 *  // Render chart with default 2d renderer and default SVG driver
 *  $chart->render( 500, 200, 'bar_chart.svg' );
 * </code>
 *
 * @package Graph
 * @mainclass
 */
class ezcGraphBarChart extends ezcGraphLineChart
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
