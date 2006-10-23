<?php
/**
 * File containing the two dimensional renderer
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005,
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to transform chart primitives into image primitives 
 *
 * @package Graph
 */
class ezcGraphRenderer2d extends ezcGraphRenderer
{

    /**
     * Pie segment labels divided into two array, containing the labels on the
     * left and right side of the pie chart center.
     * 
     * @var array
     */
    protected $pieSegmentLabels = array(
        0 => array(),
        1 => array(),
    );

    /**
     * Contains the boundings used for pie segments
     * 
     * @var ezcGraphBoundings
     */
    protected $pieSegmentBoundings = false;

    /**
     * Array with symbols for post processing, which ensures, that the symbols
     * are rendered topmost.
     * 
     * @var array
     */
    protected $linePostSymbols = array();

    /**
     * Options 
     * 
     * @var ezcGraphRenderer2dOptions
     */
    protected $options;

    /**
     * Collect axis labels, so that the axis are drawn, when all axis spaces 
     * are known.
     * 
     * @var array
     */
    protected $axisLabels = array();

    /**
     * Collects circle sectors to draw shadow in background of all circle 
     * sectors.
     * 
     * @var array
     */
    protected $circleSectors = array();

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphRenderer2dOptions( $options );
    }

    /**
     * __get 
     * 
     * @param mixed $propertyName 
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return mixed
     * @ignore
     */
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'options':
                return $this->options;
            default:
                return parent::__get( $propertyName );
        }
    }

    /**
     * Draw pie segment
     *
     * Draws a single pie segment
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphContext $context Context of call
     * @param ezcGraphColor $color Color of pie segment
     * @param float $startAngle Start angle
     * @param float $endAngle End angle
     * @param string $label Label of pie segment
     * @param float $moveOut Move out from middle for hilighting
     * @return void
     */
    public function drawPieSegment(
        ezcGraphBoundings $boundings,
        ezcGraphContext $context,
        ezcGraphColor $color,
        $startAngle = .0,
        $endAngle = 360.,
        $label = false,
        $moveOut = false )
    {
        // Calculate position and size of pie
        $center = new ezcGraphCoordinate(
            $boundings->x0 + ( $boundings->width ) / 2,
            $boundings->y0 + ( $boundings->height ) / 2
        );

        // Limit radius to fourth of width and half of height at maximum
        $radius = min(
            ( $boundings->width ) * $this->options->pieHorizontalSize,
            ( $boundings->height ) * $this->options->pieVerticalSize
        );

        // Move pie segment out of the center
        if ( $moveOut )
        {
            $direction = $startAngle + ( $endAngle - $startAngle ) / 2;

            $center = new ezcGraphCoordinate(
                $center->x + $this->options->moveOut * $radius * cos( deg2rad( $direction ) ),
                $center->y + $this->options->moveOut * $radius * sin( deg2rad( $direction ) )
            );
        }

        // Add circle sector to queue
        $this->circleSectors[] = array(
            'center' =>     $center,
            'context' =>    $context,
            'width' =>      $radius * 2 * ( 1 - $this->options->moveOut ),
            'height' =>     $radius * 2 * ( 1 - $this->options->moveOut ),
            'start' =>      $startAngle + $this->options->pieChartOffset,
            'end' =>        $endAngle + $this->options->pieChartOffset,
            'color' =>      $color,
        );

        if ( $label )
        {
            // Determine position of label
            $direction = $startAngle + ( $endAngle - $startAngle ) / 2 + $this->options->pieChartOffset;
            $pieSegmentCenter = new ezcGraphCoordinate(
                $center->x + cos( deg2rad( $direction ) ) * $radius,
                $center->y + sin( deg2rad( $direction ) ) * $radius
            );

            // Split labels up into left an right size and index them on their
            // y position
            $this->pieSegmentLabels[(int) ($pieSegmentCenter->x > $center->x)][$pieSegmentCenter->y] = array(
                new ezcGraphCoordinate(
                    $center->x + cos( deg2rad( $direction ) ) * $radius * 2 / 3,
                    $center->y + sin( deg2rad( $direction ) ) * $radius * 2 / 3
                ),
                $label,
                $context
            );
        }

        if ( !$this->pieSegmentBoundings )
        {
            $this->pieSegmentBoundings = $boundings;
        }
    }

    /**
     * Draws the collected circle sectors
     *
     * All circle sectors are collected and drawn later to be able to render 
     * the shadows of the pie segments in the back of all pie segments.
     * 
     * @return void
     */
    protected function finishCircleSectors()
    {
        // Add circle sector sides to simple z buffer prioriry list
        if ( $this->options->pieChartShadowSize > 0 )
        {
            foreach ( $this->circleSectors as $circleSector )
            {
                $this->driver->drawCircleSector(
                    new ezcGraphCoordinate(
                        $circleSector['center']->x + $this->options->pieChartShadowSize,
                        $circleSector['center']->y + $this->options->pieChartShadowSize
                    ),
                    $circleSector['width'],
                    $circleSector['height'],
                    $circleSector['start'],
                    $circleSector['end'],
                    $this->options->pieChartShadowColor->transparent( $this->options->pieChartShadowTransparency ),
                    true
                );
            }
        }

        foreach ( $this->circleSectors as $circleSector )
        {
            // Draw circle sector
            $this->addElementReference( 
                $circleSector['context'],
                $this->driver->drawCircleSector(
                    $circleSector['center'],
                    $circleSector['width'],
                    $circleSector['height'],
                    $circleSector['start'],
                    $circleSector['end'],
                    $circleSector['color'],
                    true
                )
            );

            $darkenedColor = $circleSector['color']->darken( .5 );
            $this->driver->drawCircleSector(
                $circleSector['center'],
                $circleSector['width'],
                $circleSector['height'],
                $circleSector['start'],
                $circleSector['end'],
                $darkenedColor,
                false
            );

            if ( $this->options->pieChartGleam !== false )
            {
                $gradient = new ezcGraphLinearGradient(
                    $circleSector['center'],
                    new ezcGraphCoordinate(
                        $circleSector['center']->x,
                        $circleSector['center']->y - $circleSector['height'] / 2
                    ),
                    $this->options->pieChartGleamColor->transparent( 1 ),
                    $this->options->pieChartGleamColor->transparent( $this->options->pieChartGleam )
                );

                $this->driver->drawCircleSector(
                    $circleSector['center'],
                    $circleSector['width'] - $this->options->pieChartGleamBorder * 2,
                    $circleSector['height'] - $this->options->pieChartGleamBorder * 2,
                    $circleSector['start'],
                    $circleSector['end'],
                    $gradient,
                    true
                );

                $gradient = new ezcGraphLinearGradient(
                    new ezcGraphCoordinate(
                        $circleSector['center']->x,
                        $circleSector['center']->y + $circleSector['height'] / 4
                    ),
                    new ezcGraphCoordinate(
                        $circleSector['center']->x,
                        $circleSector['center']->y + $circleSector['height'] / 2
                    ),
                    $this->options->pieChartGleamColor->transparent( 1 ),
                    $this->options->pieChartGleamColor->transparent( $this->options->pieChartGleam )
                );

                $this->driver->drawCircleSector(
                    $circleSector['center'],
                    $circleSector['width'] - $this->options->pieChartGleamBorder * 2,
                    $circleSector['height'] - $this->options->pieChartGleamBorder * 2,
                    $circleSector['start'],
                    $circleSector['end'],
                    $gradient,
                    true
                );
            }
        }
    }

    /**
     * Draws the collected pie segment labels
     *
     * All labels are collected and drawn later to be able to partition the 
     * available space for the labels woth knowledge of the overall label 
     * count and their required size and optimal position.
     * 
     * @return void
     */
    protected function finishPieSegmentLabels()
    {
        if ( $this->pieSegmentBoundings === false )
        {
            return true;
        }

        $boundings = $this->pieSegmentBoundings;

        // Calculate position and size of pie
        $center = new ezcGraphCoordinate(
            $boundings->x0 + ( $boundings->width ) / 2,
            $boundings->y0 + ( $boundings->height ) / 2
        );

        // Limit radius to fourth of width and half of height at maximum
        $radius = min(
            ( $boundings->width ) * $this->options->pieHorizontalSize,
            ( $boundings->height ) * $this->options->pieVerticalSize
        );

        $pieChartHeight = min(
            $radius * 2 + $radius / max( 1, count ( $this->pieSegmentLabels[0] ), count( $this->pieSegmentLabels[1] ) ) * 4,
            $boundings->height
        );
        $pieChartYPosition = $boundings->y0 + ( ( $boundings->height ) - $pieChartHeight ) / 2;

        // Calculate maximum height of labels
        $labelHeight = min(
            ( count( $this->pieSegmentLabels[0] )
                ? $pieChartHeight / count( $this->pieSegmentLabels[0] )
                : $pieChartHeight
            ),
            ( count( $this->pieSegmentLabels[1] )
                ? $pieChartHeight / count( $this->pieSegmentLabels[1] )
                : $pieChartHeight
            ),
            ( $pieChartHeight ) * $this->options->maxLabelHeight
        );

        $symbolSize = $this->options->symbolSize;

        foreach ( $this->pieSegmentLabels as $side => $labelPart )
        {
            $minHeight = $pieChartYPosition;
            $toShare = $pieChartHeight - count( $labelPart ) * $labelHeight;

            // Sort to draw topmost label first
            ksort( $labelPart );
            $sign = ( $side ? -1 : 1 );

            foreach ( $labelPart as $height => $label )
            {
                if ( ( $height - $labelHeight / 2 ) > $minHeight )
                {
                    $share = min( $toShare, ( $height - $labelHeight / 2) - $minHeight );
                    $minHeight += $share;
                    $toShare -= $share;
                }

                // Determine position of label
                $minHeight += max( 0, $height - $minHeight - $labelHeight ) / $pieChartHeight * $toShare;
                $verticalDistance = ( $center->y - $minHeight - $labelHeight / 2 ) / $radius;

                $labelPosition = new ezcGraphCoordinate(
                    $center->x - 
                    $sign * (
                        abs( $verticalDistance ) > 1
                        // If vertical distance to center is greater then the
                        // radius, use the centerline for the horizontal 
                        // position
                        ? max (
                            5,
                            abs( $label[0]->x - $center->x )
                        )
                        // Else place the label outside of the pie chart
                        : ( cos ( asin ( $verticalDistance ) ) * $radius + 
                            $symbolSize * (int) $this->options->showSymbol 
                        )
                    ),
                    $minHeight + $labelHeight / 2
                );

                if ( $this->options->showSymbol )
                {
                    // Draw label
                    $this->driver->drawLine(
                        $label[0],
                        $labelPosition,
                        $this->options->pieChartSymbolColor,
                        1
                    );

                    $this->driver->drawCircle(
                        $label[0],
                        $symbolSize,
                        $symbolSize,
                        $this->options->pieChartSymbolColor,
                        true
                    );
                    $this->driver->drawCircle(
                        $labelPosition,
                        $symbolSize,
                        $symbolSize,
                        $this->options->pieChartSymbolColor,
                        true
                    );
                }

                $this->addElementReference( 
                    $label[2],
                    $this->driver->drawTextBox(
                        $label[1],
                        new ezcGraphCoordinate(
                            ( !$side ? $boundings->x0 : $labelPosition->x + $symbolSize ),
                            $minHeight
                        ),
                        ( !$side ? $labelPosition->x - $boundings->x0 - $symbolSize : $boundings->x1 - $labelPosition->x - $symbolSize ),
                        $labelHeight,
                        ( !$side ? ezcGraph::RIGHT : ezcGraph::LEFT ) | ezcGraph::MIDDLE
                    )
                );

                // Add used space to minHeight
                $minHeight += $labelHeight;
            }
        }
    }

    /**
     * Draw the collected line symbols
     *
     * Symbols for the data lines are collected and delayed to ensure that 
     * they are not covered and hidden by other data lines.
     * 
     * @return void
     */
    protected function finishLineSymbols()
    {
        foreach ( $this->linePostSymbols as $symbol )
        {
            $this->addElementReference(
                $symbol['context'],
                $this->drawSymbol(
                    $symbol['boundings'],
                    $symbol['color'],
                    $symbol['symbol']
                )
            );
        }
    }
    
    /**
     * Draw bar
     *
     * Draws a bar as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphContext $context Context of call
     * @param ezcGraphColor $color Color of line
     * @param ezcGraphCoordinate $position Position of data point
     * @param float $stepSize Space which can be used for bars
     * @param int $dataNumber Number of dataset
     * @param int $dataCount Count of datasets in chart
     * @param int $symbol Symbol to draw for line
     * @param float $axisPosition Position of axis for drawing filled lines
     * @return void
     */
    public function drawBar(
        ezcGraphBoundings $boundings,
        ezcGraphContext $context,
        ezcGraphColor $color,
        ezcGraphCoordinate $position,
        $stepSize,
        $dataNumber = 1,
        $dataCount = 1,
        $symbol = ezcGraph::NO_SYMBOL,
        $axisPosition = 0. )
    {
        // Apply margin
        $margin = $stepSize * $this->options->barMargin;
        $padding = $stepSize * $this->options->barPadding;
        $barWidth = ( $stepSize - $margin ) / $dataCount - $padding;
        $offset = - $stepSize / 2 + $margin / 2 + ( $dataCount - $dataNumber -1 ) * ( $padding + $barWidth ) + $padding / 2;

        $barPointArray = array(
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $position->x + $offset,
                $boundings->y0 + ( $boundings->height ) * $axisPosition
            ),
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $position->x + $offset,
                $boundings->y0 + ( $boundings->height ) * $position->y
            ),
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $position->x + $offset + $barWidth,
                $boundings->y0 + ( $boundings->height ) * $position->y
            ),
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $position->x + $offset + $barWidth,
                $boundings->y0 + ( $boundings->height ) * $axisPosition
            ),
        );

        $this->addElementReference(
            $context,
            $this->driver->drawPolygon(
                $barPointArray,
                $color,
                true
            )
        );

        if ( $this->options->dataBorder > 0 )
        {
            $darkened = $color->darken( $this->options->dataBorder );
            $this->driver->drawPolygon(
                $barPointArray,
                $darkened,
                false,
                1
            );
        }
    }
    
    /**
     * Draw data line
     *
     * Draws a line as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphContext $context Context of call
     * @param ezcGraphColor $color Color of line
     * @param ezcGraphCoordinate $start Starting point
     * @param ezcGraphCoordinate $end Ending point
     * @param int $dataNumber Number of dataset
     * @param int $dataCount Count of datasets in chart
     * @param int $symbol Symbol to draw for line
     * @param ezcGraphColor $symbolColor Color of the symbol, defaults to linecolor
     * @param ezcGraphColor $fillColor Color to fill line with
     * @param float $axisPosition Position of axis for drawing filled lines
     * @param float $thickness Line thickness
     * @return void
     */
    public function drawDataLine(
        ezcGraphBoundings $boundings,
        ezcGraphContext $context,
        ezcGraphColor $color,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        $dataNumber = 1,
        $dataCount = 1,
        $symbol = ezcGraph::NO_SYMBOL,
        ezcGraphColor $symbolColor = null,
        ezcGraphColor $fillColor = null,
        $axisPosition = 0.,
        $thickness = 1)
    {
        // Perhaps fill up line
        if ( $fillColor !== null &&
             $start->x != $end->x )
        {
            $startValue = $axisPosition - $start->y;
            $endValue = $axisPosition - $end->y;

            if ( ( $startValue == 0 ) ||
                 ( $endValue == 0 ) ||
                 ( $startValue / abs( $startValue ) == $endValue / abs( $endValue ) ) )
            {
                // Values have the same sign or are on the axis
                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $start->x,
                            $boundings->y0 + ( $boundings->height ) * $start->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $end->x,
                            $boundings->y0 + ( $boundings->height ) * $end->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $end->x,
                            $boundings->y0 + ( $boundings->height ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $start->x,
                            $boundings->y0 + ( $boundings->height ) * $axisPosition
                        ),
                    ),
                    $fillColor,
                    true
                );
            }
            else
            {
                // values are on differente sides of the axis - split the filled polygon
                $startDiff = abs( $axisPosition - $start->y );
                $endDiff = abs( $axisPosition - $end->y );

                $cuttingPosition = $startDiff / ( $endDiff + $startDiff );
                $cuttingPoint = new ezcGraphCoordinate(
                    $start->x + ( $end->x - $start->x ) * $cuttingPosition,
                    $axisPosition
                );

                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $start->x,
                            $boundings->y0 + ( $boundings->height ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $start->x,
                            $boundings->y0 + ( $boundings->height ) * $start->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $cuttingPoint->x,
                            $boundings->y0 + ( $boundings->height ) * $cuttingPoint->y
                        ),
                    ),
                    $fillColor,
                    true
                );

                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $end->x,
                            $boundings->y0 + ( $boundings->height ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $end->x,
                            $boundings->y0 + ( $boundings->height ) * $end->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->width ) * $cuttingPoint->x,
                            $boundings->y0 + ( $boundings->height ) * $cuttingPoint->y
                        ),
                    ),
                    $fillColor,
                    true
                );
            }
        }

        // Draw line
        $this->driver->drawLine(
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $start->x,
                $boundings->y0 + ( $boundings->height ) * $start->y
            ),
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->width ) * $end->x,
                $boundings->y0 + ( $boundings->height ) * $end->y
            ),
            $color,
            $thickness
        );

        // Draw line symbol
        if ( $symbol !== ezcGraph::NO_SYMBOL )
        {
            if ( $symbolColor === null )
            {
                $symbolColor = $color;
            }
    
            $this->linePostSymbols[] = array(
                'boundings' => new ezcGraphBoundings(
                    $boundings->x0 + ( $boundings->width ) * $end->x - $this->options->symbolSize / 2,
                    $boundings->y0 + ( $boundings->height ) * $end->y - $this->options->symbolSize / 2,
                    $boundings->x0 + ( $boundings->width ) * $end->x + $this->options->symbolSize / 2,
                    $boundings->y0 + ( $boundings->height ) * $end->y + $this->options->symbolSize / 2
                ),
                'color' => $symbolColor,
                'context' => $context,
                'symbol' => $symbol,
            );
        }
    }
    
    /**
     * Draws a highlight textbox for a datapoint.
     *
     * A highlight textbox for line and bar charts means a box with the current 
     * value in the graph.
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphContext $context Context of call
     * @param ezcGraphCoordinate $end Ending point
     * @param float $axisPosition Position of axis for drawing filled lines
     * @param int $dataNumber Number of dataset
     * @param int $dataCount Count of datasets in chart
     * @param ezcGraphFontOptions $font Font used for highlight string
     * @param string $text Acutual value
     * @param int $size Size of highlight text
     * @return void
     */
    public function drawDataHighlightText(
        ezcGraphBoundings $boundings,
        ezcGraphContext $context,
        ezcGraphCoordinate $end,
        $axisPosition = 0.,
        $dataNumber = 1,
        $dataCount = 1,
        ezcGraphFontOptions $font,
        $text,
        $size,
        ezcGraphColor $markLines = null )
    {
        $this->driver->options->font = $font;
        $width = $boundings->width / $dataCount;
        
        $dataPoint = new ezcGraphCoordinate(
            $boundings->x0 + ( $boundings->width ) * $end->x,
            $boundings->y0 + ( $boundings->height ) * $end->y
        );

        if ( $end->y < $axisPosition )
        {
            $this->driver->drawTextBox(
                $text,
                new ezcGraphCoordinate(
                    $dataPoint->x - $width / 2,
                    $dataPoint->y - $size - $font->padding - $this->options->symbolSize
                ),
                $width,
                $size,
                ezcGraph::CENTER | ezcGraph::BOTTOM
            );
        }
        else
        {
            $this->driver->drawTextBox(
                $text,
                new ezcGraphCoordinate(
                    $dataPoint->x - $width / 2,
                    $dataPoint->y + $font->padding + $this->options->symbolSize
                ),
                $width,
                $size,
                ezcGraph::CENTER | ezcGraph::TOP
            );
        }
    }
    
    /**
     * Draw legend
     *
     * Will draw a legend in the bounding box
     * 
     * @param ezcGraphBoundings $boundings Bounding of legend
     * @param ezcGraphChartElementLegend $labels Legend to draw
     * @param int $type Type of legend: Protrait or landscape
     * @return void
     */
    public function drawLegend(
        ezcGraphBoundings $boundings,
        ezcGraphChartElementLegend $legend,
        $type = ezcGraph::VERTICAL )
    {
        $labels = $legend->labels;
        
        // Calculate boundings of each label
        if ( $type & ezcGraph::VERTICAL )
        {
            $labelWidth = $boundings->width;
            $labelHeight = min( 
                ( $boundings->height ) / count( $labels ) - $legend->spacing, 
                $legend->symbolSize + 2 * $legend->padding
            );
        }
        else
        {
            $labelWidth = ( $boundings->width ) / count( $labels ) - $legend->spacing;
            $labelHeight = min(
                $boundings->height,
                $legend->symbolSize + 2 * $legend->padding
            );
        }

        $symbolSize = $labelHeight - 2 * $legend->padding;

        // Draw all labels
        $labelPosition = new ezcGraphCoordinate( $boundings->x0, $boundings->y0 );
        foreach ( $labels as $label )
        {
            $this->elements['legend'][$label['label']]['symbol'] = $this->drawSymbol(
                new ezcGraphBoundings(
                    $labelPosition->x + $legend->padding,
                    $labelPosition->y + $legend->padding,
                    $labelPosition->x + $legend->padding + $symbolSize,
                    $labelPosition->y + $legend->padding + $symbolSize
                ),
                $label['color'],
                $label['symbol']
            );

            $this->elements['legend'][$label['label']]['text'] = $this->driver->drawTextBox(
                $label['label'],
                new ezcGraphCoordinate(
                    $labelPosition->x + 2 * $legend->padding + $symbolSize,
                    $labelPosition->y + $legend->padding
                ),
                $labelWidth - $symbolSize - 3 * $legend->padding,
                $labelHeight - 2 * $legend->padding,
                ezcGraph::LEFT | ezcGraph::MIDDLE
            );

            $labelPosition->x += ( $type === ezcGraph::VERTICAL ? 0 : $labelWidth + $legend->spacing );
            $labelPosition->y += ( $type === ezcGraph::VERTICAL ? $labelHeight + $legend->spacing : 0 );
        }
    }
    
    /**
     * Draw box
     *
     * Box are wrapping each major chart element and draw border, background
     * and title to each chart element.
     *
     * Optionally a padding and margin for each box can be defined.
     * 
     * @param ezcGraphBoundings $boundings Boundings of the box
     * @param ezcGraphColor $background Background color
     * @param ezcGraphColor $borderColor Border color
     * @param int $borderWidth Border width
     * @param int $margin Margin
     * @param int $padding Padding
     * @param string $title Title of the box
     * @param int $titleSize Size of title in the box
     * @return ezcGraphBoundings Remaining inner boundings
     */
    public function drawBox(
        ezcGraphBoundings $boundings,
        ezcGraphColor $background = null,
        ezcGraphColor $borderColor = null,
        $borderWidth = 0,
        $margin = 0,
        $padding = 0,
        $title = false,
        $titleSize = 16 )
    {
        // Apply margin
        $boundings->x0 += $margin;
        $boundings->y0 += $margin;
        $boundings->x1 -= $margin;
        $boundings->y1 -= $margin;

        if ( ( $borderColor instanceof ezcGraphColor ) &&
             ( $borderWidth > 0 ) )
        {
            // Draw border
            $this->driver->drawPolygon(
                array(
                    new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                    new ezcGraphCoordinate( $boundings->x1, $boundings->y0 ),
                    new ezcGraphCoordinate( $boundings->x1, $boundings->y1 ),
                    new ezcGraphCoordinate( $boundings->x0, $boundings->y1 ),
                ),
                $borderColor,
                false
            );

            // Reduce local boundings by borderWidth
            $boundings->x0 += $borderWidth;
            $boundings->y0 += $borderWidth;
            $boundings->x1 -= $borderWidth;
            $boundings->y1 -= $borderWidth;
        }
        
        if ( $background instanceof ezcGraphColor )
        {
            // Draw box background
            $this->driver->drawPolygon(
                array(
                    new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                    new ezcGraphCoordinate( $boundings->x1, $boundings->y0 ),
                    new ezcGraphCoordinate( $boundings->x1, $boundings->y1 ),
                    new ezcGraphCoordinate( $boundings->x0, $boundings->y1 ),
                ),
                $background,
                true
            );
        }

        // Apply padding
        $boundings->x0 += $padding;
        $boundings->y0 += $padding;
        $boundings->x1 -= $padding;
        $boundings->y1 -= $padding;

        // Add box title
        if ( $title !== false )
        {
            switch ( $this->options->titlePosition )
            {
                case ezcGraph::TOP:
                    $this->driver->drawTextBox(
                        $title,
                        new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                        $boundings->width,
                        $titleSize,
                        $this->options->titleAlignement
                    );

                    $boundings->y0 += $titleSize + $padding;
                    $boundings->y1 -= $titleSize + $padding;
                    break;
                case ezcGraph::BOTTOM:
                    $this->driver->drawTextBox(
                        $title,
                        new ezcGraphCoordinate( $boundings->x0, $boundings->y1 - $titleSize ),
                        $boundings->width,
                        $titleSize,
                        $this->options->titleAlignement
                    );

                    $boundings->y1 -= $titleSize + $padding;
                    break;
            }
        }

        return $boundings;
    }
    
    /**
     * Draw text
     *
     * Draws the provided text in the boundings
     * 
     * @param ezcGraphBoundings $boundings Boundings of text
     * @param string $text Text
     * @param int $align Alignement of text
     * @return void
     */
    public function drawText(
        ezcGraphBoundings $boundings,
        $text,
        $align = ezcGraph::LEFT )
    {
        $this->driver->drawTextBox(
            $text,
            new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
            $boundings->width,
            $boundings->height,
            $align
        );
    }

    /**
     * Draw grid line
     *
     * Draw line for the grid in the chart background
     * 
     * @param ezcGraphCoordinate $start Start point
     * @param ezcGraphCoordinate $end End point
     * @param ezcGraphColor $color Color of the grid line
     * @return void
     */
    public function drawGridLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color )
    {
        $this->driver->drawLine(
            $start,
            $end,
            $color,
            1
        );
    }

    /**
     * Draw step line
     *
     * Draw a step (marker for label position) on a axis.
     * 
     * @param ezcGraphCoordinate $start Start point
     * @param ezcGraphCoordinate $end End point
     * @param ezcGraphColor $color Color of the grid line
     * @return void
     */
    public function drawStepLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color )
    {
        $this->driver->drawLine(
            $start,
            $end,
            $color,
            1
        );
    }
    
    /**
     * Draw axis
     *
     * Draws an axis form the provided start point to the end point. A specific 
     * angle of the axis is not required.
     *
     * For the labeleing of the axis a sorted array with major steps and an 
     * array with minor steps is expected, which are build like this:
     *  array(
     *      array(
     *          'position' => (float),
     *          'label' => (string),
     *      )
     *  )
     * where the label is optional.
     *
     * The label renderer class defines how the labels are rendered. For more
     * documentation on this topic have a look at the basic label renderer 
     * class.
     *
     * Additionally it can be specified if a major and minor grid are rendered 
     * by defining a color for them. Teh axis label is used to add a caption 
     * for the axis.
     * 
     * @param ezcGraphBoundings $boundings Boundings of axis
     * @param ezcGraphCoordinate $start Start point of axis
     * @param ezcGraphCoordinate $end Endpoint of axis
     * @param ezcGraphChartElementAxis $axis Axis to render
     * @param ezcGraphLabelRenderer $labelClass Used label renderer
     * @return void
     */
    public function drawAxis(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis,
        ezcGraphAxisLabelRenderer $labelClass = null )
    {
        // Store axis space for use by label renderer
        switch ( $axis->position )
        {
            case ezcGraph::TOP:
            case ezcGraph::BOTTOM:
                $this->xAxisSpace = ( $boundings->width ) * $axis->axisSpace;
                break;
            case ezcGraph::LEFT:
            case ezcGraph::RIGHT:
                $this->yAxisSpace = ( $boundings->height ) * $axis->axisSpace;
                break;
        }

        // Clone boundings because of internal modifications
        $boundings = clone $boundings;

        $start->x += $boundings->x0;
        $start->y += $boundings->y0;
        $end->x += $boundings->x0;
        $end->y += $boundings->y0;

        // Determine normalized direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;

        // Draw axis
        $this->driver->drawLine(
            $start,
            $end,
            $axis->border,
            1
        );

        // Draw small arrowhead
        $size = min(
            $axis->maxArrowHeadSize,
            abs( ceil( ( ( $end->x - $start->x ) + ( $end->y - $start->y ) ) * $axis->axisSpace / 4 ) )
        );

        $this->driver->drawPolygon(
            array(
                new ezcGraphCoordinate(
                    $end->x,
                    $end->y
                ),
                new ezcGraphCoordinate(
                    $end->x
                        + $direction->y * $size / 2
                        + $direction->x * $size,
                    $end->y
                        + $direction->x * $size / 2
                        + $direction->y * $size
                ),
                new ezcGraphCoordinate(
                    $end->x
                        - $direction->y * $size / 2
                        + $direction->x * $size,
                    $end->y
                        - $direction->x * $size / 2
                        + $direction->y * $size
                ),
            ),
            $axis->border,
            true
        );

        // Draw axis label
        if ( $axis->label !== false )
        {
            $width = $boundings->width;
            switch ( $axis->position )
            {
                case ezcGraph::TOP:
                    $this->driver->drawTextBox(
                        $axis->label,
                        new ezcGraphCoordinate(
                            $end->x + $axis->labelMargin - $width * ( 1 - $axis->axisSpace * 2 ),
                            $end->y - $axis->labelMargin - $axis->labelSize
                        ),
                        $width * ( 1 - $axis->axisSpace * 2 ) - $axis->labelMargin,
                        $axis->labelSize,
                        ezcGraph::TOP | ezcGraph::RIGHT
                    );
                    break;
                case ezcGraph::BOTTOM:
                    $this->driver->drawTextBox(
                        $axis->label,
                        new ezcGraphCoordinate(
                            $end->x + $axis->labelMargin,
                            $end->y + $axis->labelMargin
                        ),
                        $width * ( 1 - $axis->axisSpace * 2 ) - $axis->labelMargin,
                        $axis->labelSize,
                        ezcGraph::TOP | ezcGraph::LEFT
                    );
                    break;
                case ezcGraph::LEFT:
                    $this->driver->drawTextBox(
                        $axis->label,
                        new ezcGraphCoordinate(
                            $end->x - $width,
                            $end->y - $axis->labelSize - $axis->labelMargin
                        ),
                        $width - $axis->labelMargin,
                        $axis->labelSize,
                        ezcGraph::BOTTOM | ezcGraph::RIGHT
                    );
                    break;
                case ezcGraph::RIGHT:
                    $this->driver->drawTextBox(
                        $axis->label,
                        new ezcGraphCoordinate(
                            $end->x,
                            $end->y - $axis->labelSize - $axis->labelMargin
                        ),
                        $width - $axis->labelMargin,
                        $axis->labelSize,
                        ezcGraph::BOTTOM | ezcGraph::LEFT
                    );
                    break;
            }
        }

        // Collect axis labels and draw, when all axisSpaces are collected
        $this->axisLabels[] = array(
            'object' => $labelClass,
            'boundings' => $boundings,
            'start' => clone $start,
            'end' => clone $end,
            'axis' => $axis,
        );

        if ( $this->xAxisSpace && $this->yAxisSpace )
        {
            foreach ( $this->axisLabels as $axisLabel )
            {
                switch ( $axisLabel['axis']->position )
                {
                    case ezcGraph::RIGHT:
                    case ezcGraph::LEFT:
                        $axisLabel['start']->x += $this->xAxisSpace * ( $axisLabel['start'] > $axisLabel['end'] ? -1 : 1 );
                        $axisLabel['end']->x -= $this->xAxisSpace * ( $axisLabel['start'] > $axisLabel['end'] ? -1 : 1 );
                        break;
                    case ezcGraph::TOP:
                    case ezcGraph::BOTTOM:
                        $axisLabel['start']->y += $this->yAxisSpace * ( $axisLabel['start'] > $axisLabel['end'] ? -1 : 1 );
                        $axisLabel['end']->y -= $this->yAxisSpace * ( $axisLabel['start'] > $axisLabel['end'] ? -1 : 1 );
                        break;
                }

                $axisLabel['object']->renderLabels(
                    $this,
                    $axisLabel['boundings'],
                    $axisLabel['start'],
                    $axisLabel['end'],
                    $axisLabel['axis']
                );
            }
        }
    }

    /**
     * Draw background image
     *
     * Draws a background image at the defined position. If repeat is set the
     * background image will be repeated like any texture.
     * 
     * @param ezcGraphBoundings $boundings Boundings for the background image
     * @param string $file Filename of background image
     * @param int $position Position of background image
     * @param int $repeat Type of repetition
     * @return void
     */
    public function drawBackgroundImage(
        ezcGraphBoundings $boundings,
        $file,
        $position = 48, // ezcGraph::CENTER | ezcGraph::MIDDLE
        $repeat = ezcGraph::NO_REPEAT )
    {
        $imageData = getimagesize( $file );
        $imageWidth = $imageData[0];
        $imageHeight = $imageData[1];

        $imageWidth = min( $imageWidth, $boundings->width );
        $imageHeight = min( $imageHeight, $boundings->height );

        $imagePosition = new ezcGraphCoordinate( 
            $boundings->x0, 
            $boundings->y0
        );

        // Determine x position
        switch ( true ) {
            case ( $repeat & ezcGraph::HORIZONTAL ):
                // If is repeated on this axis fall back to position zero
            case ( $position & ezcGraph::LEFT ):
                $imagePosition->x = $boundings->x0;
                break;
            case ( $position & ezcGraph::RIGHT ):
                $imagePosition->x = max( 
                    $boundings->x1 - $imageWidth,
                    $boundings->x0
                );
                break;
            default:
                $imagePosition->x = max(
                    $boundings->x0 + ( $boundings->width - $imageWidth ) / 2,
                    $boundings->x0
                );
                break;
        }

        // Determine y position
        switch ( true ) {
            case ( $repeat & ezcGraph::VERTICAL ):
                // If is repeated on this axis fall back to position zero
            case ( $position & ezcGraph::TOP ):
                $imagePosition->y = $boundings->y0;
                break;
            case ( $position & ezcGraph::BOTTOM ):
                $imagePosition->y = max( 
                    $boundings->y1 - $imageHeight,
                    $boundings->y0
                );
                break;
            default:
                $imagePosition->y = max(
                    $boundings->y0 + ( $boundings->height - $imageHeight ) / 2,
                    $boundings->y0
                );
                break;
        }

        // Texturize backround based on position and repetition
        $position = new ezcGraphCoordinate(
            $imagePosition->x,
            $imagePosition->y
        );
        
        do 
        {
            $position->y = $imagePosition->y;

            do 
            {
                $this->driver->drawImage( 
                    $file, 
                    $position, 
                    $imageWidth, 
                    $imageHeight 
                );

                $position->y += $imageHeight;
            }
            while ( ( $position->y < $boundings->y1 ) &&
                    ( $repeat & ezcGraph::VERTICAL ) );
            
            $position->x += $imageWidth;
        }
        while ( ( $position->x < $boundings->x1 ) &&
                ( $repeat & ezcGraph::HORIZONTAL ) );
    }

    /**
     * Call all postprocessing functions
     * 
     * @return void
     */
    protected function finish()
    {
        $this->finishCircleSectors();
        $this->finishPieSegmentLabels();
        $this->finishLineSymbols();

        return true;
    }
}

?>
