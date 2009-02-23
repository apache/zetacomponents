<?php
/**
 * ezcGraphBoundingsTest 
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
class ezcGraphBoundingsTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphBoundingsTest" );
	}

    public function testCreateBoundings()
    {
        $boundings = new ezcGraphBoundings( 0, 1, 10, 11 );

        $this->assertEquals( $boundings->x0, 0 );
        $this->assertEquals( $boundings->y0, 1 );
        $this->assertEquals( $boundings->x1, 10 );
        $this->assertEquals( $boundings->y1, 11 );
    }

    public function testPseudoProperties()
    {
        $boundings = new ezcGraphBoundings( 0, 1, 10, 21 );

        $this->assertEquals( $boundings->width, 10 );
        $this->assertEquals( $boundings->height, 20 );
    }

    public function testCreateReverseBoundings()
    {
        $boundings = new ezcGraphBoundings( 10, 11, 0, 1 );

        $this->assertEquals( $boundings->x0, 0 );
        $this->assertEquals( $boundings->y0, 1 );
        $this->assertEquals( $boundings->x1, 10 );
        $this->assertEquals( $boundings->y1, 11 );
    }

    public function testUnknownBoundingsProperty()
    {
        $boundings = new ezcGraphBoundings( 10, 11, 0, 1 );

        try
        {
            $boundings->unknown;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }
}

?>
