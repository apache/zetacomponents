<?php
/**
 * File containing the abstract ezcGraphChartElementAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Basic axis class
 *
 * @property float $nullPosition
 *           The position of the null value.
 * @property float $axisSpace
 *           Percent of the chart space used to display axis labels and 
 *           arrowheads instead of data values.
 * @property ezcGraphColor $majorGrid
 *           Color of major majorGrid.
 * @property ezcGraphColor $minorGrid
 *           Color of minor majorGrid.
 * @property mixed $majorStep
 *           Labeled major steps displayed on the axis.
 * @property mixed $minorStep
 *           Non labeled minor steps on the axis.
 * @property string $formatString
 *           Formatstring to use for labeling of the axis.
 * @property string $label
 *           Axis label
 * @property int $labelSize
 *           Size of axis label
 * @property int $labelMargin
 *           Distance between label an axis
 * @property int $maxArrowHeadSize
 *           Maximum Size used to draw arrow heads.
 * @property ezcGraphAxisLabelRenderer $axisLabelRenderer
 *           AxisLabelRenderer used to render labels and grid on this axis.
 *
 * @package Graph
 */
abstract class ezcGraphChartElementAxis extends ezcGraphChartElement
{
    /**
     * Axis label renderer class
     * 
     * @var ezcGraphAxisLabelRenderer
     */
    protected $axisLabelRenderer;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['nullPosition'] = false;
        $this->properties['axisSpace'] = .1;
        $this->properties['majorGrid'] = false;
        $this->properties['minorGrid'] = false;
        $this->properties['majorStep'] = null;
        $this->properties['minorStep'] = null;
        $this->properties['formatString'] = '%s';
        $this->properties['label'] = false;
        $this->properties['labelSize'] = 14;
        $this->properties['labelMargin'] = 2;
        $this->properties['maxArrowHeadSize'] = 8;

        parent::__construct( $options );

        if ( !isset( $this->axisLabelRenderer ) )
        {
            $this->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        }
    }

    /**
     * Set colors and border fro this element
     * 
     * @param ezcGraphPalette $palette Palette
     * @return void
     */
    public function setFromPalette( ezcGraphPalette $palette )
    {
        $this->border = $palette->axisColor;
        $this->padding = $palette->padding;
        $this->margin = $palette->margin;
        $this->majorGrid = $palette->majorGridColor;
        $this->minorGrid = $palette->minorGridColor;
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
                $this->properties['nullPosition'] = (float) $propertyValue;
                break;
            case 'axisSpace':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 1' );
                }

                $this->properties['axisSpace'] = (float) $propertyValue;
                break;
            case 'majorGrid':
                $this->properties['majorGrid'] = ezcGraphColor::create( $propertyValue );
                break;
            case 'minorGrid':
                $this->properties['minorGrid'] = ezcGraphColor::create( $propertyValue );
                break;
            case 'majorStep':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 0' );
                }
                
                $this->properties['majorStep'] = (float) $propertyValue;
                break;
            case 'minorStep':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 0' );
                }
                
                $this->properties['minorStep'] = (float) $propertyValue;
                break;
            case 'formatString':
                $this->properties['formatString'] = (string) $propertyValue;
                break;
            case 'label':
                $this->properties['label'] = (string) $propertyValue;
                break;
            case 'labelSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 6 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 6' );
                }
                
                $this->properties['labelSize'] = (int) $propertyValue;
                break;
            case 'labelMargin':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }
                
                $this->properties['labelMargin'] = (int) $propertyValue;
                break;
            case 'maxArrowHeadSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }
                
                $this->properties['maxArrowHeadSize'] = (int) $propertyValue;
                break;
            case 'axisLabelRenderer':
                if ( $propertyValue instanceof ezcGraphAxisLabelRenderer )
                {
                    $this->axisLabelRenderer = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphAxisLabelRenderer' );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
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
            case 'axisLabelRenderer':
                return $this->axisLabelRenderer;
            default:
                return parent::__get( $propertyName );
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    abstract public function getCoordinate( $value );

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    abstract public function getMinorStepCount();

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    abstract public function getMajorStepCount();

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    abstract public function getLabel( $step );

    /**
     * Return array of steps on this axis
     * 
     * @return array( ezcGraphAxisStep )
     */
    public function getSteps()
    {
        $majorSteps = $this->getMajorStepCount();
        $minorStepsPerMajorStepCount = ( $this->getMinorStepCount() / $majorSteps );

        $majorStepSize = 1 / $majorSteps;
        $minorStepSize = ( $minorStepsPerMajorStepCount > 0 ? $majorStepSize / $minorStepsPerMajorStepCount : 0 );

        $steps = array();
        for ( $major = 0; $major <= $majorSteps; ++$major )
        {
            $majorStep = new ezcGraphAxisStep(
                $majorStepSize * $major,
                $majorStepSize,
                $this->getLabel( $major ),
                array(),
                $this->isZeroStep( $major ),
                ( $major === $majorSteps )
            );

            if ( $minorStepsPerMajorStepCount > 0 )
            {
                // Do not add minor steps at major steps positions
                for( $minor = 1; $minor < $minorStepsPerMajorStepCount; ++$minor )
                {
                    $majorStep->childs[] = new ezcGraphAxisStep(
                        ( $majorStepSize * $major ) + ( $minorStepSize * $minor ),
                        $minorStepSize
                    );
                }
            }

            $steps[] = $majorStep;
        }

        return $steps;
    }

    /**
     * Is zero step
     *
     * Returns true if the given step is the one on the initial axis position
     * 
     * @param int $step Number of step
     * @return bool Status If given step is initial axis position
     */
    abstract public function isZeroStep( $step );

    /**
     * Add data for this axis
     * 
     * @param mixed $value Value which will be displayed on this axis
     * @return void
     */
    abstract public function addData( array $values );

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @abstract
     * @access public
     * @return void
     */
    abstract public function calculateAxisBoundings();

    /**
     * Render the axis 
     * 
     * @param ezcGraphRenderer $renderer Renderer
     * @param ezcGraphBoundings $boundings Boundings for the axis
     * @return ezcGraphBoundings Remaining boundings
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $start = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    0
                );
                $end = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    $boundings->y1 - $boundings->y0
                );
                break;
            case ezcGraph::BOTTOM:
                $start = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    $boundings->y1 - $boundings->y0
                );
                $end = new ezcGraphCoordinate(
                    ( $boundings->x1 - $boundings->x0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->x1 - $boundings->x0 ) * ( 1 - 2 * $this->axisSpace ),
                    0
                );
                break;
            case ezcGraph::LEFT:
                $start = new ezcGraphCoordinate(
                    0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                $end = new ezcGraphCoordinate(
                    $boundings->x1 - $boundings->x0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                break;
            case ezcGraph::RIGHT:
                $start = new ezcGraphCoordinate(
                    $boundings->x1 - $boundings->x0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                $end = new ezcGraphCoordinate(
                    0,
                    ( $boundings->y1 - $boundings->y0 ) * $this->axisSpace +
                        $this->nullPosition * ( $boundings->y1 - $boundings->y0 ) * ( 1 - 2 * $this->axisSpace )
                );
                break;
        }

        $renderer->drawAxis(
            $boundings,
            $start,
            $end,
            $this,
            $this->axisLabelRenderer
        );

        return $boundings;   
    }
}

?>
