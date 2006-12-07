<?php
/**
 * File containing the ezcGraphChartElementLabeledAxis class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a labeled axis. Values on the x axis are considered as 
 * strings and used in the given order.
 *
 * @package Graph
 * @mainclass
 */
class ezcGraphChartElementLabeledAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Array with labeles for data 
     * 
     * @var array
     */
    protected $labels = array();

    /**
     * Reduced amount of labels which will be displayed in the chart
     * 
     * @var array
     */
    protected $displayedLabels = array();

    /**
     * Maximum count of labels which can be displayed on one axis
     * @TODO: Perhaps base this on the chart size
     */
    const MAX_LABEL_COUNT = 10;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();

        parent::__construct( $options );
    }

    /**
     * Increase the keys of all elements in the array up from the start key, to
     * insert an additional element at the correct position.
     * 
     * @param array $array Array
     * @param int $startKey Key to increase keys from
     * @return array Updated array
     */
    protected function increaseKeys( array $array, $startKey )
    {
        foreach ( $array as $key => $value )
        {
            if ( $key === $startKey )
            {
                // Recursive check, if next key should be increased, too
                if ( isset ( $array[$key + 1] ) )
                {
                    $array = $this->increaseKeys( $array, $key + 1 );
                }

                // Increase key
                $array[$key + 1] = $array[$key];
                unset( $array[$key] );
            }
        }

        return $array;
    }

    /**
     * Add data for this axis
     * 
     * @param mixed $value Value which will be displayed on this axis
     * @return void
     */
    public function addData( array $values )
    {
        $position = 0;
        foreach ( $values as $label )
        {
            $label = (string) $label;

            if ( !in_array( $label, $this->labels, true ) )
            {
                if ( isset( $this->labels[$position] ) )
                {
                    $this->labels = $this->increaseKeys( $this->labels, $position );
                    $this->labels[$position++] = $label;
                }
                else
                {
                    $this->labels[$position++] = $label;
                }
            }
            else 
            {
                $position = array_search( $label, $this->labels, true ) + 1;
            }
        }
        ksort( $this->labels );
    }

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @abstract
     * @access public
     * @return void
     */
    public function calculateAxisBoundings()
    {
        $labelCount = count( $this->labels ) - 1;
        if ( $labelCount <= self::MAX_LABEL_COUNT )
        {
            $this->displayedLabels = $this->labels;
            return true;
        }

        for ( $div = self::MAX_LABEL_COUNT; $div > 0; --$div )
        {
            if ( ( $labelCount % $div ) === 0 )
            {
                $step = $labelCount / $div;
                foreach ( $this->labels as $nr => $label )
                {
                    if ( ( $nr % $step ) === 0 )
                    {
                        $this->displayedLabels[] = $label;
                    }
                }

                return true;
            }
        }
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param string $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( $value )
    {
        if ( $value === false || 
             $value === null  ||
             ( $key = array_search( $value, $this->labels ) ) === false )
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
                    return (float) $key / ( count ( $this->labels ) - 1 );
                case ezcGraph::BOTTOM:
                case ezcGraph::RIGHT:
                    return (float) 1 - $key / ( count ( $this->labels ) - 1 );
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
        return 0;
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    public function getMajorStepCount()
    {
        return count( $this->displayedLabels ) - 1;
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    public function getLabel( $step )
    {
        if ( isset( $this->displayedLabels[$step] ) )
        {
            return $this->displayedLabels[$step];
        }
        else
        {
            return false;
        }
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
        return !$step;
    }
}

?>
