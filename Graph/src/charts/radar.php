<?php
/**
 * File containing the ezcGraphRadarChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Class for line charts. Can make use of an unlimited amount of datasets and 
 * will display them as lines by default.
 * X axis:
 *  - Labeled axis
 *  - Centered axis label renderer
 * Y axis:
 *  - Numeric axis
 *  - Exact axis label renderer
 *
 * <code>
 *  // Create a new line chart
 *  $chart = new ezcGraphRadarChart();
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
 *  $chart->render( 500, 200, 'line_chart.svg' );
 * </code>
 *
 * Each chart consists of several chart elements which represents logical 
 * parts of the chart and can be formatted independently. The line chart
 * consists of:
 *  - title ( ezcGraphChartElementText )
 *  - legend ( ezcGraphChartElementLegend )
 *  - background ( ezcGraphChartElementBackground )
 *  - axis ( ezcGraphChartElementNumericAxis )
 *
 * The type of the axis may be changed and all elements can be configured by
 * accessing them as properties of the chart:
 *
 * <code>
 *  $chart->legend->position = ezcGraph::RIGHT;
 * </code>
 *
 * @package Graph
 * @access private
 * @mainclass
 */
class ezcGraphRadarChart extends ezcGraphChart
{
    /**
     * Virtual not drawn axis for label calculation
     * @TODO: Do we want to expose this axis to the user?
     * 
     * @var ezcGraphChartElementLabeledAxis
     */
    protected $virtualYAxis;
 
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphRadarChartOptions( $options );
        $this->options->highlightFont = $this->options->font;

        parent::__construct();

        $this->virtualYAxis = new ezcGraphChartElementLabeledAxis();

        $this->addElement( 'axis', new ezcGraphChartElementNumericAxis() );
        $this->elements['axis']->position = ezcGraph::BOTTOM;
        $this->elements['axis']->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $this->elements['axis']->axisLabelRenderer->outerStep = true;

