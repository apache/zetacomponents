<?php
/**
 * ezcGraphRenderer2dTest 
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
class ezcGraphRenderer2dTest extends ezcTestCase
{

    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphRenderer2dTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        $this->renderer = new ezcGraphRenderer2D();

        $this->driver = $this->getMock( 'ezcGraphGdDriver', array(
            'drawPolygon',
            'drawLine',
            'drawTextBox',
            'drawCircleSector',
            'drawCircularArc',
            'drawCircle',
            'drawImage',
        ) );
        $this->renderer->setDriver( $this->driver );
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        $this->driver->verify();
    }

    public function testRenderLine()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 100 ) ),
                $this->equalTo( new ezcGraphCoordinate( 113, 157 ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) )
            );

        $this->renderer->drawLine(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            new ezcGraphCoordinate( 113, 157 )
        );
    }

    public function testRenderTextBox()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Drawing TextBox' ),
                $this->equalTo( new ezcGraphCoordinate( 100, 100 ) ),
                $this->equalTo( 100 ),
                $this->equalTo( 50 ),
                $this->equalTo( ezcGraph::LEFT )
            );

        $this->renderer->drawTextBox(
            new ezcGraphCoordinate( 100, 100 ),
            'Drawing TextBox',
            100,
            50
        );
    }

    public function testRenderSymbolNone()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 100, 100 ),
                    new ezcGraphCoordinate( 120, 100 ),
                    new ezcGraphCoordinate( 120, 120 ),
                    new ezcGraphCoordinate( 100, 120 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                true
            );

        $this->renderer->drawSymbol(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            20,
            20
        );
    }

    public function testRenderSymbolDiamond()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 110, 100 ),
                    new ezcGraphCoordinate( 120, 110 ),
                    new ezcGraphCoordinate( 110, 120 ),
                    new ezcGraphCoordinate( 100, 110 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                true
            );

        $this->renderer->drawSymbol(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            20,
            20,
            ezcGraph::DIAMOND
        );
    }

    public function testRenderSymbolBullet()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 110, 110 ) ),
                $this->equalTo( 20 ),
                $this->equalTo( 20 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawSymbol(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            20,
            20,
            ezcGraph::BULLET
        );
    }

    public function testRenderSymbolCircle()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 110, 110 ) ),
                $this->equalTo( 20 ),
                $this->equalTo( 20 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawSymbol(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            20,
            20,
            ezcGraph::CIRCLE
        );
    }

    public function testRenderRect()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 100, 100 ),
                    new ezcGraphCoordinate( 150, 100 ),
                    new ezcGraphCoordinate( 150, 150 ),
                    new ezcGraphCoordinate( 100, 150 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawRect(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            50,
            50
        );
    }

    public function testRenderThickRect()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 100, 100 ),
                    new ezcGraphCoordinate( 150, 100 ),
                    new ezcGraphCoordinate( 150, 150 ),
                    new ezcGraphCoordinate( 100, 150 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false ),
                $this->equalTo( 2 )
            );

        $this->renderer->drawRect(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            50,
            50,
            2
        );
    }

    public function testRenderPieSegment()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 100 ) ),
                $this->equalTo( 200 ),
                $this->equalTo( 200 ),
                $this->equalTo( 20 ),
                $this->equalTo( 124 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 100 ) ),
                $this->equalTo( 200 ),
                $this->equalTo( 200 ),
                $this->equalTo( 20 ),
                $this->equalTo( 124 ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawPieSegment(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            100,
            20,
            124
        );
    }

    public function testRenderPieSegmentMoveOut()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 95, 100 ) ),
                $this->equalTo( 200 ),
                $this->equalTo( 200 ),
                $this->equalTo( 90 ),
                $this->equalTo( 270 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 95, 100 ) ),
                $this->equalTo( 200 ),
                $this->equalTo( 200 ),
                $this->equalTo( 90 ),
                $this->equalTo( 270 ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawPieSegment(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            100,
            90,
            270,
            5
        );
    }

    public function testRenderBackground()
    {
        $this->driver
            ->expects( $this->once() )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 100, 100 ),
                    new ezcGraphCoordinate( 150, 100 ),
                    new ezcGraphCoordinate( 150, 150 ),
                    new ezcGraphCoordinate( 100, 150 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                true
            );

        $this->renderer->drawBackground(
            ezcGraphColor::fromHex( '#FF0000' ),
            new ezcGraphCoordinate( 100, 100 ),
            50,
            50
        );
    }
}
?>
