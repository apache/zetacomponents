<?php
/**
 * File containing the abstract ezcGraphChartElementLabeledAxis class
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
class ezcGraphChartElementLabeledAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Array with labeles for data 
     * 
     * @var array
     */
    protected $labels = array();

    protected function increaseKeys( $array, $startKey )
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
     * Get labels from datasets in right order to be rendered later
     *
     * @param array $datasets 
     * @return void
     */
    public function calculateFromDataset(array $datasets)
    {
        foreach ( $datasets as $dataset )
        {
            $position = 0;
            foreach ( $dataset as $label => $value )
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
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param ezcGraphBounding $boundings 
     * @param string $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( ezcGraphBoundings $boundings, $value )
    {
        if ( $value === false || 
             $value === null  ||
             ( $key = array_search( $value, $this->labels ) ) === false )
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 );
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 );
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 );
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 );
            }
        }
        else
        {
            switch ( $this->position )
            {
                case ezcGraph::TOP:
                    return $boundings->y0 +
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) +
                            ( $boundings->y1 - $boundings->y0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::BOTTOM:
                    return $boundings->y1 -
                            ( $boundings->y1 - $boundings->y0 ) * ( $this->padding / 2 ) -
                            ( $boundings->y1 - $boundings->y0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::LEFT:
                    return $boundings->x0 +
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) +
                            ( $boundings->x1 - $boundings->x0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
                case ezcGraph::RIGHT:
                    return $boundings->x1 -
                            ( $boundings->x1 - $boundings->x0 ) * ( $this->padding / 2 ) -
                            ( $boundings->x1 - $boundings->x0 ) * ( 1 - $this->padding ) / ( count ( $this->labels ) - 1 ) * $key;
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
        return 0;
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    protected function getMajorStepCount()
    {
        return count( $this->labels ) - 1;
    }

    protected function getLabel( $step )
    {
        if ( isset( $this->labels[$step] ) )
        {
            return $this->labels[$step];
        }
        else
        {
            return false;
        }
    }
}

?>
