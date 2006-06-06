<?php
/**
 * File containing the abstract ezcGraphChartElementNumericAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a axe as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementNumericAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Minimum value of displayed scale on axis
     * 
     * @var float
     */
    protected $min = false;

    /**
     * Maximum value of displayed scale on axis
     * 
     * @var float
     */
    protected $max = false;

    /**
     * Constant used for calculation of automatic definition of major scaling 
     * steps
     */
    const MIN_MAJOR_COUNT = 5;

    /**
     * Constant used for automatic calculation of minor steps from given major 
     * steps 
     */
    const MIN_MINOR_COUNT = 8;

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
            case 'min':
                $this->min = (float) $propertyValue;
                break;
            case 'max':
                $this->max = (float) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Returns a "nice" number for a given floating point number.
     *
     * Nice numbers are steps on a scale which are easily recognized by humans
     * like 0.5, 25, 1000 etc.
     * 
     * @param float $float Number to be altered
     * @return float Nice number
     */
    protected function getNiceNumber( $float )
    {
        // Get absolute value and save sign
        $abs = abs( $float );
        $sign = $float / $abs;

        // Normalize number to a range between 1 and 10
        $log = (int) round( log10( $abs ), 0);
        $abs /= pow( 10, $log );


        // find next nice number
        if ( $abs > 5 ) {
            $abs = 10.;
        }
        elseif ( $abs > 2.5 )
        {
            $abs = 5.;
        }
        elseif ( $abs > 1 )
        {
            $abs = 2.5;
        }
        else
        {
            $abs = 1;
        }

        // unnormalize number to original values
        return $abs * pow( 10, $log ) * $sign;
    }

    /**
     * Calculate minimum value for displayed axe basing on real minimum and
     * major step size
     * 
     * @param float $min Real data minimum 
     * @param float $max Real data maximum
     * @return void
     */
    protected function calculateMinimum( $min, $max )
    {
        $this->min = floor( $min / $this->majorStep ) * $this->majorStep;
    }

    /**
     * Calculate maximum value for displayed axe basing on real maximum and
     * major step size
     * 
     * @param float $min Real data minimum 
     * @param float $max Real data maximum
     * @return void
     */
    protected function calculateMaximum( $min, $max )
    {
        $this->max = ceil( $max / $this->majorStep ) * $this->majorStep;
    }

    /**
     * Calculate size of minor steps based on the size of the major step size
     *
     * @param float $min Real data minimum 
     * @param float $max Real data maximum
     * @return void
     */
    protected function calculateMinorStep( $min, $max )
    {
        $stepSize = $this->majorStep / self::MIN_MINOR_COUNT;
        $this->minorStep = $this->getNiceNumber( $stepSize );
    }

    /**
     * Calculate size of major step based on the span to be displayed and the
     * defined MIN_MAJOR_COUNT constant.
     *
     * @param float $min Real data minimum 
     * @param float $max Real data maximum
     * @return void
     */
    protected function calculateMajorStep( $min, $max )
    {
        $span = $max - $min;
        $stepSize = $span / self::MIN_MAJOR_COUNT;
        $this->majorStep = $this->getNiceNumber( $stepSize );
    }

    /**
     * Calculate steps, min and max values from given datasets, if not set 
     * manually before. receives an array of array( ezcGraphDataset )
     * 
     * @param array $datasets 
     * @return void
     */
    public function calculateFromDataset(array $datasets)
    {
        $min = false;
        $max = false;

        // Determine minimum and maximum values
        foreach ( $datasets as $dataset )
        {
            foreach ( $dataset as $value )
            {
                if ( $min === false ||
                     $value < $min )
                {
                    $min = $value;
                }

                if ( $max === false ||
                     $value > $max )
                {
                    $max = $value;
                }
            }
        }

        // Calculate "nice" values for scaling parameters
        if ( $this->majorStep === false )
        {
            $this->calculateMajorStep( $min, $max );
        }

        if ( $this->minorStep === false )
        {
            $this->calculateMinorStep( $min, $max );
        }

        if ( $this->min === false )
        {
            $this->calculateMinimum( $min, $max );
        }

        if ( $this->max === false )
        {
            $this->calculateMaximum( $min, $max );
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( ezcGraphBoundings $boundings, $value )
    {
        // Force typecast, because ( false < -100 ) results in (bool) true
        $floatValue = (float) $value;
        if ( ( $value === false ) &&
             ( ( $floatValue < $this->min ) || ( $floatValue > $this->max ) ) )
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->axisSpace / 2 );
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->axisSpace / 2 );
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->axisSpace / 2 );
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->axisSpace / 2 );
            }
        }
        else
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->axisSpace / 2 ) +
                            ( $value - $this->min ) / ( $this->max - $this->min ) * ( $boundings->y1 - $boundings-> y0 ) * ( 1 - $this->axisSpace );
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->axisSpace / 2 ) -
                            ( $value - $this->min ) / ( $this->max - $this->min ) * ( $boundings->y1 - $boundings-> y0 ) * ( 1 - $this->axisSpace );
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->axisSpace / 2 ) +
                            ( $value - $this->min ) / ( $this->max - $this->min ) * ( $boundings->x1 - $boundings-> x0 ) * ( 1 - $this->axisSpace );
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->axisSpace / 2 ) -
                            ( $value - $this->min ) / ( $this->max - $this->min ) * ( $boundings->x1 - $boundings-> x0 ) * ( 1 - $this->axisSpace );
            }
        }
    }

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    protected function getMinorStepCount()
    {
        return (int) ( ( $this->max - $this->min ) / $this->minorStep );
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    protected function getMajorStepCount()
    {
        return (int) ( ( $this->max - $this->min ) / $this->majorStep );
    }

    /**
     * Draw labels for an axis
     * 
     * @param ezcGraphRenderer $renderer 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphBoundings $boundings 
     * @return void
     */
    protected function drawLabels( ezcGraphRenderer $renderer, ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphBoundings $boundings )
    {
        // Draw major steps
        $steps = $this->getMajorStepCount();

        // Calculate stepsize
        $xStepsize = ( $end->x - $start->x ) / $steps;
        $yStepsize = ( $end->y - $start->y ) / $steps;

        // Caluclate datafree chart border
        $xBorder = abs ( ( $boundings->x1 - $boundings->x0 ) * ( $this->axisSpace / 2 ) );
        $yBorder = abs ( ( $boundings->y1 - $boundings->y0 ) * ( $this->axisSpace / 2 ) );

        for ( $i = 0; $i <= $steps; ++$i )
        {
            // Draw label
            if ( $i < $steps )
            {
                $label = $this->getLabel( $i );

                switch ( $this->position )
                {
                    case ezcGraph::LEFT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize + $this->labelPadding ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            (int) round( $xStepsize ) - $this->labelPadding,
                            $yBorder - $this->labelPadding,
                            ezcGraph::LEFT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::RIGHT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize + $xStepsize ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            (int) round( -$xStepsize ) - $this->labelPadding,
                            $yBorder - $this->labelPadding,
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
                            $xBorder - $this->labelPadding,
                            (int) round( -$yStepsize ) - $this->labelPadding,
                            ezcGraph::RIGHT | ezcGraph::BOTTOM
                        );
                        break;
                    case ezcGraph::TOP:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize - $xBorder ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            $xBorder - $this->labelPadding,
                            (int) round( $yStepsize ) - $this->labelPadding,
                            ezcGraph::RIGHT | ezcGraph::TOP
                        );
                        break;
                }
            }
            else
            {
                $label = $this->getLabel( $i-- );

                switch ( $this->position )
                {
                    case ezcGraph::LEFT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize + $this->labelPadding ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            (int) round( $xStepsize ) - $this->labelPadding,
                            $yBorder - $this->labelPadding,
                            ezcGraph::RIGHT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::RIGHT:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize + $xStepsize ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            (int) round( -$xStepsize ) - $this->labelPadding,
                            $yBorder - $this->labelPadding,
                            ezcGraph::LEFT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::BOTTOM:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize - $xBorder ),
                                (int) round( $start->y + $i * $yStepsize + $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            $xBorder - $this->labelPadding,
                            (int) round( -$yStepsize ) - $this->labelPadding,
                            ezcGraph::RIGHT | ezcGraph::TOP
                        );
                        break;
                    case ezcGraph::TOP:
                        $renderer->drawTextBox(
                            new ezcGraphCoordinate(
                                (int) round( $start->x + $i * $xStepsize - $xBorder ),
                                (int) round( $start->y + $i * $yStepsize + $this->labelPadding )
                            ),
                            $label,
                            $xBorder - $this->labelPadding,
                            (int) round( $yStepsize ) - $this->labelPadding,
                            ezcGraph::RIGHT | ezcGraph::BOTTOM
                        );
                        break;
                }
                ++$i;
            }
        }
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    protected function getLabel( $step )
    {
        return $this->min + ( $step * $this->majorStep );
    }
}

?>
