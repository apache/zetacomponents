<?php
/**
 * File containing the ezcGraphAxisRotatedLabelRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Renders axis labels centered between two axis steps like normally used for 
 * bar charts.
 *
 * @property float $angle
 *           Angle of labels on axis in degrees.
 *
 * @package Graph
 * @mainclass
 */
class ezcGraphAxisRotatedLabelRenderer extends ezcGraphAxisLabelRenderer
{
    /**
     * Store step array for later coordinate modifications
     * 
     * @var array( ezcGraphStep )
     */
    protected $steps;

    /**
     * Store direction for later coordinate modifications
     * 
     * @var ezcGraphVector
     */
    protected $direction;

    /**
     * Store coordinate width modifier for later coordinate modifications
     * 
     * @var float
     */
    protected $widthModifier;
    
    /**
     * Store coordinate offset for later coordinate modifications
     * 
     * @var float
     */
    protected $offset;
    
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        parent::__construct( $options );
        $this->properties['angle'] = 45.;
    }

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'angle':
                if ( !is_numeric( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float < 360' );
                }

                $reducement = (int) ( $propertyValue - $propertyValue % 360 );
                $this->properties['angle'] = (float) $propertyValue - $reducement;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Render Axis labels
     *
     * Render labels for an axis.
     *
     * @param ezcGraphRenderer $renderer Renderer used to draw the chart
     * @param ezcGraphBoundings $boundings Boundings of the axis
     * @param ezcGraphCoordinate $start Axis starting point
     * @param ezcGraphCoordinate $end Axis ending point
     * @param ezcGraphChartElementAxis $axis Axis instance
     * @return void
     */
    public function renderLabels(
        ezcGraphRenderer $renderer,
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis )
    {
        // receive rendering parameters from axis
        $steps = $axis->getSteps();
        $this->steps = $steps;

        $axisBoundings = new ezcGraphBoundings(
            $start->x, $start->y,
            $end->x, $end->y
        );

        // Determine normalized axis direction
        $this->direction = new ezcGraphVector(
            $end->x - $start->x,
            $end->y - $start->y
        );
        $this->direction->unify();
        $axisAngle = -$this->direction->angle( new ezcGraphVector( 1, 0 ) );

        if ( $this->outerGrid )
        {
            $gridBoundings = $boundings;
        }
        else
        {
            $gridBoundings = new ezcGraphBoundings(
                $boundings->x0 + $renderer->xAxisSpace,
                $boundings->y0 + $renderer->yAxisSpace,
                $boundings->x1 - $renderer->xAxisSpace,
                $boundings->y1 - $renderer->yAxisSpace
            );
        }

        // Determine additional required axis space by boxes
        $firstStep = reset( $steps );
        $lastStep = end( $steps );

        $textAngle = $axisAngle + 
            deg2rad( $this->angle ) + 
            ( $axis->position & ( ezcGraph::TOP | ezcGraph::BOTTOM ) ? deg2rad( 270 ) : deg2rad( 90 ) );
        $degTextAngle = rad2deg( $textAngle );

        $this->offset = min( 1, -cos( $textAngle ) / sin( $textAngle ) );

        $axisSpaceFactor = abs(
            ( $this->direction->x == 0 ? 0 :
                $this->direction->x * $renderer->yAxisSpace / $axisBoundings->width ) +
            ( $this->direction->y == 0 ? 0 :
                $this->direction->y * $renderer->xAxisSpace / $axisBoundings->height )
        );

        $start = new ezcGraphCoordinate(
            $start->x + max( 0., $axisSpaceFactor * $this->offset ) * ( $end->x - $start->x ),
            $start->y + max( 0., $axisSpaceFactor * $this->offset ) * ( $end->y - $start->y )
        );
        $end = new ezcGraphCoordinate(
            $end->x + min( 0., $axisSpaceFactor * $this->offset ) * ( $end->x - $start->x ),
            $end->y + min( 0., $axisSpaceFactor * $this->offset ) * ( $end->y - $start->y )
        );

        $labelLength = sqrt(
            pow(
                $renderer->xAxisSpace * $this->direction->y +
                $axisSpaceFactor * $this->offset * ( $end->x - $start->x ),
                2 ) +
            pow(
                $renderer->yAxisSpace * $this->direction->x +
                $axisSpaceFactor * $this->offset * ( $end->y - $start->y ),
                2 )
        );

        $this->offset *= $axisSpaceFactor;

        // Draw steps and grid
        foreach ( $steps as $nr => $step )
        {
            $position = new ezcGraphCoordinate(
                $start->x + ( $end->x - $start->x ) * $step->position * abs( $this->direction->x ),
                $start->y + ( $end->y - $start->y ) * $step->position * abs( $this->direction->y )
            );
    
            $stepSize = new ezcGraphCoordinate(
                ( $end->x - $start->x ) * $step->width,
                ( $end->y - $start->y ) * $step->width
            );

            // Calculate label boundings
            switch ( true )
            {
                case ( $nr === 0 ):
                    $labelSize = min(
                        abs( 
                            $renderer->xAxisSpace * 2 * $this->direction->x +
                            $renderer->yAxisSpace * 2 * $this->direction->y ),
                        abs( 
                            $step->width * $axisBoundings->width * $this->direction->x +
                            $step->width * $axisBoundings->height * $this->direction->y )
                    );
                    break;
                case ( $step->isLast ):
                    $labelSize = min(
                        abs( 
                            $renderer->xAxisSpace * 2 * $this->direction->x +
                            $renderer->yAxisSpace * 2 * $this->direction->y ),
                        abs( 
                            $steps[$nr - 1]->width * $axisBoundings->width * $this->direction->x +
                            $steps[$nr - 1]->width * $axisBoundings->height * $this->direction->y )
                    );
                    break;
                default:
                    $labelSize = min(
                        abs( 
                            $step->width * $axisBoundings->width * $this->direction->x +
                            $step->width * $axisBoundings->height * $this->direction->y ),
                        abs( 
                            $steps[$nr - 1]->width * $axisBoundings->width * $this->direction->x +
                            $steps[$nr - 1]->width * $axisBoundings->height * $this->direction->y )
                    );
                    break;
            }

            $labelSize = $labelSize * cos( deg2rad( $this->angle ) );

            if ( $degTextAngle >= 90 && $degTextAngle < 270 )
            {
                $renderer->drawText(
                    new ezcGraphBoundings(
                        $position->x - abs( $labelLength ),
                        $position->y - $labelSize / 2,
                        $position->x,
                        $position->y + $labelSize / 2
                    ),
                    $step->label . ' ',
                    ezcGraph::RIGHT | ezcGraph::MIDDLE,
                    new ezcGraphRotation(
                        $degTextAngle - 180,
                        new ezcGraphCoordinate(
                            $position->x,
                            $position->y
                        )
                    )
                );
            }
            else
            {
                $renderer->drawText(
                    new ezcGraphBoundings(
                        $position->x,
                        $position->y - $labelSize / 2,
                        $position->x + abs( $labelLength ),
                        $position->y + $labelSize / 2
                    ),
                    ' ' . $step->label, 
                    ezcGraph::LEFT | ezcGraph::MIDDLE,
                    new ezcGraphRotation(
                        $degTextAngle,
                        new ezcGraphCoordinate(
                            $position->x,
                            $position->y
                        )
                    )
                );
            }

            // major grid
            if ( $axis->majorGrid )
            {
                $this->drawGrid( 
                    $renderer, 
                    $gridBoundings, 
                    $position,
                    $stepSize,
                    $axis->majorGrid
                );
            }
            
            // major step
            $this->drawStep( 
                $renderer, 
                $position,
                $this->direction, 
                $axis->position, 
                $this->majorStepSize, 
                $axis->border
            );
        }
    }
    
    /**
     * Modify chart data position
     *
     * Optionally additionally modify the coodinate of a data point
     * 
     * @param ezcGraphCoordinate $coordinate Data point coordinate
     * @return ezcGraphCoordinate Modified coordinate
     */
    public function modifyChartDataPosition( ezcGraphCoordinate $coordinate )
    {
        return new ezcGraphCoordinate(
            $coordinate->x * abs( $this->direction->y ) +
                ( $coordinate->x * ( 1 - abs( $this->offset ) ) + max( 0, $this->offset ) ) * abs( $this->direction->x ),
            $coordinate->y * abs( $this->direction->x ) +
                ( $coordinate->y * ( 1 - abs( $this->offset ) ) + max( 0, $this->offset ) ) * abs( $this->direction->y )
        );
    }
}
?>
