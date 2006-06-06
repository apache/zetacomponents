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

        $this->addElement( 'X_axis', new ezcGraphChartElementLabeledAxis() );
        $this->elements['X_axis']->position = ezcGraph::LEFT;

        $this->addElement( 'Y_axis', new ezcGraphChartElementNumericAxis() );
        $this->elements['Y_axis']->position = ezcGraph::BOTTOM;
    }

    protected function renderData( $renderer, $boundings )
    {
        foreach ( $this->data as $data )
        {
            $lastPoint = false;
            foreach ( $data as $key => $value )
            {
                $point = new ezcGraphCoordinate( 
                    (int) round( $this->elements['X_axis']->getCoordinate( $boundings, $key ) ),
                    (int) round( $this->elements['Y_axis']->getCoordinate( $boundings, $value ) )
                );

                // Draw line
                if ( $lastPoint !== false )
                {
                    $renderer->drawLine(
                        $data->color->default,
                        $lastPoint,
                        $point,
                        true
                    );
                }

                // Draw Symbol
                $symbol = $data->symbol[$key];
                // @TODO: Make config option
                $symbolSize = 8;
                $symbolPosition = new ezcGraphCoordinate( 
                    $point->x - $symbolSize / 2,
                    $point->y - $symbolSize / 2
                );

                if ( $symbol != ezcGraph::NO_SYMBOL )
                {
                    $renderer->drawSymbol(
                        $data->color[$key],
                        $symbolPosition,
                        $symbolSize,
                        $symbolSize,
                        $symbol
                    );
                }

                $lastPoint = $point;
            }
        }
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
        // Set image properties in driver
        $this->driver->options->width = $width;
        $this->driver->options->height = $height;

        // Calculate axis scaling and labeling
        $this->elements['X_axis']->calculateFromDataset( $this->data );
        $this->elements['X_axis']->font = $this->options->font;
        $this->elements['Y_axis']->calculateFromDataset( $this->data );
        $this->elements['Y_axis']->font = $this->options->font;

        // Generate legend
        $this->elements['legend']->generateFromDatasets( $this->data );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        // Render subelements
        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        // Render border and background
        $boundings = $this->renderBorder( $boundings );
        $boundings = $this->renderBackground( $boundings );

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
            $this->driver->options->font = $element->font;
            $boundings = $element->render( $this->renderer, $boundings );
        }

        // Render graph
        $this->renderData( $this->renderer, $boundings );

        if ( !empty( $file ) )
        {
            $this->renderer->render( $file );
        }
    }
}
?>
