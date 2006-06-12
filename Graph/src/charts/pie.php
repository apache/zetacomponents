<?php
/**
 * File containing the abstract ezcGraphPieChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a pie chart.
 *
 * @package Graph
 */
class ezcGraphPieChart extends ezcGraphChart
{
    
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphPieChartOptions( $options );

        parent::__construct( $options );
    }

    /**
     * Adds a dataset to the charts data
     * 
     * @param string $name Name of dataset
     * @param mixed $values Values to create dataset with
     * @throws ezcGraphTooManyDatasetExceptions
     *          If too many datasets are created
     * @return ezcGraphDataset
     */
    protected function addDataSet( $name, $values )
    {
        if ( count( $this->data ) >= 1 &&
             !isset( $this->data[$name] ) )
        {
            throw new ezcGraphTooManyDatasetsExceptions( $name );
        }
        else
        {
            parent::addDataSet( $name, $values );

            // Colorize each data element
            foreach ( $this->data[$name] as $label => $value )
            {
                $this->data[$name]->color[$label] = $this->palette->dataSetColor;
            }
        }
    }

    protected function renderData( $renderer, $boundings )
    {
        // Only draw the first (and only) dataset
        $dataset = reset( $this->data );

        $this->driver->options->font = $this->options->font;

        // Calculate sum of all values to be able to calculate percentage
        $sum = 0;
        foreach ( $dataset as $value )
        {
            $sum += $value;
        }
    
        // Calculate position and size of pie
        $center = new ezcGraphCoordinate(
            (int) round( $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2 ),
            (int) round( $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2 )
        );
        $radius = min(
            $boundings->x1 - $boundings->x0,
            $boundings->y1 - $boundings->y0
        ) / 2;

        // Draw all data
        $angle = 0.;
        $labels = array();
        foreach ( $dataset as $label => $value )
        {
            $renderer->drawPieSegment(
                $dataset->color[$label],
                $center,
                $radius * ( 1 - $this->options->moveOut ),
                $angle,
                $endAngle = $angle + $value / $sum * 360,
                ( $dataset->highlight[$label] ? $radius * $this->options->moveOut : 0 )
            );

            // Determine position of label
            $middle = $angle + ( $endAngle - $angle ) / 2;
            $pieSegmentCenter = new ezcGraphCoordinate(
                (int) round( cos( deg2rad( $middle ) ) * $radius + $center->x ),
                (int) round( sin( deg2rad( $middle ) ) * $radius + $center->y )
            );

            // Split labels up into left an right size and index them on their
            // y position
            $labels[(int) ($pieSegmentCenter->x > $center->x)][$pieSegmentCenter->y] = array(
                new ezcGraphCoordinate(
                    (int) round( cos( deg2rad( $middle ) ) * $radius * 2 / 3 + $center->x ),
                    (int) round( sin( deg2rad( $middle ) ) * $radius * 2 / 3 + $center->y )
                ),
                sprintf( $this->options->label, $label, $value, $value * 100 / $sum )
            );
            $angle = $endAngle;
        }

        $labelHeight = (int) round( min(
            ( $boundings->y1 - $boundings->y0 ) / count( $labels[0] ),
            ( $boundings->y1 - $boundings->y0 ) / count( $labels[1] ),
            ( $boundings->y1 - $boundings->y0 ) * $this->options->maxLabelHeight
        ) );
        
        $symbolSize = $this->options->symbolSize;

        // Finally draw labels
        foreach ( $labels as $side => $labelPart )
        {
            $minHeight = $boundings->y0;
            $toShare = ( $boundings->y1 - $boundings->y0 ) - count( $labelPart ) * $labelHeight;

            // Sort to draw topmost label first
            ksort( $labelPart );
            $sign = ( $side ? -1 : 1 );

            foreach ( $labelPart as $height => $label )
            {
                // Determine position of label
                $minHeight += round( max( 0, $height - $minHeight ) / ( $boundings->y1 - $boundings->y0 ) * $toShare );
                $labelPosition = new ezcGraphCoordinate(
                    (int) round( $center->x - $sign * ( cos ( asin ( ( $center->y - $minHeight - $labelHeight / 2 ) / $radius ) ) * $radius + $symbolSize ) ),
                    (int) round( $minHeight + $labelHeight / 2 )
                );

                // Draw label
                $renderer->drawLine(
                    $this->options->font->color,
                    $label[0],
                    $labelPosition,
                    false
                );

                $renderer->drawSymbol(
                    $this->options->font->color,
                    new ezcGraphCoordinate(
                        $label[0]->x - $symbolSize / 2,
                        $label[0]->y - $symbolSize / 2
                    ),
                    $symbolSize,
                    $symbolSize,
                    ezcGraph::BULLET
                );
                $renderer->drawSymbol(
                    $this->options->font->color,
                    new ezcGraphCoordinate(
                        $labelPosition->x - $symbolSize / 2,
                        $labelPosition->y - $symbolSize / 2
                    ),
                    $symbolSize,
                    $symbolSize,
                    ezcGraph::BULLET
                );

                $renderer->drawTextBox(
                    new ezcGraphCoordinate(
                        ( !$side ? $boundings->x0 : $labelPosition->x + $symbolSize ),
                        $minHeight
                    ),
                    $label[1],
                    (int) round( !$side ? $labelPosition->x - $boundings->x0 - $symbolSize : $boundings->x1 - $labelPosition->x - $symbolSize ),
                    $labelHeight,
                    ( !$side ? ezcGraph::RIGHT : ezcGraph::LEFT ) | ezcGraph::MIDDLE
                );

                // Add used space to minHeight
                $minHeight += $labelHeight;
            }
        }
    }

    /**
     * Render a pie chart
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

        // Generate legend
        $this->elements['legend']->generateFromDataset( reset( $this->data ) );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

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
