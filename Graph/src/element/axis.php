<?php
/**
 * File containing the abstract ezcGraphChartElementAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
abstract class ezcGraphChartElementAxis extends ezcGraphChartElement
{
    
    /**
     * The position of the null value
     * 
     * @var float
     */
    protected $nullPosition;

    /**
     * Percent of the chart space not used to display values
     * 
     * @var float
     */
    protected $padding = .1;

    /**
     * Color of the rastering 
     * 
     * @var ezcGraphColor
     */
    protected $raster = false;

    /**
     * Raster minor steps on axis
     * 
     * @var ezcGraphColor
     */
    protected $rasterMinor = false;

    /**
     * Labeled major steps displayed on the axis 
     * 
     * @var float
     */
    protected $majorStep = false;

    /**
     * Non labeled minor steps on the axis
     * 
     * @var mixed
     * @access protected
     */
    protected $minorStep = false;

    /**
     * Length of lines for the major steps on the axis
     * 
     * @var integer
     */
    protected $majorScalingLineLength = 4;
    
    /**
     * Length of lines for the minor steps on the axis
     * 
     * @var integer
     */
    protected $minorScalingLineLength = 2;

    public function __construct( array $options = array() )
    {
        $this->border = ezcGraphColor::fromHex( '#000000' );

        parent::__construct( $options );
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
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'nullPosition':
                $this->nullPosition = (float) $propertyValue;
                break;
            case 'padding':
                $this->padding = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'raster':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->raster = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphColor' );
                }
            case 'rasterMinor':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->rasterMinor = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphColor' );
                }
            case 'majorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'majorStep', $propertyValue, 'float > 0' );
                }
                $this->majorStep = (float) $propertyValue;
                break;
            case 'minorStep':
                if ( $propertyValue <= 0 )
                {
                    throw new ezcBaseValueException( 'minorStep', $propertyValue, 'float > 0' );
                }
                $this->minorStep = (float) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    abstract public function getCoordinate( ezcGraphBoundings $boundings, $value );

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    abstract protected function getMinorStepCount();

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    abstract protected function getMajorStepCount();

    abstract protected function getLabel( $step );

    /**
     * Draw a axis from a start point to an end point. They do not need to be 
     * placed in-plane.
     * 
     * @param ezcGraphRenderer $renderer 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param float $major 
     * @param float $minor 
     * @return void
     */
    protected function drawAxis( ezcGraphRenderer $renderer, ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphBoundings $boundings ) 
    {
        // Determine normalized direction
        $direction = new ezcGraphCoordinate(
            $start->x - $end->x,
            $start->y - $end->y
        );
        $length = sqrt( pow( $direction->x, 2) + pow( $direction->y, 2 ) );
        $direction->x /= $length;
        $direction->y /= $length;

        // Draw axis
        $renderer->drawLine(
            $this->border,
            $start,
            $end,
            false
        );

        // Apply padding to start and end
        $start->x += ( $end->x - $start->x ) * ( $this->padding / 2 );
        $start->y += ( $end->y - $start->y ) * ( $this->padding / 2 );
        $end->x -= ( $end->x - $start->x ) * ( $this->padding / 2 );
        $end->y -= ( $end->y - $start->y ) * ( $this->padding / 2 );

        // Draw major steps
        $steps = $this->getMajorStepCount();

        // Calculate stepsize
        $xStepsize = ( $end->x - $start->x ) / $steps;
        $yStepsize = ( $end->y - $start->y ) / $steps;

        // Caluclate datafree chart border
        $xBorder = abs ( ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) );
        $yBorder = abs ( ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) );

        for ( $i = 0; $i <= $steps; ++$i )
        {
            $renderer->drawLine(
                $this->border,
                new ezcGraphCoordinate(
                    (int) round( $start->x + $i * $xStepsize
                        + $direction->y * $this->majorScalingLineLength ),
                    (int) round( $start->y + $i * $yStepsize
                        + $direction->x * -$this->majorScalingLineLength )
                ),
                new ezcGraphCoordinate(
                    (int) round( $start->x + $i * $xStepsize
                        + $direction->y * -$this->majorScalingLineLength ),
                    (int) round( $start->y + $i * $yStepsize
                        + $direction->x * $this->majorScalingLineLength )
                ),
                false
            );

            // Draw label
            if ( $i < $steps )
            {
                $label = $this->getLabel( $i );

                switch ( $this->position )
                {
                    case ezcGraph::LEFT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize ),
                                (int) round( $start->y + $i * $yStepsize )
                            ),
                            $label,
                            (int) round( $xStepsize ),
                            $yBorder,
                            ezcGraph::LEFT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::RIGHT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize + $xStepsize ),
                                (int) round( $start->y + $i * $yStepsize )
                            ),
                            $label,
                            (int) round( -$xStepsize ),
                            $yBorder,
                            ezcGraph::RIGHT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::BOTTOM:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize - $xBorder ),
                                (int) round( $start->y + $i * $yStepsize + $yStepsize )
                            ),
                            $label,
                            $xBorder,
                            (int) round( -$yStepsize ),
                            ezcGraph::RIGHT | ezcGraph::BOTTOM
                        );
                        break;
                    case ezcGraph::TOP:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize - $xBorder ),
                                (int) round( $start->y + $i * $yStepsize )
                            ),
                            $label,
                            $xBorder,
                            (int) round( $yStepsize ),
                            ezcGraph::RIGHT | ezcGraph::TOP
                        );
                        break;
                }
            }
        }

        // Draw minor steps if wanted
        if ( $this->minorStep )
        {
            $steps = $this->getMinorStepCount();

            for ( $i = 0; $i < $steps; ++$i )
            {
                $renderer->drawLine(
                    $this->border,
                    new ezcGraphCoordinate(
                        (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                            + $direction->y * $this->minorScalingLineLength),
                        (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                            + $direction->x * -$this->minorScalingLineLength)
                    ),
                    new ezcGraphCoordinate(
                        (int) round($start->x + $i * ( $end->x - $start->x ) / $steps 
                            + $direction->y * -$this->minorScalingLineLength),
                        (int) round($start->y + $i * ( $end->y - $start->y ) / $steps 
                            + $direction->x * $this->minorScalingLineLength)
                    ),
                    false
                );
            }
        }
    }

    /**
     * Render an axe
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        $this->nullPosition,
                        $boundings->y0
                    ),
                    new ezcGraphCoordinate(
                        $this->nullPosition,
                        $boundings->y1
                    ),
                    $boundings
                );
                break;
            case ezcGraph::BOTTOM:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        $this->nullPosition,
                        $boundings->y1
                    ),
                    new ezcGraphCoordinate(
                        $this->nullPosition,
                        $boundings->y0
                    ),
                    $boundings
                );
                break;
            case ezcGraph::LEFT:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        $boundings->x0,
                        $this->nullPosition
                    ),
                    new ezcGraphCoordinate(
                        $boundings->x1,
                        $this->nullPosition
                    ),
                    $boundings
                );
                break;
            case ezcGraph::RIGHT:
                $this->drawAxis(
                    $renderer,
                    new ezcGraphCoordinate(
                        $boundings->x1,
                        $this->nullPosition
                    ),
                    new ezcGraphCoordinate(
                        $boundings->x0,
                        $this->nullPosition
                    ),
                    $boundings
                );
                break;
        }
        return $boundings;   
    }
}

?>
