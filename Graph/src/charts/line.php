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
        $this->elements['X_axis']->position = ezcGraph::LEFT;
        $this->elements['Y_axis'] = new ezcGraphChartElementNumericAxis();
        $this->elements['Y_axis']->position = ezcGraph::BOTTOM;
    }

    /**
     * Render a line chart
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( $width, $height, $file = null )
    {
        // Calculate axis scaling and labeling
        $this->elements['X_axis']->calculateFromDataset( $this->data );
        $this->elements['Y_axis']->calculateFromDataset( $this->data );

        // Generate legend
        $this->elements['legend']->generateFromDatasets( $this->data );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        // Render subelements
        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        foreach ( $this->elements as $name => $element )
        {
            // Special settings for special elements
            switch ( $name )
            {
                case 'X_axis':
                    // get Position of 0 on the Y-axis for orientation of the x-axis
                    $element->nullPosition = $this->elements['Y_axis']->getCoordinate( $boundings, false );
                    break;
                case 'Y_axis':
                    // get Position of 0 on the X-axis for orientation of the y-axis
                    $element->nullPosition = $this->elements['X_axis']->getCoordinate( $boundings, false );
                    break;
            }
            $boundings = $element->render( $this->renderer, $boundings );
        }

        // Render graph
    }
}
?>
