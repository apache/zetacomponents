<?php
/**
 * ezcGraphStructTest 
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
class ezcGraphStructTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphStructTest" );
	}

    public function testCreateContext()
    {
        $context = new ezcGraphContext( 'set', 'point', 'url://' );

        $this->assertSame(
            'set',
            $context->dataset,
            'Wrong value when reading public property dataset in ezcGraphContext.'
        );

        $this->assertSame(
            'point',
            $context->datapoint,
            'Wrong value when reading public property datapoint in ezcGraphContext.'
        );

        $this->assertSame(
            'url://',
            $context->url,
            'Wrong value when reading public property url in ezcGraphContext.'
        );

        $context->dataset = 'set 2';
        $context->datapoint = 'point 2';
        $context->url = 'url://2';

        $this->assertSame(
            'set 2',
            $context->dataset,
            'Wrong value when reading public property dataset in ezcGraphContext.'
        );

        $this->assertSame(
            'point 2',
            $context->datapoint,
            'Wrong value when reading public property datapoint in ezcGraphContext.'
        );

        $this->assertSame(
            'url://2',
            $context->url,
            'Wrong value when reading public property url in ezcGraphContext.'
        );
    }

    public function testContextUnknowPropertySet()
    {
        $context = new ezcGraphContext( 'set', 'point' );

        try
        {
            $context->unknown = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testContextUnknowPropertyGet()
    {
        $context = new ezcGraphContext( 'set', 'point' );

        try
        {
            $context->unknown;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testContextSetState()
    {
        $context = new ezcGraphContext();

        $context->__set_state(
        array(
            'dataset' => 'set',
            'datapoint' => 'point',
        ) );

        $this->assertSame(
            'set',
            $context->dataset,
            'Wrong value when reading public property dataset in ezcGraphContext.'
        );

        $this->assertSame(
            'point',
            $context->datapoint,
            'Wrong value when reading public property datapoint in ezcGraphContext.'
        );
    }

    public function testContextSetStateWithURL()
    {
        $context = new ezcGraphContext();

        $context->__set_state(
        array(
            'dataset' => 'set',
            'datapoint' => 'point',
            'url' => 'url://',
        ) );

        $this->assertSame(
            'set',
            $context->dataset,
            'Wrong value when reading public property dataset in ezcGraphContext.'
        );

        $this->assertSame(
            'point',
            $context->datapoint,
            'Wrong value when reading public property datapoint in ezcGraphContext.'
        );

        $this->assertSame(
            'url://',
            $context->url,
            'Wrong value when reading public property url in ezcGraphContext.'
        );
    }

    public function testCreateCoordinate()
    {
        $context = new ezcGraphCoordinate( 23, 42 );

        $this->assertSame(
            23,
            $context->x,
            'Wrong value when reading public property x in ezcGraphCoordinate.'
        );

        $this->assertSame(
            42,
            $context->y,
            'Wrong value when reading public property y in ezcGraphCoordinate.'
        );

        $context->x = 5;
        $context->y = 12;

        $this->assertSame(
            5,
            $context->x,
            'Wrong value when reading public property x in ezcGraphCoordinate.'
        );

        $this->assertSame(
            12,
            $context->y,
            'Wrong value when reading public property y in ezcGraphCoordinate.'
        );
    }

    public function testCoordinateUnknowPropertySet()
    {
        $context = new ezcGraphCoordinate( 23, 42 );

        try
        {
            $context->unknown = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testCoordinateUnknowPropertyGet()
    {
        $context = new ezcGraphCoordinate( 23, 42 );

        try
        {
            $context->unknown;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testCoordinateSetState()
    {
        $context = new ezcGraphCoordinate( 0, 0 );

        $context->__set_state(
        array(
            'x' => 23,
            'y' => 42,
        ) );

        $this->assertSame(
            23,
            $context->x,
            'Wrong value when reading public property x in ezcGraphCoordinate.'
        );

        $this->assertSame(
            42,
            $context->y,
            'Wrong value when reading public property y in ezcGraphCoordinate.'
        );
    }

    public function testCoordinateToString()
    {
        $coordinate = new ezcGraphCoordinate( 2, 5 );

        $this->assertSame(
            '( 2.00, 5.00 )',
            $coordinate->__toString(),
            'Wrong value when converting ezcGraphCoordinate to string.'
        );
    }

    public function testStepSetState()
    {
        $step = new ezcGraphAxisStep();

        $step->__set_state(
        array(
            'position' => .4,
            'width' => .2,
            'label' => 'Label',
            'childs' => array(),
            'isZero' => true,
            'isLast' => false,
        ) );

        $this->assertSame(
            .4,
            $step->position,
            'Wrong value when reading public property position in ezcGraphContext.'
        );

        $this->assertSame(
            .2,
            $step->width,
            'Wrong value when reading public property width in ezcGraphContext.'
        );

        $this->assertSame(
            'Label',
            $step->label,
            'Wrong value when reading public property label in ezcGraphContext.'
        );

        $this->assertSame(
            array(),
            $step->childs,
            'Wrong value when reading public property childs in ezcGraphContext.'
        );

        $this->assertSame(
            true,
            $step->isZero,
            'Wrong value when reading public property isZero in ezcGraphContext.'
        );

        $this->assertSame(
            false,
            $step->isLast,
            'Wrong value when reading public property isLast in ezcGraphContext.'
        );
    }
}
?>
