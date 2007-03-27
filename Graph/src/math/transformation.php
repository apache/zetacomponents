<?php
/**
 * File containing the ezcGraphTransformation class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Class defining transformations like scaling and rotation by a 
 * 3x3 transformation matrix for |R^2
 *
 * @package Graph
 * @access private
 */
class ezcGraphTransformation extends ezcGraphMatrix
{
    /**
     * Constructor
     *
     * Creates a matrix with 3x3 dimensions. Optionally accepts an array to 
     * define the initial matrix values. If no array is given an identity 
     * matrix is created.
     * 
     * @param int $rows
     * @param int $columns
     * @param array $values
     * @return void
     */
    public function __construct( array $values = null )
    {
        parent::__construct( 3, 3, $values );
    }

    /**
     * Multiplies two matrices
     *
     * Multiply current matrix with another matrix and returns the result 
     * matrix.
     *
     * @param ezcGraphMatrix $matrix Second factor
     * @returns ezcGraphMatrix Result matrix
     */
    public function multiply( ezcGraphMatrix $matrix ) 
    {
        $mColumns = $matrix->columns();

        // We want to ensure, that the matrix stays 3x3
        if ( ( $this->columns !== $matrix->rows() ) &&
             ( $this->rows !== $mColumns ) )
        {
            throw new ezcGraphMatrixInvalidDimensionsException( $this->columns, $this->rows, $mColumns, $matrix->rows() );
        }

        $result = parent::multiply( $matrix );

        // The matrix dimensions stay the same, so that we can modify $this.
        for ( $i = 0; $i < $this->rows; ++$i ) 
        {
            for ( $j = 0; $j < $mColumns; ++$j ) 
            {
                $this->set( $i, $j, $result->get( $i, $j ) );
            }
        }

        return $this;
    }

    /**
     * Transform a coordinate with the current transformation matrix.
     * 
     * @param ezcGraphCoordinate $coordinate 
     * @return ezcGraphCoordinate
     */
    public function transformCoordinate( ezcGraphCoordinate $coordinate )
    {
        $vector = new ezcGraphMatrix( 3, 1, array( array( $coordinate->x ), array( $coordinate->y ), array( 1 ) ) );
        $vector = parent::multiply( $vector );

        return new ezcGraphCoordinate( $vector->get( 0, 0 ), $vector->get( 1, 0 ) );
    }
}

?>
