<?php
/**
 * File containing the ezcGraphLineChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
 *  $chart = new ezcGraphLineChart();
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
 * @package Graph
 * @mainclass
 */
class ezcGraphLineChart extends ezcGraphChart
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
        $this->options = new ezcGraphLineChartOptions( $options );
        $this->options->highlightFont = $this->options->font;

        parent::__construct();

        $this->addElement( 'xAxis', new ezcGraphChartElementLabeledAxis() );
        $this->elements['xAxis']->position = ezcGraph::LEFT;

        $this->addElement( 'yAxis', new ezcGraphChartElementNumericAxis() );
        $this->elements['yAxis']->position = ezcGraph::BOTTOM;
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
            case 'xAxis':
                if ( $propertyValue instanceof ezcGraphChartElementAxis )
                {
                    $this->addElement( 'xAxis', $propertyValue );
                    $this->elements['xAxis']->position = ezcGraph::LEFT;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphChartElementAxis' );
                }
                break;
            case 'yAxis':
                if ( $propertyValue instanceof ezcGraphChartElementAxis )
                {
                    $this->addElement( 'yAxis', $propertyValue );
                    $this->elements['yAxis']->position = ezcGraph::BOTTOM;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphChartElementAxis' );
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
        $xAxisSpace = ( $boundings->x1 - $boundings->x0 ) * $this->yAxis->axisSpace;
        $yAxisSpace = ( $boundings->y1 - $boundings->y0 ) * $this->xAxis->axisSpace;

        $boundings->x0 += $xAxisSpace;
        $boundings->x1 -= $xAxisSpace;

        $boundings->y0 += $yAxisSpace;
        $boundings->y1 -= $yAxisSpace;

        $yAxisNullPosition = $this->elements['yAxis']->getCoordinate( false );

        // Initialize counters
        $nr = array();
        $count = array();

        foreach ( $this->data as $data )
        {
            if ( !isset( $nr[$data->displayType->default] ) )
            {
                $nr[$data->displayType->default] = 0;
                $count[$data->displayType->default] = 0;
            }

            $nr[$data->displayType->default]++;
            $count[$data->displayType->default]++;
        }

        // Display data
        foreach ( $this->data as $datasetName => $data )
        {
            --$nr[$data->displayType->default];
            switch ( $data->displayType->default )
            {
                case ezcGraph::LINE:
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
                        $point = $this->elements['xAxis']->axisLabelRenderer->modifyChartDataPosition( 
                            $this->elements['yAxis']->axisLabelRenderer->modifyChartDataPosition(
                                new ezcGraphCoordinate( 
                                    $this->elements['xAxis']->getCoordinate( $key ),
                                    $this->elements['yAxis']->getCoordinate( $value )
                                )
                            )
                        );

                        $renderer->drawDataLine(
                            $boundings,
                            new ezcGraphContext( $datasetName, $key ),
                            $data->color->default,
                            ( $lastPoint === false ? $point : $lastPoint ),
                            $point,
                            $nr[$data->displayType->default],
                            $count[$data->displayType->default],
                            $data->symbol[$key],
                            $data->color[$key],
                            $fillColor,
                            $yAxisNullPosition
                        );

                        if ( $data->highlight[$key] )
                        {
                            $renderer->drawDataHighlightText(
                                $boundings,
                                new ezcGraphContext( $datasetName, $key ),
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
                    break;
                case ezcGraph::BAR:
                    $width = $this->elements['xAxis']->axisLabelRenderer->modifyChartDataPosition( 
                        $this->elements['yAxis']->axisLabelRenderer->modifyChartDataPosition(
                            new ezcGraphCoordinate(
                                ( $boundings->x1 - $boundings->x0 ) / $this->elements['xAxis']->getMajorStepCount(), 
                                0 
                            )
                        )
                    )->x;

                    foreach ( $data as $key => $value )
                    {
                        $point = new ezcGraphCoordinate( 
                            $this->elements['xAxis']->getCoordinate( $key ),
                            $this->elements['yAxis']->getCoordinate( $value )
                        );

                        $renderer->drawBar(
                            $boundings,
                            new ezcGraphContext( $datasetName, $key ),
                            $data->color->default,
                            $point = $this->elements['xAxis']->axisLabelRenderer->modifyChartDataPosition( 
                                $this->elements['yAxis']->axisLabelRenderer->modifyChartDataPosition(
                                    $point
                                )
                            ),
                            $width,
                            $nr[$data->displayType->default],
                            $count[$data->displayType->default],
                            $data->symbol[$key],
                            $yAxisNullPosition
                        );

                        if ( $data->highlight[$key] )
                        {
                            $renderer->drawDataHighlightText(
                                $boundings,
                                new ezcGraphContext( $datasetName, $key ),
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
                    }
                    break;
                default:
                    throw new ezcGraphInvalidDisplayTypeException( $data->displayType->default );
                    break;
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

            $this->elements['xAxis']->addData( $labels );
            $this->elements['yAxis']->addData( $values );
        }

        $this->elements['xAxis']->calculateAxisBoundings();
        $this->elements['yAxis']->calculateAxisBoundings();

        // Generate legend
        $this->elements['legend']->generateFromDataSets( $this->data );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        // Render subelements
        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        $boundings = $this->elements['xAxis']->axisLabelRenderer->modifyChartBoundings( 
            $this->elements['yAxis']->axisLabelRenderer->modifyChartBoundings(
                $boundings, new ezcGraphCoordinate( 1, 0 )
            ), new ezcGraphCoordinate( -1, 0 )
        );

        // Render subelements
        foreach ( $this->elements as $name => $element )
        {
            // Skip element, if it should not get rendered
            if ( $this->renderElement[$name] === false )
            {
                continue;
            }

            // Special settings for special elements
            switch ( $name )
            {
                case 'xAxis':
                    // get Position of 0 on the Y-axis for orientation of the x-axis
                    $element->nullPosition = $this->elements['yAxis']->getCoordinate( false );
                    break;
                case 'yAxis':
                    // get Position of 0 on the X-axis for orientation of the y-axis
                    $element->nullPosition = $this->elements['xAxis']->getCoordinate( false );
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