        // Do not render axis with default method, because we need an axis for
        // each label in dataset
        $this->renderElement['axis'] = false;
    }

    /**
     * Options write access
     * 
     * @throws ezcBasePropertyNotFoundException
     *          If Option could not be found
     * @throws ezcBaseValueException
     *          If value is out of range
     * @param mixed $propertyName   Option name
     * @param mixed $propertyValue  Option value;
     * @return mixed
     * @ignore
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'axis':
                if ( $propertyValue instanceof ezcGraphChartElementAxis )
                {
                    $this->addElement( 'axis', $propertyValue );
                    $this->elements['axis']->position = ezcGraph::BOTTOM;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphChartElementAxis' );
                }
                break;
            case 'renderer':
                if ( $propertyValue instanceof ezcGraphRadarRenderer )
                {
                    parent::__set( $propertyName, $propertyValue );
                }
                else 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphRadarRenderer' );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
        }
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
        // Apply axis space
        $xAxisSpace = ( $boundings->x1 - $boundings->x0 ) * $this->axis->axisSpace;
        $yAxisSpace = ( $boundings->y1 - $boundings->y0 ) * $this->axis->axisSpace;

        $center = new ezcGraphCoordinate(
            ( $boundings->width / 2 ),
            ( $boundings->height / 2 )
        );

        // We do not differentiate between display types in radar charts.
        $nr = $count = count( $this->data );

        // Draw axis at major steps of virtual axis
        $steps = $this->virtualYAxis->getSteps();
        foreach ( $steps as $step )
        {
            if ( $step->isLast )
            {
                // Skip last axis
                continue;
            }

            // Set axis position depending on angle for better label positioning
            $angle = $step->position * 2 * M_PI;
            switch ( (int) ( ( $step->position + .125 ) * 4 ) )
            {
                case 0:
                case 4:
                    $this->elements['axis']->position = ezcGraph::BOTTOM;
                    break;
                case 1:
                    $this->elements['axis']->position = ezcGraph::LEFT;
                    break;
                case 2:
                    $this->elements['axis']->position = ezcGraph::TOP;
                    break;
                case 3:
                    $this->elements['axis']->position = ezcGraph::RIGHT;
                    break;
            }

            $this->elements['axis']->label = $step->label;
            $this->elements['axis']->axisLabelRenderer->showLabels = $step->isZero;

            $this->renderer->drawAxis(
                $boundings,
                clone $center,
                $dest = new ezcGraphCoordinate(
                    $center->x + sin( $angle ) * ( $boundings->width / 2 ),
                    $center->y - cos( $angle ) * ( $boundings->height / 2 )
                ),
                clone $this->elements['axis'],
                clone $this->elements['axis']->axisLabelRenderer
            );
        }

        // Display data
        $this->elements['axis']->position = ezcGraph::TOP;
        foreach ( $this->data as $datasetName => $data )
        {
            --$nr;
            // Determine fill color for dataset
            if ( $this->options->fillLines !== false )
            {
                $fillColor = clone $data->color->default;
                $fillColor->alpha = (int) round( ( 255 - $fillColor->alpha ) * ( $this->options->fillLines / 255 ) );
            }
            else
            {
                $fillColor = null;
            }

            // Draw lines for dataset
            $lastPoint = false;
            foreach ( $data as $key => $value )
            {
                $point = new ezcGraphCoordinate( 
                    $this->virtualYAxis->getCoordinate( $key ),
                    $this->elements['axis']->getCoordinate( $value )
                ); 

                /* Transformation required for 3d like renderers ... 
                 * which axis should transform here?
                $point = $this->elements['xAxis']->axisLabelRenderer->modifyChartDataPosition( 
                    $this->elements['yAxis']->axisLabelRenderer->modifyChartDataPosition(
                        new ezcGraphCoordinate( 
                            $this->elements['xAxis']->getCoordinate( $key ),
                            $this->elements['yAxis']->getCoordinate( $value )
                        )
                    )
                ); 
                // */

                $renderer->drawRadarDataLine(
                    $boundings,
                    new ezcGraphContext( $datasetName, $key, $data->url[$key] ),
                    $data->color->default,
                    clone $center,
                    ( $lastPoint === false ? $point : $lastPoint ),
                    $point,
                    $nr,
                    $count,
                    $data->symbol[$key],
                    $data->color[$key],
                    $fillColor,
                    $this->options->lineThickness
                );

                if ( $data->highlight[$key] )
                {
                    $renderer->drawDataHighlightText(
                        $boundings,
                        new ezcGraphContext( $datasetName, $key, $data->url[$key] ),
                        $point,
                        $yAxisNullPosition,
                        $nr[$data->displayType->default],
                        $count[$data->displayType->default],
                        $this->options->highlightFont,
                        $value,
                        $this->options->highlightSize,
                        ( $this->options->highlightLines ? $data->color[$key] : null )
                    );
                }

                $lastPoint = $point;
            }
        }
    }

    /**
     * Returns the default display type of the current chart type.
     * 
     * @return int Display type
     */
    public function getDefaultDisplayType()
    {
        return ezcGraph::LINE;
    }

    protected function renderElements( $width, $height )
    {
        if ( !count( $this->data ) )
        {
            throw new ezcGraphNoDataException();
        }

        // Set image properties in driver
        $this->driver->options->width = $width;
        $this->driver->options->height = $height;

        // Calculate axis scaling and labeling
        foreach ( $this->data as $dataset )
        {
            $labels = array();
            $values = array();
            foreach ( $dataset as $label => $value )
            {
                $labels[] = $label;
                $values[] = $value;
            }

            $this->elements['axis']->addData( $values );
            $this->virtualYAxis->labelCount = count( $labels );
            $this->virtualYAxis->addData( $labels );
        }

        $this->elements['axis']->calculateAxisBoundings();
        $this->virtualYAxis->calculateAxisBoundings();

        // Generate legend
        $this->elements['legend']->generateFromDataSets( $this->data );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        // Render subelements
        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        /*
        // This is obsolete ...
        // Should be replaced by radial size reducement based on axis Space
        $boundings = $this->elements['xAxis']->axisLabelRenderer->modifyChartBoundings( 
            $this->elements['yAxis']->axisLabelRenderer->modifyChartBoundings(
                $boundings, new ezcGraphCoordinate( 1, 0 )
            ), new ezcGraphCoordinate( -1, 0 )
        );
        */

        // Render subelements
        foreach ( $this->elements as $name => $element )
        {
            // Skip element, if it should not get rendered
            if ( $this->renderElement[$name] === false )
            {
                continue;
            }

            $this->driver->options->font = $element->font;
            $boundings = $element->render( $this->renderer, $boundings );
        }

        // Render graph
        $this->renderData( $this->renderer, $boundings );
    }

    /**
     * Render the line chart
     *
     * Renders the chart into a file or stream. The width and height are 
     * needed to specify the dimensions of the resulting image. For direct
     * output use 'php://stdout' as output file.
     * 
     * @param int $width Image width
     * @param int $height Image height
     * @param string $file Output file
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
     * @return void
     */
    public function renderToOutput( $widht, $height )
    {
        // @TODO: merge this function with render an deprecate ommit of third 
        // argument in render() when API break is possible
        $this->renderElements( $widht, $height );
        $this->renderer->render( null );
    }
}
?>
