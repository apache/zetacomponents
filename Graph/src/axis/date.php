<?php
/**
 * File containing the ezcGraphChartElementDateAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent date axis. Date axis will try to find a "nice" interval
 * based on the values on the x axis. If non numeric values are given, 
 * ezcGraphChartElementDateAxis will convert them to timestamps using PHPs 
 * strtotime function.
 *
 * It is always possible to set start date, end date and the interval manually
 * by yourself.
 *
 * @property float $startDate
 *           Starting date used to display on axis.
 * @property float $endDate
 *           End date used to display on axis.
 * @property float $interval
 *           Time interval between steps on axis.
 * @property string $dateFormat
 *           Format of date string
 *           Like http://php.net/date
 *
 * @package Graph
 */
class ezcGraphChartElementDateAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Minimum inserted date
     * 
     * @var int
     */
    protected $minValue = false;

    /**
     * Maximum inserted date 
     * 
     * @var int
     */
    protected $maxValue = false;

    /**
     * Nice time intervals to used if there is no user defined interval
     * 
     * @var array
     */
    protected $predefinedIntervals = array(
        // Second
        1           => 'H:i.s',
        // Ten seconds
        10          => 'H:i.s',
        // Thirty seconds
        30          => 'H:i.s',
        // Minute
        60          => 'H:i',
        // Ten minutes
        600         => 'H:i',
        // Half an hour
        1800        => 'H:i',
        // Hour
        3600        => 'H:i',
        // Four hours
        14400       => 'H:i',
        // Six hours
        21600       => 'H:i',
        // Half a day
        43200       => 'd.m a',
        // Day
        86400       => 'd.m',
        // Week
        604800      => 'W',
        // Month
        2629800     => 'M y',
        // Year
        31536000    => 'Y',
        // Decade
        315360000   => 'Y',
    );

    /**
     * Constant used for calculation of automatic definition of major scaling 
     * steps
     */
    const MAJOR_COUNT = 10;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['startDate'] = false;
        $this->properties['endDate'] = false;
        $this->properties['interval'] = false;
        $this->properties['dateFormat'] = false;

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
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'startDate':
                $this->properties['startDate'] = (int) $propertyValue;
                break;
            case 'endDate':
                $this->properties['endDate'] = (int) $propertyValue;
                break;
            case 'interval':
                $this->properties['interval'] = (int) $propertyValue;
                break;
            case 'dateFormat':
                $this->properties['dateFormat'] = (string) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Add data for this axis
     * 
     * @param mixed $value Value which will be displayed on this axis
     * @return void
     */
    public function addData( array $values )
    {
        foreach ( $values as $value )
        {
            if ( is_int( $value ) || is_float( $value ) )
            {
                $value = (int) $value;
            }
            elseif ( ( $value = strtotime( $value ) ) === false )
            {
                throw new ezcGraphErrorParsingDateException( $value );
            }

            if ( $this->minValue === false ||
                 $value < $this->minValue )
            {
                $this->minValue = $value;
            }

            if ( $this->maxValue === false ||
                 $value > $this->maxValue )
            {
                $this->maxValue = $value;
            }
        }
    }

    /**
     * Calculate nice time interval
     *
     * Use the best fitting time interval defined in class property array
     * predefinedIntervals.
     * 
     * @param int $min Start time
     * @param int $max End time
     * @return void
     */
    protected function calculateInterval( $min, $max )
    {
        $diff = $max - $min;

        foreach ( $this->predefinedIntervals as $interval => $format )
        {
            if ( ( $diff / $interval ) <= self::MAJOR_COUNT )
            {
                break;
            }
        }

        $this->properties['interval'] = $interval;
    }

    /**
     * Calculate lower nice date
     *
     * Calculates a date which is earlier or equal to the given date, and is
     * divisible by the given interval.
     * 
     * @param int $min Date
     * @param int $interval Interval 
     * @return int Earlier date
     */
    protected function calculateLowerNiceDate( $min, $interval )
    {
        $dateSteps = array( 60, 60, 24, 7, 52 );

        $date = array(
            (int) date( 's', $min ),
            (int) date( 'i', $min ),
            (int) date( 'H', $min ),
            (int) date( 'd', $min ),
            (int) date( 'm', $min ),
            (int) date( 'Y', $min ),
        );

        $element = 0;
        while ( ( $step = array_shift( $dateSteps ) ) &&
                ( $interval > $step ) )
        {
            $interval /= $step;
            $date[$element++] = (int) ( $element > 2 );
        }

        $date[$element] -= $date[$element] % $interval;

        return mktime(
            $date[2],
            $date[1],
            $date[0],
            $date[4],
            $date[3],
            $date[5]
        );
    }

    /**
     * Calculate start date
     *
     * Use calculateLowerNiceDate to get a date earlier or equal date then the 
     * minimum date to use it as the start date for the axis depending on the
     * selected interval.
     * 
     * @param mixed $min Minimum date
     * @param mixed $max Maximum date
     * @return void
     */
    public function calculateMinimum( $min, $max )
    {
        $this->properties['startDate'] = $this->calculateLowerNiceDate( $min, $this->interval );
    }

    /**
     * Calculate end date
     *
     * Use calculateLowerNiceDate to get a date later or equal date then the 
     * maximum date to use it as the end date for the axis depending on the
     * selected interval.
     * 
     * @param mixed $min Minimum date
     * @param mixed $max Maximum date
     * @return void
     */
    public function calculateMaximum( $min, $max )
    {
        $this->properties['endDate'] = $this->calculateLowerNiceDate( $max, $this->interval );

        while ( $this->properties['endDate'] < $max )
        {
            $this->properties['endDate'] += $this->interval;
        }
    }

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @return void
     */
    public function calculateAxisBoundings()
    {
        // Prevent division by zero, when min == max
        if ( $this->minValue == $this->maxValue )
        {
            if ( $this->minValue == 0 )
            {
                $this->maxValue = 1;
            }
            else
            {
                $this->minValue -= ( $this->minValue * .1 );
                $this->maxValue += ( $this->maxValue * .1 );
            }
        }

        // Use custom minimum and maximum if available
        if ( $this->properties['startDate'] !== false )
        {
            $this->minValue = $this->properties['startDate'];
        }

        if ( $this->properties['endDate'] !== false )
        {
            $this->maxValue = $this->properties['endDate'];
        }

        // Calculate "nice" values for scaling parameters
        if ( $this->properties['interval'] === false )
        {
            $this->calculateInterval( $this->minValue, $this->maxValue );
        }

        if ( $this->properties['dateFormat'] === false && isset( $this->predefinedIntervals[$this->interval] ) )
        {
            $this->properties['dateFormat'] = $this->predefinedIntervals[$this->interval];
        }

        if ( $this->properties['startDate'] === false )
        {
            $this->calculateMinimum( $this->minValue, $this->maxValue );
        }

        if ( $this->properties['endDate'] === false )
        {
            $this->calculateMaximum( $this->minValue, $this->maxValue );
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param float $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( $value )
    {
        // Force typecast, because ( false < -100 ) results in (bool) true
        $floatValue = (float) $value;

        if ( ( $value === false ) &&
             ( ( $floatValue < $this->properties['startDate'] ) || ( $floatValue > $this->endDate ) ) )
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    return 0.;
                case ezcGraph::RIGHT:
                case ezcGraph::BOTTOM:
                    return 1.;
            }
        }
        else
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    return ( $value - $this->properties['startDate'] ) / ( $this->endDate - $this->startDate );
                case ezcGraph::RIGHT:
                case ezcGraph::BOTTOM:
                    return 1 - ( $value - $this->properties['startDate'] ) / ( $this->endDate - $this->startDate );
            }
        }
    }

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    public function getMinorStepCount()
    {
        return false;
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    public function getMajorStepCount()
    {
        return (int) ( ( $this->properties['endDate'] - $this->startDate ) / $this->interval );
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    public function getLabel( $step )
    {
        return date( $this->properties['dateFormat'], $this->startDate + ( $step * $this->interval ) );
    }

    /**
     * Is zero step
     *
     * Returns true if the given step is the one on the initial axis position
     * 
     * @param int $step Number of step
     * @return bool Status If given step is initial axis position
     */
    public function isZeroStep( $step )
    {
        return ( $step == 0 );
    }
}

?>
