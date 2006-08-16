<?php
/**
 * ezcGraphMatrixTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphMatrixTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphMatrixTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
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
            $this->getAttribute( $matrix, 'matrix' )
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
            $this->getAttribute( $matrix, 'matrix' )
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
            $this->getAttribute( $matrix, 'matrix' )
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
            $this->getAttribute( $matrix, 'matrix' )
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
            $this->getAttribute( $matrix, 'matrix' )
        );
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
            $this->getAttribute( $matrix, 'matrix' )
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
            $this->getAttribute( $c, 'matrix' )
        );
    }

    public function testMatrixMultiplication2()
    {
        $a = new ezcGraphMatrix( 2, 3, array(
            array( 1, 2, 3 ),
            array( 4, 5, 6 ),
        ) );
        $b = new ezcGraphMatrix( 3, 3, array(
            array( 6, -1 ),
            array( 3, 2 ),
            array( 0, -3 ),
        ) );

        try
        {
            $a->multiply( $b );
        }
        catch( ezcGraphMatrixInvalidDimensionsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphMatrixInvalidDimensionsException.' );
    }
}

?>
