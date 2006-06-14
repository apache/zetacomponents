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
 
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphLineChartOptions( $options );

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
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'X_Axis':
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
            case 'Y_Axis':
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

    protected function renderData( $renderer, $boundings )
    {
        foreach ( $this->data as $data )
        {
            if ( $this->options->fillLines !== false )
            {
                $fillColor = clone $data->color->default;
                $fillColor->alpha = (int) round( ( 255 - $fillColor->alpha ) * ( $this->options->fillLines / 255 ) );
            }

            $lastPoint = false;
            $lastKey = false;
            $lastValue = false;
            foreach ( $data as $key => $value )
            {
                $point = new ezcGraphCoordinate( 
                    (int) round( $this->elements['xAxis']->getCoordinate( $boundings, $key ) ),
                    (int) round( $this->elements['yAxis']->getCoordinate( $boundings, $value ) )
                );

                // Fill the line
                if ( $lastPoint !== false && $this->options->fillLines !== false )
                {
                    $axisPosition = (int) round( $this->elements['yAxis']->getCoordinate( $boundings, false ) );

                    $lastAxisPoint = new ezcGraphCoordinate(
                        (int) round( $this->elements['xAxis']->getCoordinate( $boundings, $lastKey ) ),
                        $axisPosition
                    );
                    $axisPoint = new ezcGraphCoordinate(
                        (int) round( $this->elements['xAxis']->getCoordinate( $boundings, $key ) ),
                        $axisPosition
                    );

                    if ( $value / abs( $value ) == $lastValue / abs( $lastValue ) )
                    {
                        // Values have the same sign, so that the line do not cross any axes
                        $renderer->drawPolygon(
                            array(
                                $lastPoint,
                                $point,
                                $axisPoint,
                                $lastAxisPoint,
                            ),
                            $fillColor,
                            true
                        );
                    }
                    else
                    {
                        // Draw two polygones to consider cutting point with axis
                        $diffOne = abs( $axisPosition - $lastPoint->y );
                        $diffTwo = abs( $axisPosition - $point->y );

                        // Switch values, if first is greater then second
                        $cuttingPosition = $diffOne / ( $diffTwo + $diffOne );
                        
                        // Calculate cutting point
                        $cuttingPoint = new ezcGraphCoordinate(
                            (int) round( $lastAxisPoint->x + ( $axisPoint->x - $lastAxisPoint->x ) * $cuttingPosition ),
                            $axisPosition
                        );

                        // Finally draw polygons
                        $renderer->drawPolygon(
                            array(
                                $lastPoint,
                                $cuttingPoint,
                                $lastAxisPoint,
                            ),
                            $fillColor,
                            true
                        );
                        $renderer->drawPolygon(
                            array(
                                $point,
                                $cuttingPoint,
                                $axisPoint,
                            ),
                            $fillColor,
                            true
                        );
                    }
                }

                // Draw line
                if ( $lastPoint !== false )
                {
                    $renderer->drawLine(
                        $data->color->default,
                        $lastPoint,
                        $point,
                        $this->options->lineThickness
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
                $lastValue = $value;
                $lastKey = $key;
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
        $boundings = $this->options->backgroundImage->render( $this->renderer, $boundings );
        $boundings = $this->renderBackground( $boundings );

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
                    $element->nullPosition = $this->elements['yAxis']->getCoordinate( $boundings, false );
                    break;
                case 'yAxis':
                    // get Position of 0 on the X-axis for orientation of the y-axis
                    $element->nullPosition = $this->elements['xAxis']->getCoordinate( $boundings, false );
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
