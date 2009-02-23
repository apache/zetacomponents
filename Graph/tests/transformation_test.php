<?php
/**
 * ezcGraphTransformationTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphTransformationTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphTransformationTest" );
	}

    public function testCreateTransformation()
    {
        $transformation = new ezcGraphTransformation();
        $matrix = new ezcGraphMatrix( 3, 3 );

        $this->assertEquals(
            $this->readAttribute( $matrix, 'matrix' ),
            $this->readAttribute( $transformation, 'matrix' ),
            'Transformation matrices are not aequivalent',
            .0001
        );
    }

    public function testCreateTransformation2()
    {
        $transformation = new ezcGraphTransformation(
            array(
                array( 2, 1, 0 ),
                array( 2, 1, 0 ),
                array( 2, 1, 0 ),
            )
        );

        $matrix = new ezcGraphMatrix( 3, 3,
            array(
                array( 2, 1, 0 ),
                array( 2, 1, 0 ),
                array( 2, 1, 0 ),
            )
        );

        $this->assertEquals(
            $this->readAttribute( $matrix, 'matrix' ),
            $this->readAttribute( $transformation, 'matrix' ),
            'Transformation matrices are not aequivalent',
            .0001
        );
    }

    public function testCreateTranslation()
    {
        $transformation = new ezcGraphTranslation( 5, 5 );

        $matrix = new ezcGraphMatrix( 3, 3,
            array(
                array( 1, 0, 5 ),
                array( 0, 1, 5 ),
                array( 0, 0, 1 ),
            )
        );

        $this->assertEquals(
            $this->readAttribute( $matrix, 'matrix' ),
            $this->readAttribute( $transformation, 'matrix' ),
            'Transformation matrices are not aequivalent',
            .0001
        );
    }

    public function testTranslateMultiplicationInvalidDimension()
    {
        $a = new ezcGraphTranslation( 3, 2 );
        $b = new ezcGraphMatrix( 4, 3, array(
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

    public function testTranslateCoordinate()
    {
        $transformation = new ezcGraphTranslation( 5, 5 );

        $testCoordinate = new ezcGraphCoordinate( 0, 0 );
        $testCoordinate = $transformation->transformCoordinate( $testCoordinate );

        $this->assertEquals(
            new ezcGraphCoordinate( 5, 5 ),
            $testCoordinate,
            'Transformation of coordinate has wrong result.',
            .0001
        );
    }

    public function testCreateRotation()
    {
        $transformation = new ezcGraphRotation( 90 );

        $matrix = new ezcGraphMatrix( 3, 3,
            array(
                array( 0, -1, 0 ),
                array( 1, 0, 0 ),
                array( 0, 0, 1 ),
            )
        );

        $this->assertEquals(
            $this->readAttribute( $matrix, 'matrix' ),
            $this->readAttribute( $transformation, 'matrix' ),
            'Transformation matrices are not aequivalent',
            .0001
        );
    }

    public function testRotationGetCenter()
    {
        $transformation = new ezcGraphRotation( 90 );

        $this->assertEquals(
            new ezcGraphCoordinate( 0, 0 ),
            $transformation->getCenter()
        );
    }

    public function testRotationGetRotation()
    {
        $transformation = new ezcGraphRotation( 17 );

        $this->assertEquals(
            17.,
            $transformation->getRotation()
        );
    }

    public function testCreateTranslatedRotation()
    {
        $transformation = new ezcGraphRotation( 90, new ezcGraphCoordinate( 10, 10 ) );

        $matrix = new ezcGraphMatrix( 3, 3,
            array(
                array( 0, 1, 0 ),
                array( -1, 0, 0 ),
                array( 0, 0, 1 ),
            )
        );

        $testCoordinate = new ezcGraphCoordinate( 0, 0 );
        $testCoordinate = $transformation->transformCoordinate( $testCoordinate );

        $this->assertEquals(
            new ezcGraphCoordinate( 20, 0 ),
            $testCoordinate,
            'Transformation matrices are not aequivalent',
            .0001
        );
    }
}

?>
