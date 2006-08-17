<?php
/**
 * ezcGraphPolynomTest 
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
class ezcGraphPolynomTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphPolynomTest" );
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

    public function testCreatePolynom()
    {
        $polynom = new ezcGraphPolynom( array( 2 => 1 ) );

        $this->assertEquals(
            'x^2',
            $polynom->__toString()
        );
    }

    public function testCreatePolynom2()
    {
        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );

        $this->assertEquals(
            '0.50 * x^2 + 3.00 * x + -4.50',
            $polynom->__toString()
        );
    }

    public function testPolynomGetOrder()
    {
        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );

        $this->assertEquals(
            2,
            $polynom->getOrder()
        );
    }

    public function testAddPolynom()
    {
        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );
        $polynom->add( new ezcGraphPolynom( array( 2 => 1 ) ) );

        $this->assertEquals(
            '1.50 * x^2 + 3.00 * x + -4.50',
            $polynom->__toString()
        );
    }

    public function testEvaluatePolynom()
    {
        $polynom = new ezcGraphPolynom( array( 2 => 1 ) );

        $this->assertEquals(
            4.,
            $polynom->evaluate( 2 ),
            'Calculated wrong value',
            .1
        );
    }

    public function testEvaluatePolynomNegativeValue()
    {
        $polynom = new ezcGraphPolynom( array( 2 => 1 ) );

        $this->assertEquals(
            4.,
            $polynom->evaluate( -2 ),
            'Calculated wrong value',
            .1
        );
    }

    public function testEvaluateComplexPolynom()
    {
        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );

        $this->assertEquals(
            9.,
            $polynom->evaluate( 3 ),
            'Calculated wrong value',
            .1
        );
    }
}

?>
