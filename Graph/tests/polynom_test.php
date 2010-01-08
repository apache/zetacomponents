<?php
/**
 * ezcGraphPolynomTest 
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
class ezcGraphPolynomTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphPolynomTest" );
	}

    public function testCreatePolynom()
    {
        $polynom = new ezcGraphPolynom( array( 2 => 1 ) );

        $this->assertEquals(
            'x^2',
            $polynom->__toString()
        );
    }

    public function testInitPolynom()
    {
        $polynom = new ezcGraphPolynom();
        $polynom->init( 4 );

        $this->assertEquals(
            array( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0 ),
            $this->readAttribute( $polynom, 'values' ),
            'Values array not properly initialized.'
        );
    }

    public function testCreatePolynom2_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );

        $this->assertEquals(
            '5.0e-1 x^2 + 3.00 x - 4.50',
            $polynom->__toString()
        );
    }

    public function testCreatePolynom2()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 2 => .5, 1 => 3, 0 => -4.5 ) );

        $this->assertEquals(
            '5.00e-1 x^2 + 3.00 x - 4.50',
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
            '1.50 x^2 + 3.00 x - 4.50',
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

    public function testPolynomToString1_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 
            -109384,
            -19322,
            -9032,
            -984.2,
            -32.65,
            -5.613,
            -1,
            -.9345,
            -.0,
            -.03245,
            -.002346,
            -.0001326,
            -.00008327,
            -.000008437,
        ) );

        $this->assertEquals(
            '-8.4e-6 x^13 - 8.3e-5 x^12 - 1.3e-4 x^11 - 2.3e-3 x^10 - 3.2e-2 x^9 - 9.3e-1 x^7 - x^6 - 5.61 x^5 - 32.6 x^4 - 984 x^3 - 9.0e+3 x^2 - 1.9e+4 x - 1.1e+5',
            $polynom->__toString()
        );
    }

    public function testPolynomToString1()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 
            -109384,
            -19322,
            -9032,
            -984.2,
            -32.65,
            -5.613,
            -1,
            -.9345,
            -.0,
            -.03245,
            -.002346,
            -.0001326,
            -.00008327,
            -.000008437,
        ) );

        $this->assertEquals(
            '-8.44e-6 x^13 - 8.33e-5 x^12 - 1.33e-4 x^11 - 2.35e-3 x^10 - 3.24e-2 x^9 - 9.34e-1 x^7 - x^6 - 5.61 x^5 - 32.6 x^4 - 984 x^3 - 9.03e+3 x^2 - 1.93e+4 x - 1.09e+5',
            $polynom->__toString()
        );
    }

    public function testPolynomToString2_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 
            109384,
            19322,
            9032,
            984.2,
            32.65,
            5.613,
            1,
            .9345,
            .0,
            .03245,
            .002346,
            .0001326,
            .00008327,
            .000008437,
        ) );

        $this->assertEquals(
            '8.4e-6 x^13 + 8.3e-5 x^12 + 1.3e-4 x^11 + 2.3e-3 x^10 + 3.2e-2 x^9 + 9.3e-1 x^7 + x^6 + 5.61 x^5 + 32.6 x^4 + 984 x^3 + 9.0e+3 x^2 + 1.9e+4 x + 1.1e+5',
            $polynom->__toString()
        );
    }

    public function testPolynomToString2()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        $polynom = new ezcGraphPolynom( array( 
            109384,
            19322,
            9032,
            984.2,
            32.65,
            5.613,
            1,
            .9345,
            .0,
            .03245,
            .002346,
            .0001326,
            .00008327,
            .000008437,
        ) );

        $this->assertEquals(
            '8.44e-6 x^13 + 8.33e-5 x^12 + 1.33e-4 x^11 + 2.35e-3 x^10 + 3.24e-2 x^9 + 9.34e-1 x^7 + x^6 + 5.61 x^5 + 32.6 x^4 + 984 x^3 + 9.03e+3 x^2 + 1.93e+4 x + 1.09e+5',
            $polynom->__toString()
        );
    }
}

?>
