<?php
/**
 * ezcGraphMatrixTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphMatrixTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphMatrixTest" );
	}

    public function testCreateIdentityMatrix()
    {
        $matrix = new ezcGraphMatrix();

        $this->assertEquals(
            array(
                array( 1, 0, 0 ),
                array( 0, 1, 0 ),
                array( 0, 0, 1 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testCreateCustomIdentityMatrix()
    {
        $matrix = new ezcGraphMatrix( 2, 4 );

        $this->assertEquals(
            array(
                array( 1, 0, 0, 0 ),
                array( 0, 1, 0, 0 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testCreateCustomMatrix()
    {
        $matrix = new ezcGraphMatrix( 2, 4, array( array( 1, 0, 5 ), array( 6, -1, -3, .5 ) ) );

        $this->assertEquals(
            array(
                array( 1, 0, 5, 0 ),
                array( 6, -1, -3, .5 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testGetMatrixValue()
    {
        $matrix = new ezcGraphMatrix( );

        $this->assertEquals(
            1,
            $matrix->get( 1, 1 )
        );
    }

    public function testSetMatrixValue()
    {
        $matrix = new ezcGraphMatrix( );

        $matrix->set( 1, 2, .45 );

        $this->assertEquals(
            .45,
            $matrix->get( 1, 2 )
        );
    }

    public function testSetInvalidMatrixValue()
    {
        $matrix = new ezcGraphMatrix( );

        try
        {
            $matrix->set( 1, 32, .45 );
        }
        catch ( ezcGraphMatrixOutOfBoundingsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixOutOfBoundingsException.' );
    }

    public function testGetInvalidMatrixValue()
    {
        $matrix = new ezcGraphMatrix( );

        try
        {
            $matrix->get( 1, 32 );
        }
        catch ( ezcGraphMatrixOutOfBoundingsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixOutOfBoundingsException.' );
    }

    public function testAddMatrices()
    {
        $matrix = new ezcGraphMatrix();
        $matrix->add( new ezcGraphMatrix() );

        $this->assertEquals(
            array(
                array( 2, 0, 0 ),
                array( 0, 2, 0 ),
                array( 0, 0, 2 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testDiffMatrices()
    {
        $matrix = new ezcGraphMatrix();
        $matrix->diff( new ezcGraphMatrix() );

        $this->assertEquals(
            array(
                array( 0, 0, 0 ),
                array( 0, 0, 0 ),
                array( 0, 0, 0 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testDiffIncopatibleMatrices()
    {
        $matrix = new ezcGraphMatrix();

        try
        {
            $matrix->diff( new ezcGraphMatrix( 2, 4 ) );
        }
        catch (  ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }

    public function testAddIncompatibleMatrices()
    {
        $matrix = new ezcGraphMatrix();

        try
        {
            $matrix->add( new ezcGraphMatrix( 4, 4 ) );
        }
        catch ( ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }

    public function testDiffIncompatibleMatrices()
    {
        $matrix = new ezcGraphMatrix();

        try
        {
            $matrix->add( new ezcGraphMatrix( 4, 4 ) );
        }
        catch ( ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }

    public function testScalarMultiplication()
    {
        $matrix = new ezcGraphMatrix();
        $matrix->scalar( -.5 );

        $this->assertEquals(
            array(
                array( -.5, 0, 0 ),
                array( 0, -.5, 0 ),
                array( 0, 0, -.5 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testMatrixMultiplication()
    {
        $a = new ezcGraphMatrix( 2, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
        ) );
        $b = new ezcGraphMatrix( 3, 2, array(
            array( 6, -1 ),
            array( 3, 2 ),
            array( 0, -3 ),
        ) );

        $c = $a->multiply( $b );

        $this->assertEquals(
            array(
                array( 12, -6 ),
                array( 39, -12 ),
            ),
            $this->readAttribute( $c, 'matrix' )
        );
    }

    public function testMatrixMultiplicationInvalidDimensions()
    {
        $a = new ezcGraphMatrix( 3, 3, array(
            array( 6, -1 ),
            array( 3, 2 ),
            array( 0, -3 ),
        ) );
        $b = new ezcGraphMatrix( 2, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
        ) );

        try
        {
            $a->multiply( $b );
        }
        catch ( ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }

    public function testMatrixMultiplicationInvalidDimensions2()
    {
        $a = new ezcGraphMatrix( 3, 2, array(
            array( 6, -1 ),
            array( 3, 2 ),
            array( 0, -3 ),
        ) );
        $b = new ezcGraphMatrix( 3, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
        ) );

        try
        {
            $a->multiply( $b );
        }
        catch ( ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }

    public function testTransposeMatrix()
    {
        $matrix = new ezcGraphMatrix( 2, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
        ) );
        $matrix->transpose();

        $this->assertEquals(
            array(
                array( 1, 4 ),
                array( 2, 5 ),
                array( 3, 6 ),
            ),
            $this->readAttribute( $matrix, 'matrix' )
        );
    }

    public function testLRdecomposition()
    {
        $matrix = new ezcGraphMatrix( 3, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
            array( 7, 8, 10 ),
        ) );

        $dec = $matrix->LRdecomposition();

        $this->assertEquals(
            array(
                'l' => new ezcGraphMatrix( 3, 3, array( 
                    array( 1, 0, 0 ),
                    array( 4, 1, 0 ),
                    array( 7, 2, 1 ),
                ) ),
                'r' => new ezcGraphMatrix( 3, 3, array( 
                    array( 1, 2, 3 ),
                    array( 0, -3, -6 ),
                    array( 0, 0, 1 ),
                ) ),
            ),
            $dec
        );
    }

    public function testSolveNonlinearEquatation_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        $a = new ezcGraphMatrix( 3, 3, array(
            array( 5, 4, 7 ),
            array( 2, 12, 8 ),
            array( 3, 6, 10 ),
        ) );
        $b = new ezcGraphMatrix( 3, 1, array( 
            array( 1, 2, 3 ),
        ) );

        $polynom = $a->solveNonlinearEquatation( $b );

        $this->assertEquals(
            '-1.2e-1 x^2 + 1.9e-2 x + 3.5e-1',
            $polynom->__toString()
        );
    }

    public function testSolveNonlinearEquatation()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        $a = new ezcGraphMatrix( 3, 3, array(
            array( 5, 4, 7 ),
            array( 2, 12, 8 ),
            array( 3, 6, 10 ),
        ) );
        $b = new ezcGraphMatrix( 3, 1, array( 
            array( 1, 2, 3 ),
        ) );

        $polynom = $a->solveNonlinearEquatation( $b );

        $this->assertEquals(
            '-1.15e-1 x^2 + 1.92e-2 x + 3.46e-1',
            $polynom->__toString()
        );
    }

    public function testMatrixToString()
    {
        if ( version_compare( phpversion(), '5.2', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.2 or later." );
        }

        $matrix = new ezcGraphMatrix();

        $this->assertEquals(
'3 x 3 matrix:
| 1.00 0.00 0.00 |
| 0.00 1.00 0.00 |
| 0.00 0.00 1.00 |
',
            (string) $matrix,
            'Incorrect output for matrix.'
        );
    }
}

?>
