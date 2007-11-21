<?php
/**
 * File containing the ezcGraphOdometerChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcGraphOdometerChart extends ezcGraphChart
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
        $this->options = new ezcGraphOdometerChartOptions( $options );

        parent::__construct( $options );

        $this->data = new ezcGraphChartSingleDataContainer( $this );

        $this->addElement( 'axis', new ezcGraphChartElementNumericAxis());
        $this->elements['axis']->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $this->elements['axis']->axisLabelRenderer->showZeroValue = true;
        $this->elements['axis']->position  = ezcGraph::LEFT;
        $this->elements['axis']->axisSpace = .05;
    }

    /**
     * Render the assigned data
     *
     * Will renderer all charts data in the remaining boundings after drawing
     * all other chart elements. The data will be rendered depending on the
     * settings in the dataset.
     *
     * @param ezcGraphRenderer $renderer Renderer
     * @param ezcGraphBoundings $boundings Remaining boundings
     * @return void
     */
    protected function renderData( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        // Draw the odometer data
        $dataset = $this->data->rewind();

        foreach ( $dataset as $key => $value )
        {
            $renderer->drawOdometerMarker(
                $boundings,
                $this->elements['axis']->axisLabelRenderer->modifyChartDataPosition(
                    new ezcGraphCoordinate(
                        $this->elements['axis']->getCoordinate( $value ),
                        0
                    )
                ),
                $dataset->symbol[$key],
                $dataset->color[$key],
                $this->options->markerWidth
            );
        }
    }

    /**
     * Returns the default display type of the current chart type.
     *
     * @return int Display type
     */
    public function getDefaultDisplayType()
    {
        return ezcGraph::ODOMETER;
    }

    /**
     * Renders the basic elements of this chart type
     *
     * @param int $width
     * @param int $height
     * @return void
     */
    protected function renderElements( $width, $height )
    {
        if ( !count( $this->data ) )
        {
            throw new ezcGraphNoDataException();
        }

        // Set image properties in driver
        $this->driver->options->width = $width;
        $this->driver->options->height = $height;

        // no legend
        $this->renderElement['legend'] = false;

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        // Get values out the single used dataset to calculate axis boundings
        $values = array();
        foreach( $this->data->rewind() as $value )
        {
            $values[] = $value;
        }

        // Set values for Axis
        $this->elements['axis']->addData( $values );
        $this->elements['axis']->nullPosition = 0.5 + $this->options->odometerHeight / 2;
        $this->elements['axis']->calculateAxisBoundings();

        // Render subelements exept axis, which will be drawn together with the
        // odometer bar
        foreach ( $this->elements as $name => $element )
        {
            // Skip element, if it should not get rendered
            if ( $this->renderElement[$name] === false ||
                 $name === 'axis' )
            {
                continue;
            }

            $this->driver->options->font = $element->font;
            $boundings = $element->render( $this->renderer, $boundings );
        }

        // Draw basic odometer
        $this->driver->options->font = $this->elements['axis']->font;
        $boundings = $this->renderer->drawOdometer( 
            $boundings,
            $this->elements['axis'],
            $this->options
        );

        // Render graph
        $this->renderData( $this->renderer, $boundings );
    }

    /**
     * Render the pie chart
     *
     * Renders the chart into a file or stream. The width and height are
     * needed to specify the dimensions of the resulting image. For direct
     * output use 'php://stdout' as output file.
     *
     * @param int $width Image width
     * @param int $height Image height
     * @param string $file Output file
     * @apichange
     * @return void
     */
    public function render( $width, $height, $file = null )
    {
        $this->renderElements( $width, $height );

        if ( !empty( $file ) )
        {
            $this->renderer->render( $file );
        }

        $this->renderedFile = $file;
    }

    /**
     * Renders this chart to direct output
     *
     * Does the same as ezcGraphChart::render(), but renders directly to
     * output and not into a file.
     *
     * @param int $width
     * @param int $height
     * @apichange
     * @return void
     */
    public function renderToOutput( $width, $height )
    {
        // @TODO: merge this function with render an deprecate ommit of third
        // argument in render() when API break is possible
        $this->renderElements( $width, $height );
        $this->renderer->render( null );
    }
}

?>
