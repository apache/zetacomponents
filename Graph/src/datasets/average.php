<?php
/**
 * File containing the abstract ezcGraphDataSetAverage class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Extension of basic dataset to represent averation.
 * Algorithm: http://en.wikipedia.org/wiki/Least_squares
 *
 * @package Graph
 */
class ezcGraphDataSetAveragePolynom extends ezcGraphDataSet 
{
    protected $polynomOrder = 3;

    protected $source;

    protected $resolution = 5;

    protected $polynom = false;

    public function __construct( ezcGraphDataSet $dataset )
    {
        $this->source = $dataset;
    }

    /**
     * Options write access
     * 
     * @throws ezcBasePropertyNotFoundException
     *          If Option could not be found
     * @throws ezcBaseValueException
     *          If value is out of range
     * @param mixed $propertyName   Option name
     * @param mixed $propertyValue  Option value;
     * @return mixed
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'polynomOrder':
                $this->polynomOrder = (int) $propertyValue;
                $this->polynom = false;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
    
    protected function buildPolynom()
    {
        $points = array();

        foreach ( $this->source as $key => $value )
        {
            $points[] = new ezcGraphCoordinate( (float) $key, (float) $value );
        }

        // Build transposed and normal Matrix out of coordiantes
        $a = new ezcGraphMatrix( count( $points ), $this->polynomOrder + 1 );
        $b = new ezcGraphMatrix( count( $points ), 1 );

        for ( $i = 0; $i <= $this->polynomOrder; ++$i )
        {
            foreach ( $points as $nr => $point )
            {
                $a->set( $nr, $i, pow( $point->x, $i ) );
                $b->set( $nr, 0, $point->y );
            }
        }

        $at = clone $a;
        $at->transpose();
        
        $left = $at->multiply( $a );
        $right = $at->multiply( $b );

        $this->polynom = $left->solveNonlinearEquatation( $right );
    }

    public function getPolynom()
    {
        if ( $this->polynom === false )
        {
            $this->buildPolynom();
        }

        return $this->polynom;
    }
}
?>
