<?php
/**
 * File containing the three dimensional renderer
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
class ezcGraphRenderer3d extends ezcGraphRenderer
{

    protected $pieSegmentLabels = array(
        0 => array(),
        1 => array(),
    );

    protected $pieSegmentBoundings = false;

    protected $linePostSymbols = array();

    protected $frontLines = array();

    protected $circleSectors = array();

    protected $barPostProcessing = array();

    protected $options;

    protected $depth = false;

    protected $xDepthFactor = false;

    protected $yDepthFactor = false;

    protected $dataBoundings = false;

    protected $xAxisSpace = false;

    protected $yAxisSpace = false;

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphRenderer3dOptions( $options );
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

    protected function get3dCoordinate( ezcGraphCoordinate $c, $front = true )
    {
        return new ezcGraphCoordinate(
            ( $c->x - $this->dataBoundings->x0 ) * $this->xDepthFactor + $this->dataBoundings->x0 + $this->depth * $front,
            ( $c->y - $this->dataBoundings->y0 ) * $this->yDepthFactor + $this->dataBoundings->y0 + $this->depth * ( 1 - $front )
        );
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
                - $this->options->pieChartHeight / 2 
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

        // Add circle sector to queue
        $this->circleSectors[] = array(
            'center' =>     $center,
            'width' =>      $radius * 2,
            'height' =>     $radius * 2 * $this->options->pieChartRotation - $this->options->pieChartHeight,
            'start' =>      $startAngle,
            'end' =>        $endAngle,
            'color' =>      $color,
        );

        if ( $label )
        {
            // Determine position of label
            $middle = $startAngle + ( $endAngle - $startAngle ) / 2;
            $pieSegmentCenter = new ezcGraphCoordinate(
                cos( deg2rad( $middle ) ) * $radius * 2 / 3 + $center->x,
                sin( deg2rad( $middle ) ) * $radius * $this->options->pieChartRotation * 2 / 3 + $center->y
            );

            // Split labels up into left an right size and index them on their
            // y position
            $this->pieSegmentLabels[(int) ($pieSegmentCenter->x > $center->x)][$pieSegmentCenter->y] = array(
                clone $pieSegmentCenter,
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

        $pieChartHeight = min(
            $radius * 2 + $this->options->maxLabelHeight * 2,
            $boundings->y1 - $boundings->y0
        );
        $pieChartYPosition = $boundings->y0 + ( ( $boundings->y1 - $boundings->y0 ) - $pieChartHeight ) / 2;

        // Calculate maximum height of labels
        $labelHeight = (int) round( min(
            ( count( $this->pieSegmentLabels[0] )
                ? $pieChartHeight / count( $this->pieSegmentLabels[0] )
                : $pieChartHeight
            ),
            ( count( $this->pieSegmentLabels[1] )
                ? $pieChartHeight / count( $this->pieSegmentLabels[1] )
                : $pieChartHeight
            ),
            ( $boundings->y1 - $boundings->y0 ) * $this->options->maxLabelHeight
        ) );

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
                // Determine position of label
                $minHeight += max( 0, $height - $minHeight - $labelHeight ) / $pieChartHeight * $toShare;
                $verticalDistance = ( $center->y - $minHeight - $labelHeight / 2 ) / $radius;

                $labelPosition = new ezcGraphCoordinate(
                    $center->x - 
                    $sign * (
                        abs( $verticalDistance ) > 1 ?
                        // If vertical distance to center is greater then the
                        // radius, use the centerline for the horizontal 
                        // position
                        5 :
                        // Else place the label outside of the pie chart
                        (   cos ( asin ( $verticalDistance ) ) * $radius + 
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

    protected function finishCirleSectors()
    {
        $zBuffer = array();

        // Add circle sector sides to simple z buffer prioriry list
        foreach ( $this->circleSectors as $circleSector )
        {
            $darkenedColor = $circleSector['color']->darken( $this->options->dataBorder );

            $zBuffer[
                (int) ( $circleSector['center']->y + sin( deg2rad( $circleSector['start'] + ( $circleSector['end'] - $circleSector['start'] ) / 2 ) ) * $circleSector['height'] / 2 )
            ][] = array(
                'method' => 'drawCircularArc',
                'paramenters' => array(
                    $circleSector['center'],
                    $circleSector['width'],
                    $circleSector['height'],
                    $this->options->pieChartHeight,
                    $circleSector['start'],
                    $circleSector['end'],
                    $circleSector['color']
                )
            );

            // Left side
            $polygonPoints = array(
                $circleSector['center'],
                new ezcGraphCoordinate(
                    $circleSector['center']->x,
                    $circleSector['center']->y + $this->options->pieChartHeight
                ),
                new ezcGraphCoordinate(
                    $circleSector['center']->x + cos( deg2rad( $circleSector['start'] ) ) * $circleSector['width'] / 2,
                    $circleSector['center']->y + sin( deg2rad( $circleSector['start'] ) ) * $circleSector['height'] / 2 + $this->options->pieChartHeight
                ),
                new ezcGraphCoordinate(
                    $circleSector['center']->x + cos( deg2rad( $circleSector['start'] ) ) * $circleSector['width'] / 2,
                    $circleSector['center']->y + sin( deg2rad( $circleSector['start'] ) ) * $circleSector['height'] / 2
                ),
            );

            // Get average y coordinate for polygon to use for zBuffer
            $center = 0;
            foreach( $polygonPoints as $point )
            {
                $center += $point->y;
            }
            $center = (int) ( $center / count( $polygonPoints ) );

            $zBuffer[$center][] = array(
                'method' => 'drawPolygon',
                'paramenters' => array(
                    $polygonPoints,
                    $circleSector['color'],
                    true
                ),
            );

            $zBuffer[$center][] = array(
                'method' => 'drawPolygon',
                'paramenters' => array(
                    $polygonPoints,
                    $darkenedColor,
                    false
                ),
            );

            // Right side
            $polygonPoints = array(
                $circleSector['center'],
                new ezcGraphCoordinate(
                    $circleSector['center']->x,
                    $circleSector['center']->y + $this->options->pieChartHeight
                ),
                new ezcGraphCoordinate(
                    $circleSector['center']->x + cos( deg2rad( $circleSector['end'] ) ) * $circleSector['width'] / 2,
                    $circleSector['center']->y + sin( deg2rad( $circleSector['end'] ) ) * $circleSector['height'] / 2 + $this->options->pieChartHeight
                ),
                new ezcGraphCoordinate(
                    $circleSector['center']->x + cos( deg2rad( $circleSector['end'] ) ) * $circleSector['width'] / 2,
                    $circleSector['center']->y + sin( deg2rad( $circleSector['end'] ) ) * $circleSector['height'] / 2
                ),
            );

            // Get average y coordinate for polygon to use for zBuffer
            $center = 0;
            foreach( $polygonPoints as $point )
            {
                $center += $point->y;
            }
            $center = (int) ( $center / count( $polygonPoints ) );

            $zBuffer[$center][] = array(
                'method' => 'drawPolygon',
                'paramenters' => array(
                    $polygonPoints,
                    $circleSector['color'],
                    true
                ),
            );

            $zBuffer[$center][] = array(
                'method' => 'drawPolygon',
                'paramenters' => array(
                    $polygonPoints,
                    $darkenedColor,
                    false
                ),
            );
        }

        ksort( $zBuffer );
        foreach ( $zBuffer as $sides )
        {
            foreach ( $sides as $side )
            {
                call_user_func_array( array( $this->driver, $side['method'] ), $side['paramenters'] );
            }
        }

        // Draw circle sector for front
        foreach ( $this->circleSectors as $circleSector )
        {
            $this->driver->drawCircleSector(
                $circleSector['center'],
                $circleSector['width'],
                $circleSector['height'],
                $circleSector['start'],
                $circleSector['end'],
                $circleSector['color'],
                true
            );

            $darkenedColor = $circleSector['color']->darken( $this->options->dataBorder );
            $this->driver->drawCircleSector(
                $circleSector['center'],
                $circleSector['width'],
                $circleSector['height'],
                $circleSector['start'],
                $circleSector['end'],
                $darkenedColor,
                false
            );
        }
    }

    protected function finishFrontLines()
    {
        foreach ( $this->frontLines as $line )
        {
            $this->driver->drawLine(
               $line[0],
                $line[1],
                $line[2],
                $line[3]
            );
        }
    }

    protected function finishLineSymbols()
    {
        foreach ( $this->linePostSymbols as $symbol )
        {
            $this->drawSymbol(
                $symbol['boundings'],
                $symbol['color'],
                $symbol['symbol']
            );
        }
    }
    
    /**
     * Draw bar
     *
     * Draws a bar as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
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
        $offset = - $stepSize / 2 + $margin / 2 + ( $dataCount - $dataNumber - 1 ) * ( $padding + $barWidth ) + $padding / 2;

        $startDepth = $this->options->barMargin;
        $midDepth = .5;
        $endDepth = 1 - $this->options->barMargin;

        switch ( $symbol )
        {
            case ezcGraph::NO_SYMBOL:
                $barPolygonArray = array(
                    new ezcGraphCoordinate( 
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset,
                        $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                    ),
                    new ezcGraphCoordinate( 
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset,
                        $this->dataBoundings->y0 + $this->yAxisSpace + $position->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                    ),
                    new ezcGraphCoordinate( 
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth,
                        $this->dataBoundings->y0 + $this->yAxisSpace + $position->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                    ),
                    new ezcGraphCoordinate( 
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth,
                        $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                    ),
                );

                // Draw right bar side
                $this->barPostProcessing[] = array(
                    'index' => $barPolygonArray[2]->x,
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        array(
                            $this->get3dCoordinate( $barPolygonArray[2], $startDepth ),
                            $this->get3dCoordinate( $barPolygonArray[3], $startDepth ),
                            $this->get3dCoordinate( $barPolygonArray[3], $endDepth ),
                            $this->get3dCoordinate( $barPolygonArray[2], $endDepth ),
                        ),
                        $color->darken( $this->options->barDarkenSide ),
                        true
                    ),
                );

                $this->barPostProcessing[] = array(
                    'index' => $barPolygonArray[1]->x,
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        ( $barPolygonArray[1]->y < $barPolygonArray[3]->y
                        ?   array(
                                $this->get3dCoordinate( $barPolygonArray[1], $startDepth ),
                                $this->get3dCoordinate( $barPolygonArray[2], $startDepth ),
                                $this->get3dCoordinate( $barPolygonArray[2], $endDepth ),
                                $this->get3dCoordinate( $barPolygonArray[1], $endDepth ),
                            )
                        :   array(
                                $this->get3dCoordinate( $barPolygonArray[0], $startDepth ),
                                $this->get3dCoordinate( $barPolygonArray[3], $startDepth ),
                                $this->get3dCoordinate( $barPolygonArray[3], $endDepth ),
                                $this->get3dCoordinate( $barPolygonArray[0], $endDepth ),
                            )
                        ),
                        $color->darken( $this->options->barDarkenTop ),
                        true
                    ),
                );

                $this->barPostProcessing[] = array(
                    'index' => $barPolygonArray[1]->x,
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        array(
                            $this->get3dCoordinate( $barPolygonArray[0], $startDepth ),
                            $this->get3dCoordinate( $barPolygonArray[1], $startDepth ),
                            $this->get3dCoordinate( $barPolygonArray[2], $startDepth ),
                            $this->get3dCoordinate( $barPolygonArray[3], $startDepth ),
                        ),
                        $color,
                        true
                    ),
                );
                break;
            case ezcGraph::DIAMOND:
                $barCoordinateArray = array(
                    // The bottom point of the diamond is moved to .7 instead 
                    // of .5 because it looks more correct, even it is wrong...
                    'x' => array(
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset,
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth * .7,
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth,
                        $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth * .3,
                    ),
                    'y' => array(
                        $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) ),
                        $this->dataBoundings->y0 + $this->yAxisSpace + $position->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) ),
                    ),
                );

                $this->barPostProcessing[] = array(
                    'index' => $barCoordinateArray['x'][0],
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        array(
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][0], $barCoordinateArray['y'][0] ), $midDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][0], $barCoordinateArray['y'][1] ), $midDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][1], $barCoordinateArray['y'][1] ), $startDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][1], $barCoordinateArray['y'][0] ), $startDepth ),
                        ),
                        $color,
                        true
                    ),
                );

                $this->barPostProcessing[] = array(
                    'index' => $barCoordinateArray['x'][1],
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        array(
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][2], $barCoordinateArray['y'][0] ), $midDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][2], $barCoordinateArray['y'][1] ), $midDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][1], $barCoordinateArray['y'][1] ), $startDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][1], $barCoordinateArray['y'][0] ), $startDepth ),
                        ),
                        $color->darken( $this->options->barDarkenSide ),
                        true
                    ),
                );

                $topLocation = min(
                    $barCoordinateArray['y'][0],
                    $barCoordinateArray['y'][1]
                );

                $this->barPostProcessing[] = array(
                    'index' => $barCoordinateArray['x'][0],
                    'method' => 'drawPolygon',
                    'parameters' => array(
                        array(
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][1], $topLocation ), $startDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][2], $topLocation ), $midDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][3], $topLocation ), $endDepth ),
                            $this->get3dCoordinate( new ezcGraphCoordinate( $barCoordinateArray['x'][0], $topLocation ), $midDepth ),
                        ),
                        $color->darken( $this->options->barDarkenTop ),
                        true
                    ),
                );
                break;
            case ezcGraph::BULLET:
            case ezcGraph::CIRCLE:
                $barCenterTop = new ezcGraphCoordinate(
                    $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth / 2,
                    $this->dataBoundings->y0 + $this->yAxisSpace + $position->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                    
                );
                $barCenterBottom = new ezcGraphCoordinate(
                    $this->dataBoundings->x0 + $this->xAxisSpace + $position->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ) + $offset + $barWidth / 2,
                    $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
                );

                if ( $barCenterTop->y > $barCenterBottom->y )
                {
                    $tmp = $barCenterTop;
                    $barCenterTop = $barCenterBottom;
                    $barCenterBottom = $tmp;
                }

                $this->barPostProcessing[] = array(
                    'index' => $barCenterBottom->x,
                    'method' => 'drawCircularArc',
                    'parameters' => array(
                        $this->get3dCoordinate( $barCenterBottom, $midDepth ),
                        $barWidth,
                        $barWidth / 2,
                        ( $barCenterTop->y - $barCenterBottom->y ) * $this->yDepthFactor,
                        0,
                        360,
                        $color
                    ),
                );

                $this->barPostProcessing[] = array(
                    'index' => $barCenterBottom->x + 1,
                    'method' => 'drawCircle',
                    'parameters' => array(
                        $this->get3dCoordinate( $barCenterTop, $midDepth ),
                        $barWidth,
                        $barWidth / 2,
                        ( $symbol === ezcGraph::CIRCLE ? $color->darken( $this->options->barDarkenTop ) : $color )
                    ),
                );

                break;
        }

    }
 
    protected function finishBars()
    {
        if ( !count( $this->barPostProcessing ) )
        {
            return true;
        }

        $zIndexArray = array();
        foreach ( $this->barPostProcessing as $key => $barPolygon )
        {
            $zIndexArray[$key] = $barPolygon['index'];
        }

        array_multisort(
            $zIndexArray, SORT_ASC, SORT_NUMERIC,
            $this->barPostProcessing
        );

        foreach ( $this->barPostProcessing as $bar )
        {
            call_user_func_array(
                array( $this->driver, $bar['method'] ),
                $bar['parameters']
            );
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
        ezcGraphColor $color,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        $dataNumber = 0,
        $dataCount = 1,
        $symbol = ezcGraph::NO_SYMBOL,
        ezcGraphColor $symbolColor = null,
        ezcGraphColor $fillColor = null,
        $axisPosition = 0.,
        $thickness = 1 )
    {
        // Calculate line width based on options
        if ( $this->options->seperateLines )
        {
            $startDepth = ( 1 / $dataCount ) * $dataNumber;
            $endDepth = ( 1 / $dataCount ) * ( $dataNumber + 1 );
        }
        else
        {
            $startDepth = false;
            $endDepth = true;
        }

        // Determine Coordinates depending on boundings and data point position
        $startCoord = new ezcGraphCoordinate( 
            $this->dataBoundings->x0 + $this->xAxisSpace + $start->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ),
            $this->dataBoundings->y0 + $this->yAxisSpace + $start->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
        );
        $endCoord = new ezcGraphCoordinate( 
            $this->dataBoundings->x0 + $this->xAxisSpace + $end->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ),
            $this->dataBoundings->y0 + $this->yAxisSpace + $end->y * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
        );

        // 3D-fy coordinates
        $linePolygonPoints = array(
            $this->get3dCoordinate( $startCoord, $startDepth ),
            $this->get3dCoordinate( $endCoord, $startDepth ),
            $this->get3dCoordinate( $endCoord, $endDepth ),
            $this->get3dCoordinate( $startCoord, $endDepth ),
        );

        $startAxisCoord = new ezcGraphCoordinate( 
            $this->dataBoundings->x0 + $this->xAxisSpace + $start->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ),
            $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
        );
        $endAxisCoord = new ezcGraphCoordinate( 
            $this->dataBoundings->x0 + $this->xAxisSpace + $end->x * ( $this->dataBoundings->x1 - ( $this->dataBoundings->x0 + 2 * $this->xAxisSpace ) ),
            $this->dataBoundings->y0 + $this->yAxisSpace + $axisPosition * ( $this->dataBoundings->y1 - ( $this->dataBoundings->y0 + 2 * $this->yAxisSpace ) )
        );

        // 3D-fy coordinates
        $axisPolygonPoints = array(
            $this->get3dCoordinate( $startAxisCoord, $startDepth ),
            $this->get3dCoordinate( $endAxisCoord, $startDepth ),
            $this->get3dCoordinate( $endAxisCoord, $endDepth ),
            $this->get3dCoordinate( $startAxisCoord, $endDepth ),
        );

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
                        $linePolygonPoints[0],
                        $linePolygonPoints[1],
                        $this->get3dCoordinate( $endAxisCoord, $startDepth ),
                        $this->get3dCoordinate( $startAxisCoord, $startDepth ),
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
                    $startCoord->x + ( $endCoord->x - $startCoord->x ) * $cuttingPosition,
                    $startAxisCoord->y
                );

                $this->driver->drawPolygon(
                    array(
                        $this->get3dCoordinate( $startAxisCoord, $startDepth ),
                        $linePolygonPoints[0],
                        $this->get3dCoordinate( $cuttingPoint, $startDepth ),
                    ),
                    $fillColor,
                    true
                );

                $this->driver->drawPolygon(
                    array(
                        $this->get3dCoordinate( $endAxisCoord, $startDepth ),
                        $linePolygonPoints[1],
                        $this->get3dCoordinate( $cuttingPoint, $startDepth ),
                    ),
                    $fillColor,
                    true
                );
            }

            // Draw closing foo
            $this->driver->drawPolygon(
                array(
                    $linePolygonPoints[2],
                    $linePolygonPoints[1],
                    $this->get3dCoordinate( $endAxisCoord, $startDepth ),
                    $this->get3dCoordinate( $endAxisCoord, $endDepth ),
                ),
                $fillColor,
                true
            );
        }


        // Draw line
        $this->driver->drawPolygon(
            $linePolygonPoints,
            $color,
            true,
            $thickness
        );

        // Draw polygon border
        if ( $this->options->dataBorder > 0 )
        {
            $this->driver->drawPolygon(
                $linePolygonPoints,
                $color->darken( $this->options->dataBorder ),
                false,
                $thickness
            );
        }

        // Draw line symbol
        if ( $this->options->showSymbol && 
             ( $symbol !== ezcGraph::NO_SYMBOL ) )
        {
            if ( $symbolColor === null )
            {
                $symbolColor = $color;
            }

            $this->linePostSymbols[] = array(
                'boundings' => new ezcGraphBoundings(
                    $linePolygonPoints[2]->x - $this->options->symbolSize / 2,
                    $linePolygonPoints[2]->y - $this->options->symbolSize / 2,
                    $linePolygonPoints[2]->x + $this->options->symbolSize / 2,
                    $linePolygonPoints[2]->y + $this->options->symbolSize / 2
                ),
                'color' => $symbolColor,
                'symbol' => $symbol,
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
        if ( $this->depth === false )
        {
            // We are not 3d for now, wg. rendering normal text boxes like the
            // title
            $topleft = new ezcGraphCoordinate( 
                $boundings->x0, 
                $boundings->y0
            );
            $bottomright = new ezcGraphCoordinate( 
                $boundings->x1, 
                $boundings->y1
            );
        }
        else
        {
            // The 3d part started
            $topleft = $this->get3dCoordinate( 
                new ezcGraphCoordinate( 
                    $boundings->x0, 
                    $boundings->y0
                ), false 
            );
            $bottomright = $this->get3dCoordinate( 
                new ezcGraphCoordinate( 
                    $boundings->x1, 
                    $boundings->y1
                ), false 
            );
        }

        $this->driver->drawTextBox(
            $text,
            $topleft,
            $bottomright->x - $topleft->x,
            $bottomright->y - $topleft->y,
            $align
        );
    }

    /**
     * Draw grid line
     *
     * Draw line for the grid in the chart background
     * 
     * 
     * @param ezcGraphCoordinate $start Start point
     * @param ezcGraphCoordinate $end End point
     * @param ezcGraphColor $color Color of the grid line
     * @return void
     */
    public function drawGridLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color )
    {
        $gridPolygonCoordinates = array(
            $this->get3dCoordinate( $start, false ),
            $this->get3dCoordinate( $end, false ),
            $this->get3dCoordinate( $end, true ),
            $this->get3dCoordinate( $start, true ),
        );

        // Draw grid polygon
        if ( $this->options->fillGrid === 0 )
        {
            $this->driver->drawLine(
                $gridPolygonCoordinates[2],
                $gridPolygonCoordinates[3],
                $color
            );
        }
        else
        {
            if ( $this->options->fillGrid === 1 )
            {
                $this->driver->drawPolygon(
                    $gridPolygonCoordinates,
                    $color,
                    true
                );
            }
            else
            {
                $this->driver->drawPolygon(
                    $gridPolygonCoordinates,
                    $color->transparent( $this->options->fillGrid ),
                    true
                );
            }
            
            // Draw grid lines - scedule some for later to be drawn in front of 
            // the data
            $this->frontLines[] = array(
                $gridPolygonCoordinates[0],
                $gridPolygonCoordinates[1],
                $color,
                1
            );
        
            $this->frontLines[] = array(
                $gridPolygonCoordinates[1],
                $gridPolygonCoordinates[2],
                $color,
                1
            );

            $this->driver->drawLine(
                $gridPolygonCoordinates[2],
                $gridPolygonCoordinates[3],
                $color,
                1
            );

            $this->frontLines[] = array(
                $gridPolygonCoordinates[3],
                $gridPolygonCoordinates[0],
                $color,
                1
            );
        }
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
        $stepPolygonCoordinates = array(
            $this->get3dCoordinate( $start, true ),
            $this->get3dCoordinate( $end, true ),
            $this->get3dCoordinate( $end, false ),
            $this->get3dCoordinate( $start, false ),
        );

        // Draw step polygon
        if ( ( $this->options->fillAxis > 0 ) &&
             ( $this->options->fillAxis < 1 ) )
        {
            $this->driver->drawPolygon(
                $stepPolygonCoordinates,
                $color->transparent( $this->options->fillAxis ),
                true
            );

            $this->driver->drawPolygon(
                $stepPolygonCoordinates,
                $color,
                false
            );
        }
        else
        {
            $this->driver->drawPolygon(
                $stepPolygonCoordinates,
                $color,
                !(bool) $this->options->fillAxis
            );
        }
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
        // Calculate used space for three dimensional effects
        if ( $this->depth === false )
        {
            $this->depth = min(
                ( $boundings->x1 - $boundings->x0 ) * $this->options->depth,
                ( $boundings->y1 - $boundings->y0 ) * $this->options->depth
            );

            $this->xDepthFactor = 1 - $this->depth / ( $boundings->x1 - $boundings->x0 );
            $this->yDepthFactor = 1 - $this->depth / ( $boundings->y1 - $boundings->y0 );

            $this->dataBoundings = clone $boundings;
        }

        switch ( $axis->position )
        {
            case ezcGraph::TOP:
            case ezcGraph::BOTTOM:
                $this->xAxisSpace = ( $boundings->x1 - $boundings->x0 ) * $axis->axisSpace;
                break;
            case ezcGraph::LEFT:
            case ezcGraph::RIGHT:
                $this->yAxisSpace = ( $boundings->y1 - $boundings->y0 ) * $axis->axisSpace;
                break;
        }

        // Determine normalized direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;

        $start->x += $boundings->x0;
        $start->y += $boundings->y0;
        $end->x += $boundings->x0;
        $end->y += $boundings->y0;

        $axisPolygonCoordinates = array(
            $this->get3dCoordinate( $start, true ),
            $this->get3dCoordinate( $end, true ),
            $this->get3dCoordinate( $end, false ),
            $this->get3dCoordinate( $start, false ),
        );

        // Draw axis
        if ( ( $this->options->fillAxis > 0 ) &&
             ( $this->options->fillAxis < 1 ) )
        {
            $this->driver->drawPolygon(
                $axisPolygonCoordinates,
                $axis->border->transparent( $this->options->fillAxis ),
                true
            );
        }
        else
        {
            $this->driver->drawPolygon(
                $axisPolygonCoordinates,
                $axis->border,
                ! (bool) $this->options->fillAxis
            );
        }

        // Draw axis lines - scedule some for later to be drawn in front of 
        // the data
        $this->driver->drawLine(
            $axisPolygonCoordinates[0],
            $axisPolygonCoordinates[1],
            $axis->border,
            1
        );
    
        $this->frontLines[] = array(
            $axisPolygonCoordinates[1],
            $axisPolygonCoordinates[2],
            $axis->border,
            1
        );

        $this->frontLines[] = array(
            $axisPolygonCoordinates[2],
            $axisPolygonCoordinates[3],
            $axis->border,
            1
        );

        $this->frontLines[] = array(
            $axisPolygonCoordinates[3],
            $axisPolygonCoordinates[0],
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
                $axisPolygonCoordinates[1],
                new ezcGraphCoordinate(
                    $axisPolygonCoordinates[1]->x
                        + $direction->y * $size / 2
                        + $direction->x * $size,
                    $axisPolygonCoordinates[1]->y
                        + $direction->x * $size / 2
                        + $direction->y * $size
                ),
                new ezcGraphCoordinate(
                    $axisPolygonCoordinates[1]->x
                        - $direction->y * $size / 2
                        + $direction->x * $size,
                    $axisPolygonCoordinates[1]->y
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
        $start = new ezcGraphCoordinate(
            $start->x + $xAxisSpace,
            $start->y + $yAxisSpace
        );
        $end = new ezcGraphCoordinate(
            $end->x - $xAxisSpace,
            $end->y - $yAxisSpace
        );

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

        $imageWidth = min( $imageWidth, $boundings->x1 - $boundings->x0 );
        $imageHeight = min( $imageHeight, $boundings->y1 - $boundings->y0 );

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
        $this->finishCirleSectors();
        $this->finishPieSegmentLabels();
        $this->finishBars();
        $this->finishLineSymbols();
        $this->finishFrontLines();

        return true;
    }
}

?>
