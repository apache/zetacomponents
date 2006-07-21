<?php
/**
 * File containing teh two dimensional renderer
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

    protected $pieSegmentLabels = array(
        0 => array(),
        1 => array(),
    );

    protected $pieSegmentBoundings = false;

    protected $options;

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphRenderer2dOptions( $options );
    }

    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'options':
                return $this->options;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
    }

    /**
     * Draw pie segment
     *
     * Draws a single pie segment
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphColor $color Color of pie segment
     * @param float $startAngle Start angle
     * @param float $endAngle End angle
     * @param string $label Label of pie segment
     * @param float $moveOut Move out from middle for hilighting
     * @return void
     */
    public function drawPieSegment(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        $startAngle = .0,
        $endAngle = 360.,
        $label = false,
        $moveOut = false )
    {
        // Calculate position and size of pie
        $center = new ezcGraphCoordinate(
            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2,
            $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
        );

        // Limit radius to fourth of width and half of height at maximum
        $radius = min(
            ( $boundings->x1 - $boundings->x0 ) / 4,
            ( $boundings->y1 - $boundings->y0 ) / 2
        ) * ( 1 - $this->options->moveOut );

        // Move pie segment out of the center
        if ( $moveOut )
        {
            $direction = $startAngle + ( $endAngle - $startAngle ) / 2;

            $center = new ezcGraphCoordinate(
                $center->x + $this->options->moveOut * $radius * cos( deg2rad( $direction ) ),
                $center->y + $this->options->moveOut * $radius * sin( deg2rad( $direction ) )
            );
        }

        // Draw circle sector
        $this->driver->drawCircleSector(
            $center,
            $radius * 2,
            $radius * 2,
            $startAngle,
            $endAngle,
            $color,
            true
        );

        $darkenedColor = $color->darken( .5 );
        $this->driver->drawCircleSector(
            $center,
            $radius * 2,
            $radius * 2,
            $startAngle,
            $endAngle,
            $darkenedColor,
            false
        );

        if ( $label )
        {
            // Determine position of label
            $middle = $startAngle + ( $endAngle - $startAngle ) / 2;
            $pieSegmentCenter = new ezcGraphCoordinate(
                cos( deg2rad( $middle ) ) * $radius + $center->x,
                sin( deg2rad( $middle ) ) * $radius + $center->y
            );

            // Split labels up into left an right size and index them on their
            // y position
            $this->pieSegmentLabels[(int) ($pieSegmentCenter->x > $center->x)][$pieSegmentCenter->y] = array(
                new ezcGraphCoordinate(
                    cos( deg2rad( $middle ) ) * $radius * 2 / 3 + $center->x,
                    sin( deg2rad( $middle ) ) * $radius * 2 / 3 + $center->y
                ),
                $label
            );
        }

        if ( !$this->pieSegmentBoundings )
        {
            $this->pieSegmentBoundings = $boundings;
        }
    }

    protected function finishPieSegmentLabels()
    {
        if ( $this->pieSegmentBoundings === false )
        {
            return true;
        }

        $boundings = $this->pieSegmentBoundings;

        // Calculate position and size of pie
        $center = new ezcGraphCoordinate(
            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2,
            $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
        );

        // Limit radius to fourth of width and half of height at maximum
        $radius = min(
            ( $boundings->x1 - $boundings->x0 ) / 4,
            ( $boundings->y1 - $boundings->y0 ) / 2
        );

        // Calculate maximum height of labels
        $labelHeight = (int) round( min(
            ( count( $this->pieSegmentLabels[0] )
                ? ( $boundings->y1 - $boundings->y0 ) / count( $this->pieSegmentLabels[0] )
                : ( $boundings->y1 - $boundings->y0 )
            ),
            ( count( $this->pieSegmentLabels[1] )
                ? ( $boundings->y1 - $boundings->y0 ) / count( $this->pieSegmentLabels[1] )
                : ( $boundings->y1 - $boundings->y0 )
            ),
            ( $boundings->y1 - $boundings->y0 ) * $this->options->maxLabelHeight
        ) );

        $symbolSize = $this->options->symbolSize;

        foreach ( $this->pieSegmentLabels as $side => $labelPart )
        {
            $minHeight = $boundings->y0;
            $toShare = ( $boundings->y1 - $boundings->y0 ) - count( $labelPart ) * $labelHeight;

            // Sort to draw topmost label first
            ksort( $labelPart );
            $sign = ( $side ? -1 : 1 );

            foreach ( $labelPart as $height => $label )
            {
                // Determine position of label
                $minHeight += max( 0, $height - $minHeight - $labelHeight ) / ( $boundings->y1 - $boundings->y0 ) * $toShare;
                $labelPosition = new ezcGraphCoordinate(
                    $center->x - 
                    $sign * ( 
                        cos ( asin ( ( $center->y - $minHeight - $labelHeight / 2 ) / $radius ) ) * $radius + 
                        $symbolSize * (int) $this->options->showSymbol 
                    ),
                    $minHeight + $labelHeight / 2
                );

                if ( $this->options->showSymbol )
                {
                    // Draw label
                    $this->driver->drawLine(
                        $label[0],
                        $labelPosition,
                        $this->options->font->color,
                        1
                    );

                    $this->driver->drawCircle(
                        $label[0],
                        $symbolSize,
                        $symbolSize,
                        $this->options->font->color,
                        true
                    );
                    $this->driver->drawCircle(
                        $labelPosition,
                        $symbolSize,
                        $symbolSize,
                        $this->options->font->color,
                        true
                    );
                }

                $this->driver->drawTextBox(
                    $label[1],
                    new ezcGraphCoordinate(
                        ( !$side ? $boundings->x0 : $labelPosition->x + $symbolSize ),
                        $minHeight
                    ),
                    ( !$side ? $labelPosition->x - $boundings->x0 - $symbolSize : $boundings->x1 - $labelPosition->x - $symbolSize ),
                    $labelHeight,
                    ( !$side ? ezcGraph::RIGHT : ezcGraph::LEFT ) | ezcGraph::MIDDLE
                );

                // Add used space to minHeight
                $minHeight += $labelHeight;
            }
        }
    }
    
    /**
     * Draw data line
     *
     * Draws a line as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphColor $color Color of line
     * @param ezcGraphCoordinate $start Starting point
     * @param ezcGraphCoordinate $end Ending point
     * @param int $symbol Symbol to draw for line
     * @param ezcGraphColor $symbolColor Color of the symbol, defaults to linecolor
     * @param ezcGraphColor $fillColor Color to fill line with
     * @param float $axisPosition Position of axis for drawing filled lines
     * @param float $thickness Line thickness
     * @return void
     */
    public function drawDataLine(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        $symbol = ezcGraph::NO_SYMBOL,
        ezcGraphColor $symbolColor = null,
        ezcGraphColor $fillColor = null,
        $axisPosition = 0.,
        $thickness = 1 )
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
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $start->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $start->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $end->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $start->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $axisPosition
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

                $cuttingPosition = $startDiff / ( $endDiff / $startDiff );
                $cuttingPoint = new ezcGraphCoordinate(
                    $start->x + ( $end->x - $start->x ) * $cuttingPosition,
                    $axisPosition
                );

                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $start->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $start->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $start->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $cuttingPoint->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $cuttingPoint->y
                        ),
                    ),
                    $fillColor,
                    true
                );

                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $axisPosition
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $end->y
                        ),
                        new ezcGraphCoordinate(
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $cuttingPoint->x,
                            $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $cuttingPoint->y
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
                $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $start->x,
                $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $start->y
            ),
            new ezcGraphCoordinate(
                $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x,
                $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $end->y
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

            $this->drawSymbol(
                new ezcGraphBoundings(
                    $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x - $this->options->symbolSize / 2,
                    $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $end->y - $this->options->symbolSize / 2,
                    $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) * $end->x + $this->options->symbolSize / 2,
                    $boundings->y1 - ( $boundings->y1 - $boundings->y0 ) * $end->y + $this->options->symbolSize / 2
                ),
                $symbolColor,
                $symbol
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
            $labelWidth = $boundings->x1 - $boundings->x0;
            $labelHeight = min( 
                ( $boundings->y1 - $boundings->y0 ) / count( $labels ) - $legend->spacing, 
                $legend->symbolSize + 2 * $legend->padding
            );
        }
        else
        {
            $labelWidth = ( $boundings->x1 - $boundings->x0 ) / count( $labels ) - $legend->spacing;
            $labelHeight = min(
                $boundings->x1 - $boundings->x0,
                $legend->symbolSize + 2 * $legend->padding
            );
        }

        $symbolSize = $labelHeight - 2 * $legend->padding;

        // Draw all labels
        $labelPosition = new ezcGraphCoordinate( $boundings->x0, $boundings->y0 );
        foreach ( $labels as $label )
        {
            $this->drawSymbol(
                new ezcGraphBoundings(
                    $labelPosition->x + $legend->padding,
                    $labelPosition->y + $legend->padding,
                    $labelPosition->x + $legend->padding + $symbolSize,
                    $labelPosition->y + $legend->padding + $symbolSize
                ),
                $label['color'],
                $label['symbol']
            );

            $this->driver->drawTextBox(
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
                        $boundings->x1 - $boundings->x0,
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
                        $boundings->x1 - $boundings->x0,
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
            $boundings->x1 - $boundings->x0,
            $boundings->y1 - $boundings->y0,
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

        $xAxisSpace = ( $end->x - $start->x ) * $axis->axisSpace;
        $yAxisSpace = ( $end->y - $start->y ) * $axis->axisSpace;

        // Apply axisSpace to start and end
        $start->x += $xAxisSpace;
        $start->y += $yAxisSpace;
        $end->x -= $xAxisSpace;
        $end->y -= $yAxisSpace;

        if ( $labelClass !== null )
        {
            $labelClass->renderLabels(
                $this,
                $boundings,
                $start,
                $end,
                $axis
            );
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

        $imagePosition = new ezcGraphCoordinate( 0, 0 );

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
                    $boundings->x0 + ( $boundings->x1 - $boundings->x0 - $imageWidth ) / 2,
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
                    $boundings->y0 + ( $boundings->y1 - $boundings->y0 - $imageHeight ) / 2,
                    $boundings->y0
                );
                break;
        }

        $imageWidth = min( $imageWidth, $boundings->x1 - $boundings->x0 );
        $imageHeight = min( $imageHeight, $boundings->y1 - $boundings->y0 );

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
     * Draw Symbol
     *
     * Draws a single symbol defined by the symbol constants in ezcGraph. for
     * NO_SYMBOL a rect will be drawn.
     * 
     * @param ezcGraphBoundings $boundings Boundings of symbol
     * @param ezcGraphColor $color Color of symbol
     * @param int $symbol Type of symbol
     * @return void
     */
    public function drawSymbol(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        $symbol = ezcGraph::NO_SYMBOL )
    {
        switch ( $symbol )
        {
            case ezcGraph::NO_SYMBOL:
                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate( $boundings->x0, $boundings->y0 ),
                        new ezcGraphCoordinate( $boundings->x1, $boundings->y0 ),
                        new ezcGraphCoordinate( $boundings->x1, $boundings->y1 ),
                        new ezcGraphCoordinate( $boundings->x0, $boundings->y1 ),
                    ),
                    $color,
                    true
                );
                break;
            case ezcGraph::DIAMOND:
                $this->driver->drawPolygon(
                    array(
                        new ezcGraphCoordinate( 
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2, 
                            $boundings->y0 
                        ),
                        new ezcGraphCoordinate( 
                            $boundings->x1,
                            $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
                        ),
                        new ezcGraphCoordinate( 
                            $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2, 
                            $boundings->y1 
                        ),
                        new ezcGraphCoordinate( 
                            $boundings->x0,
                            $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
                        ),
                    ),
                    $color,
                    true
                );
                break;
            case ezcGraph::BULLET:
                $this->driver->drawCircle(
                    new ezcGraphCoordinate( 
                        $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2, 
                        $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
                    ),
                    $boundings->x1 - $boundings->x0,
                    $boundings->y1 - $boundings->y0,
                    $color,
                    true
                );
                break;
            case ezcGraph::CIRCLE:
                $this->driver->drawCircle(
                    new ezcGraphCoordinate( 
                        $boundings->x0 + ( $boundings->x1 - $boundings->x0 ) / 2, 
                        $boundings->y0 + ( $boundings->y1 - $boundings->y0 ) / 2
                    ),
                    $boundings->x1 - $boundings->x0,
                    $boundings->y1 - $boundings->y0,
                    $color,
                    false
                );
                break;
        }
    }

    protected function finish()
    {
        $this->finishPieSegmentLabels();

        return true;
    }
}

?>
