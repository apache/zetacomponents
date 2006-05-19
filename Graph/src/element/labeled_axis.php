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
class ezcGraphChartElementLabeledAxis extends ezcGraphChartElement
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
     * Render an axe
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphBoundings $boundings )
    {
        return $boundings;   
    }

}
