<?php
/**
 * File containing the abstract ezcGraphMatrix class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Provides a genereic matrix class with basic math operations
 *
 * @package Graph
 */
class ezcGraphMatrix
{

    protected $columns;

    protected $rows;

    protected $matrix;

    /**
     * Constructor
     *
     * Creates a matrix with given dimensions. Optionally accepts an array to 
     * define the initial matrix values. If no array is given an identity 
     * matrix is created.
     * 
     * @param int $columns Number of columns
     * @param int $rows Number of rows
     * @param array $values Array with values
     * @return void
     */
    public function __construct( $columns = 3, $rows = 3, array $values = null )
    {
        $this->columns = max( 2, (int) $columns );
        $this->rows = max( 2, (int) $rows );

        if ( $values !== null )
        {
            $this->fromArray( $values );
        }
        else
        {
            $this->init();
        }
    }

    /**
     * Create matrix from array
     *
     * Use the array values to set matrix values
     * 
     * @param array $values Array with values
     * @return ezcGraphMatrix Modified matrix
     */
    public function fromArray( array $values )
    {
        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] =
                    ( isset( $values[$i][$j] )
                    ? (float) $values[$i][$j]
                    : 0 );
            }
        }

        return $this;
    }

    /**
     * Init matrix
     *
     * Sets matrix to identity matrix
     * 
     * @return ezcGraphMatrix Modified matrix
     */
    public function init()
    {
        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] = ( $i === $j ? 1 : 0 );
            }
        }

        return $this;
    }

    /**
     * Returns number of columns 
     * 
     * @return int Number of columns
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * Returns number of rows
     * 
     * @return int Number of rows
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Get a single matrix value
     *
     * Returns the value of the matrix at the given position
     * 
     * @param int $i Row
     * @param int $j Column
     * @return float Matrix value
     */
    public function get( $i, $j )
    {
        if ( !isset( $this->matrix[$i][$j] ) )
        {
            throw new ezcGraphMatrixOutOfBoundingsException( $this->columns, $this->rows, $i, $j );
        }

        return $this->matrix[$i][$j];
    }

    /**
     * Set a single matrix value
     *
     * Sets the value of the matrix at the given position
     * 
     * @param int $i Row
     * @param int $j Column
     * @param float $value Value
     * @return ezcGraphMatrix Updated matrix
     */
    public function set( $i, $j, $value )
    {
        if ( !isset( $this->matrix[$i][$j] ) )
        {
            throw new ezcGraphMatrixOutOfBoundingsException( $this->columns, $this->rows, $i, $j );
        }

        $this->matrix[$i][$j] = $value;

        return $this;
    }

    /**
     * Adds one matrix to the current one
     *
     * Calculate the sum of two matrices and returns the resulting matrix.
     * 
     * @param ezcGraphMatrix $matrix Matrix to sum with
     * @return ezcGraphMatrix Result matrix
     */
    public function add( ezcGraphMatrix $matrix )
    {
        if ( ( $this->columns !== $matrix->columns() ) ||
             ( $this->rows !== $matrix->rows() ) )
        {
            throw new ezcGraphMatrixInvalidDimensionsException( $this->columns, $this->rows, $matrix->columns(), $matrix->rows() );
        }

        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] += $matrix->get( $i, $j );
            }
        }

        return $this;
    }

    /**
     * Subtracts matrix from current one
     *
     * Calculate the diffenrence of two matices and returns the result matrix.
     * 
     * @param ezcGraphMatrix $matrix subtrahend
     * @return ezcGraphMatrix Result matrix
     */
    public function diff( ezcGraphMatrix $matrix )
    {
        if ( ( $this->columns !== $matrix->columns() ) ||
             ( $this->rows !== $matrix->rows() ) )
        {
            throw new ezcGraphMatrixInvalidDimensionsException( $this->columns, $this->rows, $matrix->columns(), $matrix->rows() );
        }

        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] -= $matrix->get( $i, $j );
            }
        }

        return $this;
    }

    /**
     * Scalar multiplication
     *
     * Multiplies matrix with the given scalar and returns the result matrix
     * 
     * @param float $scalar Scalar
     * @return ezcGraphMatrix Result matrix
     */
    public function scalar( $scalar )
    {
        $scalar = (float) $scalar;

        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] *= $scalar;
            }
        }
    }

    /**
     * Transpose matrix
     * 
     * @return ezcGraphMatrix Transposed matrix
     */
    public function transpose()
    {
        $matrix = clone $this;

        $this->rows = $matrix->columns();
        $this->columns = $matrix->rows();

        $this->matrix = array();

        for ( $i = 0; $i < $this->columns; ++$i )
        {
            for ( $j = 0; $j < $this->rows; ++$j )
            {
                $this->matrix[$i][$j] = $matrix->get( $j, $i );
            }
        }

        return $this;
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
        if ( $this->columns !== ( $mRows = $matrix->rows() ) ) 
        {
            throw new ezcGraphMatrixInvalidDimensionsException( $this->columns, $this->rows, $mColumns, $mRows );
        }

        $result = new ezcGraphMatrix( $mRows, $mRows );

		for ( $i = 0; $i < $this->columns; ++$i ) 
        {
			for ( $j = 0; $j < $mRows; ++$j ) 
            {
				$sum = 0;
				for ( $k = 0; $k < $mColumns; ++$k ) {
					$sum += $this->matrix[$i][$k] * $matrix->get( $k, $j );
				}

				$result->set( $i, $j, $sum );
			}
		}

        return $result;
    }
}
?>
