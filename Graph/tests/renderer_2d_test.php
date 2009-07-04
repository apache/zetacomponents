<?php
/**
 * ezcGraphRenderer2dTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphRenderer2dTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $renderer;

    protected $driver;

	public static function suite()
	{
	    return new PHPUnit_Framework_TestSuite( "ezcGraphRenderer2dTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.1.3 or later." );
        }

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->renderer = new ezcGraphRenderer2d();

        $this->driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawPolygon',
            'drawLine',
            'drawTextBox',
            'drawCircleSector',
            'drawCircularArc',
            'drawCircle',
            'drawImage',
        ) );
        $this->renderer->setDriver( $this->driver );

        $this->driver->options->width = 400;
        $this->driver->options->height = 200;
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }
// /*
    public function testRenderLabeledPieSegment()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200, 100 ), 1. ),
                $this->equalTo( 180, 1. ),
                $this->equalTo( 180, 1. ),
                $this->equalTo( 15, 1. ),
                $this->equalTo( 156, 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200, 100 ), 1. ),
                $this->equalTo( 180, 1. ),
                $this->equalTo( 180, 1. ),
                $this->equalTo( 15, 1. ),
                $this->equalTo( 156, 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 205., 166. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 250., 190. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#000000' ) ),
                $this->equalTo( 1 )
            );

        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 205., 166. ), 1. ),
                $this->equalTo( 6 ),
                $this->equalTo( 6 ),
                $this->equalTo( ezcGraphColor::fromHex( '#000000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 4 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 250., 190. ), 1. ),
                $this->equalTo( 6 ),
                $this->equalTo( 6 ),
                $this->equalTo( ezcGraphColor::fromHex( '#000000' ) ),
                $this->equalTo( true )
            );

        $this->driver
            ->expects( $this->at( 5 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Testlabel' ),
                $this->equalTo( new ezcGraphCoordinate( 256., 180. ), 1. ),
                $this->equalTo( 144.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 36 )
            );


        // Render
        $this->renderer->drawPieSegment(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            'Testlabel',
            0
        );

        $this->renderer->render( $this->tempDir . '/' . __METHOD__ . '.svg' );
    }

    public function testRenderNonLabeledPieSegment()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 15., 1. ),
                $this->equalTo( 156., 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 15., 1. ),
                $this->equalTo( 156., 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        // Render
        $this->renderer->drawPieSegment(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            false,
            0
        );

        $this->renderer->render( $this->tempDir . '/' . __METHOD__ . '.svg' );
    }

    public function testRenderNonLabeledPieSegmentMoveOut()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 201., 109. ), 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 15., 1. ),
                $this->equalTo( 156., 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawCircleSector' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 201., 109. ), 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 180., 1. ),
                $this->equalTo( 15., 1. ),
                $this->equalTo( 156., 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        // Render
        $this->renderer->drawPieSegment(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            false,
            true
        );

        $this->renderer->render( $this->tempDir . '/' . __METHOD__ . '.svg' );
    }

    public function testRenderLotsOfLabeledPieSegments()
    {
        $this->driver
            ->expects( $this->at( 13 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 5' ),
                $this->equalTo( new ezcGraphCoordinate( 0, 180. ), 1. ),
                $this->equalTo( 144.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 40 )
            );
        $this->driver
            ->expects( $this->at( 17 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 1' ),
                $this->equalTo( new ezcGraphCoordinate( 307., 120. ), 1. ),
                $this->equalTo( 92.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 21 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 2' ),
                $this->equalTo( new ezcGraphCoordinate( 298.5, 140. ), 1. ),
                $this->equalTo( 101.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 25 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 3' ),
                $this->equalTo( new ezcGraphCoordinate( 283.5, 160. ), 1. ),
                $this->equalTo( 116.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 29 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 4' ),
                $this->equalTo( new ezcGraphCoordinate( 255.5, 180. ), 1. ),
                $this->equalTo( 144.5, 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 36 )
            );

        // Render
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), new ezcGraphContext(), ezcGraphColor::fromHex( '#FF0000' ), 15, 27, 'Label 1', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), new ezcGraphContext(), ezcGraphColor::fromHex( '#FF0000' ), 27, 38, 'Label 2', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), new ezcGraphContext(), ezcGraphColor::fromHex( '#FF0000' ), 38, 45, 'Label 3', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), new ezcGraphContext(), ezcGraphColor::fromHex( '#FF0000' ), 45, 70, 'Label 4', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), new ezcGraphContext(), ezcGraphColor::fromHex( '#FF0000' ), 70, 119, 'Label 5', true );

        $this->renderer->render( $this->tempDir . '/' . __METHOD__ . '.svg' );
    }

    public function testRenderBar()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array( 
                    new ezcGraphCoordinate( 157.5, 0. ),
                    new ezcGraphCoordinate( 157.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 0. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array( 
                    new ezcGraphCoordinate( 157.5, 0. ),
                    new ezcGraphCoordinate( 157.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 0. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawBar( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .5, .2 ),
            100,
            0,
            1,
            0
        );
    }

    public function testRenderSecondBar()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array( 
                    new ezcGraphCoordinate( 157.5, 0. ),
                    new ezcGraphCoordinate( 157.5, 40. ),
                    new ezcGraphCoordinate( 197.5, 40. ),
                    new ezcGraphCoordinate( 197.5, 0. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawBar( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .5, .2 ),
            100,
            1,
            2,
            0
        );
    }

    public function testRenderStackedBar()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array( 
                    new ezcGraphCoordinate( 155, 40. ),
                    new ezcGraphCoordinate( 155, 120. ),
                    new ezcGraphCoordinate( 245, 120. ),
                    new ezcGraphCoordinate( 245, 40. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array( 
                    new ezcGraphCoordinate( 155, 40. ),
                    new ezcGraphCoordinate( 155, 120. ),
                    new ezcGraphCoordinate( 245, 120. ),
                    new ezcGraphCoordinate( 245, 40. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#800000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawStackedBar( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .5, .2 ),
            new ezcGraphCoordinate( .5, .6 ),
            100,
            0
        );
    }

    public function testRenderDataLine()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 40., 40. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 60. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .1, .2 ),
            new ezcGraphCoordinate( .7, .3 )
        );
    }

    public function testRenderFilledDataLine()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 40., 40. ),
                    new ezcGraphCoordinate( 280., 60. ),
                    new ezcGraphCoordinate( 280., 0. ),
                    new ezcGraphCoordinate( 40., 0. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 40., 40. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 60. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .1, .2 ),
            new ezcGraphCoordinate( .7, .3 ),
            0,
            1,
            ezcGraph::NO_SYMBOL,
            null, 
            ezcGraphColor::fromHex( '#FF0000DD' ), 
            .0
        );
    }

    public function testRenderFilledDataLineWithIntersection()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 40., 100. ),
                    new ezcGraphCoordinate( 40., 40. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 280., 100. ),
                    new ezcGraphCoordinate( 280., 140. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 40., 40. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 140. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .1, .2 ),
            new ezcGraphCoordinate( .7, .7 ),
            0,
            1,
            ezcGraph::NO_SYMBOL,
            null, 
            ezcGraphColor::fromHex( '#FF0000DD' ), 
            .5
        );
    }

    public function testRenderRadarDataLine()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200., 50. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 300., 100. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawRadarDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( 200., 100. ),
            new ezcGraphCoordinate( 0., .5 ),
            new ezcGraphCoordinate( .25, .5 )
        );
    }

    public function testRenderFilledRadarDataLine()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 200., 50. ),
                    new ezcGraphCoordinate( 300., 100. ),
                    new ezcGraphCoordinate( 200., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200., 50. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 300., 100. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawRadarDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( 200., 100. ),
            new ezcGraphCoordinate( 0., .5 ),
            new ezcGraphCoordinate( .25, .5 ),
            0,
            1,
            ezcGraph::NO_SYMBOL,
            null, 
            ezcGraphColor::fromHex( '#FF0000DD' )
        );
    }

    public function testRenderFilledRadarDataLineWithSymbol()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 200., 50. ),
                    new ezcGraphCoordinate( 300., 100. ),
                    new ezcGraphCoordinate( 200., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 200., 50. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 300., 100. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 300., 97. ),
                    new ezcGraphCoordinate( 303., 100. ),
                    new ezcGraphCoordinate( 300., 103. ),
                    new ezcGraphCoordinate( 297., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawRadarDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( 200., 100. ),
            new ezcGraphCoordinate( 0., .5 ),
            new ezcGraphCoordinate( .25, .5 ),
            0,
            1,
            ezcGraph::DIAMOND,
            ezcGraphColor::fromHex( '#FF0000' ), 
            ezcGraphColor::fromHex( '#FF0000DD' )
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
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' )
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
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' ),
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
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' ),
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
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' ),
            ezcGraph::CIRCLE
        );
    }

    public function testRenderSymbolSquare()
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
                $this->equalTo( true )
            );

        $this->renderer->drawSymbol(
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' ),
            ezcGraph::SQUARE
        );
    }

    public function testRenderSymbolBox()
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
                $this->equalTo( false )
            );

        $this->renderer->drawSymbol(
            new ezcGraphBoundings( 100, 100, 120, 120 ),
            ezcGraphColor::fromHex( '#FF0000' ),
            ezcGraph::BOX
        );
    }

    public function testRenderFilledDataLineWithSymbolSameColor()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 40., 100. ),
                    new ezcGraphCoordinate( 40., 40. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 280., 100. ),
                    new ezcGraphCoordinate( 280., 140. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 40., 40. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 140. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 280, 140 ) ),
                $this->equalTo( 6 ),
                $this->equalTo( 6 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .1, .2 ),
            new ezcGraphCoordinate( .7, .7 ),
            0,
            1,
            ezcGraph::CIRCLE,
            null, 
            ezcGraphColor::fromHex( '#FF0000DD' ), 
            .5
        );
        $this->renderer->render( $this->tempDir . __METHOD__ . 'svg' );
    }

    public function testRenderFilledDataLineWithSymbolInDifferentColorAndCustomSize()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 40., 100. ),
                    new ezcGraphCoordinate( 40., 40. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 280., 100. ),
                    new ezcGraphCoordinate( 280., 140. ),
                    new ezcGraphCoordinate( 184., 100. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000DD' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 40., 40. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 140. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 280, 140 ) ),
                $this->equalTo( 10 ),
                $this->equalTo( 10 ),
                $this->equalTo( ezcGraphColor::fromHex( '#00FF00' ) ),
                $this->equalTo( true )
            );

        $this->renderer->options->symbolSize = 10;

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            new ezcGraphContext(),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .1, .2 ),
            new ezcGraphCoordinate( .7, .7 ),
            0,
            1,
            ezcGraph::BULLET,
            ezcGraphColor::fromHex( '#00FF00' ), 
            ezcGraphColor::fromHex( '#FF0000DD' ), 
            .5
        );
        $this->renderer->render( $this->tempDir . __METHOD__ . 'svg' );
    }

    public function testRenderBox()
    {
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 1. ),
                    new ezcGraphCoordinate( 399., 1. ),
                    new ezcGraphCoordinate( 399., 199. ),
                    new ezcGraphCoordinate( 1., 199. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 2., 2. ),
                    new ezcGraphCoordinate( 398., 2. ),
                    new ezcGraphCoordinate( 398., 198. ),
                    new ezcGraphCoordinate( 2., 198. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#BB0000' ) ),
                $this->equalTo( true )
            );

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#BB0000' ), 
            ezcGraphColor::fromHex( '#FF0000' ), 
            1,
            1,
            1
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 3., 3., 397., 197. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderBoxDifferentPadding()
    {
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 3., 3. ),
                    new ezcGraphCoordinate( 397., 3. ),
                    new ezcGraphCoordinate( 397., 197. ),
                    new ezcGraphCoordinate( 3., 197. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 3., 3. ),
                    new ezcGraphCoordinate( 397., 3. ),
                    new ezcGraphCoordinate( 397., 197. ),
                    new ezcGraphCoordinate( 3., 197. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#BB0000' ) ),
                $this->equalTo( true )
            );

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#BB0000' ), 
            ezcGraphColor::fromHex( '#FF0000' ), 
            2,
            3,
            4
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 9., 9., 391., 191. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderBoxWithoutBorder()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 1. ),
                    new ezcGraphCoordinate( 399., 1. ),
                    new ezcGraphCoordinate( 399., 199. ),
                    new ezcGraphCoordinate( 1., 199. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#BB0000' ) ),
                $this->equalTo( true )
            );

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#BB0000' ), 
            null, 
            0,
            1,
            1
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 2., 2., 398., 198. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderBoxWithoutBackground()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 1. ),
                    new ezcGraphCoordinate( 399., 1. ),
                    new ezcGraphCoordinate( 399., 199. ),
                    new ezcGraphCoordinate( 1., 199. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            null, 
            ezcGraphColor::fromHex( '#FF0000' ), 
            1,
            1,
            1
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 3., 3., 397., 197. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderBoxWithTitle()
    {
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 1. ),
                    new ezcGraphCoordinate( 399., 1. ),
                    new ezcGraphCoordinate( 399., 199. ),
                    new ezcGraphCoordinate( 1., 199. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 2., 2. ),
                    new ezcGraphCoordinate( 398., 2. ),
                    new ezcGraphCoordinate( 398., 198. ),
                    new ezcGraphCoordinate( 2., 198. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#BB0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Boxtitle' ),
                $this->equalTo( new ezcGraphCoordinate( 3., 3. ), 1. ),
                $this->equalTo( 394., 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 48 )
            );

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#BB0000' ), 
            ezcGraphColor::fromHex( '#FF0000' ), 
            1,
            1,
            1,
            'Boxtitle',
            20
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 3., 24., 397., 176. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderBoxWithBottomTitleAndLeftAlignement()
    {
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 1. ),
                    new ezcGraphCoordinate( 399., 1. ),
                    new ezcGraphCoordinate( 399., 199. ),
                    new ezcGraphCoordinate( 1., 199. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 2., 2. ),
                    new ezcGraphCoordinate( 398., 2. ),
                    new ezcGraphCoordinate( 398., 198. ),
                    new ezcGraphCoordinate( 2., 198. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#BB0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Boxtitle' ),
                $this->equalTo( new ezcGraphCoordinate( 3., 177. ), 1. ),
                $this->equalTo( 394., 1. ),
                $this->equalTo( 20., 1. ),
                $this->equalTo( 4 )
            );

        $this->renderer->options->titleAlignement = ezcGraph::LEFT;
        $this->renderer->options->titlePosition = ezcGraph::BOTTOM;

        $boundings = $this->renderer->drawBox( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#BB0000' ), 
            ezcGraphColor::fromHex( '#FF0000' ), 
            1,
            1,
            1,
            'Boxtitle',
            20
        );

        $this->assertEquals(
            $boundings,
            new ezcGraphBoundings( 3., 3., 397., 176. ),
            'Returned boundings are not as expected.',
            1.
        );
    }

    public function testRenderText()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'A common test string is "foobar"' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 400., 1. ),
                $this->equalTo( 200., 1. ),
                $this->equalTo( 20 )
            );

        $this->renderer->drawText( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            'A common test string is "foobar"',
            20
        );
    }

    public function testRenderBackgroundImage()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 125., 43.5 ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg'
        );
    }

    public function testRenderTopLeftBackgroundImage()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::TOP | ezcGraph::LEFT
        );
    }

    public function testRenderBottomRightBackgroundImage()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT
        );
    }

    public function testRenderToBigBackgroundImage()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 100., 1. ),
                $this->equalTo( 100., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 100, 100 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT
        );
    }

    public function testRenderBackgroundImageRepeatX()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 150., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 300., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::HORIZONTAL
        );
    }

    public function testRenderBackgroundImageRepeatY()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::VERTICAL
        );
    }

    public function testRenderBackgroundImageRepeatBoth()
    {
        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 150., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $this->driver
            ->expects( $this->at( 5 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 300., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $this->renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::VERTICAL | ezcGraph::HORIZONTAL
        );
    }

    public function testRenderVerticalLegendSymbols()
    {
        $chart = new ezcGraphLineChart();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->color = '#0000FF';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData']->color = '#FF0000';
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData']->color = '#00FF00';
        $chart->data['evenMoreData']->label = 'Even more data';

        $chart->legend->generateFromDataSets( $chart->data );

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 8., 1. ),
                    new ezcGraphCoordinate( 15., 8. ),
                    new ezcGraphCoordinate( 8., 15. ),
                    new ezcGraphCoordinate( 1., 8. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 19. ),
                    new ezcGraphCoordinate( 15., 19. ),
                    new ezcGraphCoordinate( 15., 33. ),
                    new ezcGraphCoordinate( 1., 33. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 4 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 1., 37. ),
                    new ezcGraphCoordinate( 15., 37. ),
                    new ezcGraphCoordinate( 15., 51. ),
                    new ezcGraphCoordinate( 1., 51. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#00FF00' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawLegend(
            new ezcGraphBoundings( 0, 0, 100, 200 ),
            $chart->legend
        );
    }

    public function testRenderVerticalLegendText()
    {
        $chart = new ezcGraphLineChart();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->color = '#0000FF';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData']->color = '#FF0000';
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData']->color = '#00FF00';
        $chart->data['evenMoreData']->label = 'Even more data';

        $chart->legend->generateFromDataSets( $chart->data );

        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'sampleData' ),
                $this->equalTo( new ezcGraphCoordinate( 16., 1. ), 1. ),
                $this->equalTo( 83., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'moreData' ),
                $this->equalTo( new ezcGraphCoordinate( 16., 19. ), 1. ),
                $this->equalTo( 83., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 5 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Even more data' ),
                $this->equalTo( new ezcGraphCoordinate( 16., 37. ), 1. ),
                $this->equalTo( 83., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );

        $this->renderer->drawLegend(
            new ezcGraphBoundings( 0, 0, 100, 200 ),
            $chart->legend
        );
    }

    public function testRenderHorizontalLegendSymbols()
    {
        $chart = new ezcGraphLineChart();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->color = '#0000FF';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData']->color = '#FF0000';
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData']->color = '#00FF00';
        $chart->data['evenMoreData']->label = 'Even more data';

        $chart->legend->generateFromDataSets( $chart->data );

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 8., 1. ),
                    new ezcGraphCoordinate( 15., 8. ),
                    new ezcGraphCoordinate( 8., 15. ),
                    new ezcGraphCoordinate( 1., 8. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 101., 1. ),
                    new ezcGraphCoordinate( 115., 1. ),
                    new ezcGraphCoordinate( 115., 15. ),
                    new ezcGraphCoordinate( 101., 15. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 4 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 201., 1. ),
                    new ezcGraphCoordinate( 215., 1. ),
                    new ezcGraphCoordinate( 215., 15. ),
                    new ezcGraphCoordinate( 201., 15. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#00FF00' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawLegend(
            new ezcGraphBoundings( 0, 0, 300, 50 ),
            $chart->legend,
            ezcGraph::HORIZONTAL
        );
    }

    public function testRenderHorizontalLegendText()
    {
        $chart = new ezcGraphLineChart();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->color = '#0000FF';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData']->color = '#FF0000';
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData']->color = '#00FF00';
        $chart->data['evenMoreData']->label = 'Even more data';

        $chart->legend->generateFromDataSets( $chart->data );

        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'sampleData' ),
                $this->equalTo( new ezcGraphCoordinate( 16., 1. ), 1. ),
                $this->equalTo( 81., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'moreData' ),
                $this->equalTo( new ezcGraphCoordinate( 116., 1. ), 1. ),
                $this->equalTo( 81., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 5 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Even more data' ),
                $this->equalTo( new ezcGraphCoordinate( 216., 1. ), 1. ),
                $this->equalTo( 81., 1. ),
                $this->equalTo( 14., 1. ),
                $this->equalTo( 36 )
            );

        $this->renderer->drawLegend(
            new ezcGraphBoundings( 0, 0, 300, 50 ),
            $chart->legend,
            ezcGraph::HORIZONTAL
        );
    }
    
    public function testRenderVerticalAxis()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->yAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 220. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 20. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 140., 20. ),
                    new ezcGraphCoordinate( 142.5, 25. ),
                    new ezcGraphCoordinate( 137.5, 25. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 40, 200 ),
            new ezcGraphCoordinate( 40, 0 ),
            $chart->yAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }
    
    public function testRenderVerticalShortAxis()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->yAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 40. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 140., 40. ),
                    new ezcGraphCoordinate( 142, 45. ),
                    new ezcGraphCoordinate( 138, 45. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->options->shortAxis = true;
        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 40, 200 ),
            new ezcGraphCoordinate( 40, 0 ),
            $chart->yAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }
    
    public function testRenderVerticalAxisReverse()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->yAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 220. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 140., 220. ),
                    new ezcGraphCoordinate( 137.5, 215. ),
                    new ezcGraphCoordinate( 142.5, 215. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 40, 0 ),
            new ezcGraphCoordinate( 40, 200 ),
            $chart->yAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }
    
    public function testRenderHorizontalAxis()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->yAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 150., 120. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 450., 120. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 450., 120. ),
                    new ezcGraphCoordinate( 442., 124. ),
                    new ezcGraphCoordinate( 442., 116. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 50, 100 ),
            new ezcGraphCoordinate( 350, 100 ),
            $chart->yAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }
    
    public function testRenderHorizontalShortAxis()
    {
        $chart = new ezcGraphLineChart();
        $chart->xAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->xAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 120. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 120. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 460., 120. ),
                    new ezcGraphCoordinate( 452, 124. ),
                    new ezcGraphCoordinate( 452, 116. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->options->shortAxis = true;
        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 0, 100 ),
            new ezcGraphCoordinate( 400, 100 ),
            $chart->xAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }
    
    public function testRenderHorizontalAxisReverse()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->addData( array( 1, 2, 3, 4, 5 ) );
        $chart->yAxis->calculateAxisBoundings();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 450., 120. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 150., 120. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 150., 120. ),
                    new ezcGraphCoordinate( 157., 116.5 ),
                    new ezcGraphCoordinate( 157., 123.5 ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 350, 100 ),
            new ezcGraphCoordinate( 50, 100 ),
            $chart->yAxis,
            new ezcGraphAxisCenteredLabelRenderer(),
            new ezcGraphBoundings( 140, 40, 460, 200 )
        );
    }

    public function testRenderLineChartToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        ob_start();
        // Suppress header already sent warning
        @$chart->renderToOutput( 500, 200 );
        file_put_contents( $filename, ob_get_clean() );

        $this->compare(
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg',
            $filename
        );
    }

    public function testRenderLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg',
            $filename
        );
    }

    public function testRenderLineChartZeroAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->xAxis->axisSpace = .0;
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = .0;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderFilledLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithMoreBarsThenMajorSteps()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->legend = false;

        $chart->xAxis = new ezcGraphChartElementNumericAxis();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->data['dataset'] = new ezcGraphArrayDataSet( array( 12, 43, 324, 12, 43, 125, 120, 123 , 543,  12, 45, 76, 87 , 99, 834, 34, 453 ) );
        $chart->data['dataset']->color = '#3465A47F';

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderFilledLineBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 0']->displayType = ezcGraph::BAR;
        $chart->data['Line 1']->displayType = ezcGraph::BAR;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderFilledLineChartWithAxisIntersection()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -151, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => -5, 'sample 5' => -124) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithDifferentAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );
        
        $chart->xAxis->axisSpace = .2;
        $chart->yAxis->axisSpace = .05;
        
        $chart->driver = new ezcGraphSvgDriver();
        
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartDifferentDataBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer->options->dataBorder = .1;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithHighlightAndOffset()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer->options->pieChartOffset = 76;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithOffset()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->renderer->options->pieChartOffset = 156;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithLegendTitle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->legend->title = 'Legenda';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithModifiedSymbolColor()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer->options->pieChartSymbolColor = '#000000BB';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Opera'] = true;
        $chart->renderer->options->pieChartShadowSize = 5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithGleamAndShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Opera'] = true;
        $chart->renderer->options->legendSymbolGleam = .5;
        $chart->renderer->options->pieChartShadowSize = 5;
        $chart->renderer->options->pieChartGleamBorder = 3;
        $chart->renderer->options->pieChartGleam = .5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithAxisLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->label = 'Samples';
        $chart->yAxis->label = 'Numbers';

        $chart->driver = new ezcGraphSvgDriver();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithAxisLabelsReversedAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->label = 'Samples';
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->label = 'Numbers';
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();

        $chart->driver = new ezcGraphSvgDriver();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithHighlightedData()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 1']->highlight = true;
        $chart->data['Line 2']->highlight['sample 5'] = true;

        $chart->options->highlightSize = 12;
        $chart->options->highlightFont->color = ezcGraphColor::fromHex( '#3465A4' );
        $chart->options->highlightFont->background = ezcGraphColor::fromHex( '#D3D7CF' );
        $chart->options->highlightFont->border = ezcGraphColor::fromHex( '#888A85' );
        
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithHighlightedData3Bars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );
        $chart->data['Line 3'] = new ezcGraphArrayDataSet( array( 'sample 2' => 42, 'sample 3' => 398, 'sample 4' => -15, 'sample 5' => 244) );

        $chart->data['Line 1']->highlight = true;
        $chart->data['Line 2']->highlight['sample 5'] = true;
        $chart->data['Line 3']->highlight = true;

        $chart->options->highlightSize = 12;
        $chart->options->highlightFont->color = ezcGraphColor::fromHex( '#3465A4' );
        $chart->options->highlightFont->background = ezcGraphColor::fromHex( '#D3D7CF' );
        $chart->options->highlightFont->border = ezcGraphColor::fromHex( '#888A85' );
        
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithHighlightedData()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 1']->highlight = true;
        $chart->data['Line 2']->highlight['sample 5'] = true;
        
        $chart->data['Line 1']->displayType = ezcGraph::BAR;

        $chart->options->highlightSize = 12;
        $chart->options->highlightFont->color = ezcGraphColor::fromHex( '#3465A4' );
        $chart->options->highlightFont->background = ezcGraphColor::fromHex( '#D3D7CF' );
        $chart->options->highlightFont->border = ezcGraphColor::fromHex( '#888A85' );
        
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBug11107_MissingGridWithBottomLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testNoArrowHead()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->renderer->options->axisEndStyle = ezcGraph::NO_SYMBOL;

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testCircleArrowHead()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->renderer->options->axisEndStyle = ezcGraph::CIRCLE;

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testShortAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->renderer->options->axisEndStyle = ezcGraph::NO_SYMBOL;
        $graph->renderer->options->shortAxis    = true;

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testSquareAndBoxSymbolsInChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();

        $graph->data['sample1'] = new ezcGraphArrayDataSet( array( 1, 4, 6, 8, 2 ) );
        $graph->data['sample1']->symbol = ezcGraph::SQUARE;
        $graph->data['sample2'] = new ezcGraphArrayDataSet( array( 4, 6, 8, 2, 1 ) );
        $graph->data['sample2']->symbol = ezcGraph::BOX;

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRotatedAxisLabel()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();

        $graph->data['sample1'] = new ezcGraphArrayDataSet( array( 1, 4, 6, 8, 2 ) );
        $graph->data['sample1']->symbol = ezcGraph::SQUARE;
        $graph->data['sample2'] = new ezcGraphArrayDataSet( array( 4, 6, 8, 2, 1 ) );
        $graph->data['sample2']->symbol = ezcGraph::BOX;

        $graph->xAxis->label = "Some axis label";
        $graph->xAxis->labelRotation = 90;

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRendererOptionsPropertyMaxLabelHeight()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .1,
            $options->maxLabelHeight,
            'Wrong default value for property maxLabelHeight in class ezcGraphRendererOptions'
        );

        $options->maxLabelHeight = .2;
        $this->assertSame(
            .2,
            $options->maxLabelHeight,
            'Setting property value did not work for property maxLabelHeight in class ezcGraphRendererOptions'
        );

        try
        {
            $options->maxLabelHeight = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyShowSymbol()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            true,
            $options->showSymbol,
            'Wrong default value for property showSymbol in class ezcGraphRendererOptions'
        );

        $options->showSymbol = false;
        $this->assertSame(
            false,
            $options->showSymbol,
            'Setting property value did not work for property showSymbol in class ezcGraphRendererOptions'
        );

        try
        {
            $options->showSymbol = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertySyncAxisFonts()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            true,
            $options->syncAxisFonts,
            'Wrong default value for property syncAxisFonts in class ezcGraphRendererOptions'
        );

        $options->syncAxisFonts = false;
        $this->assertSame(
            false,
            $options->syncAxisFonts,
            'Setting property value did not work for property syncAxisFonts in class ezcGraphRendererOptions'
        );

        try
        {
            $options->syncAxisFonts = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertySymbolSize()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            6,
            $options->symbolSize,
            'Wrong default value for property symbolSize in class ezcGraphRendererOptions'
        );

        $options->symbolSize = 8;
        $this->assertSame(
            8,
            $options->symbolSize,
            'Setting property value did not work for property symbolSize in class ezcGraphRendererOptions'
        );

        try
        {
            $options->symbolSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyMoveOut()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .1,
            $options->moveOut,
            'Wrong default value for property moveOut in class ezcGraphRendererOptions'
        );

        $options->moveOut = .2;
        $this->assertSame(
            .2,
            $options->moveOut,
            'Setting property value did not work for property moveOut in class ezcGraphRendererOptions'
        );

        try
        {
            $options->moveOut = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyTitlePosition()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            ezcGraph::TOP,
            $options->titlePosition,
            'Wrong default value for property titlePosition in class ezcGraphRendererOptions'
        );

        $options->titlePosition = ezcGraph::BOTTOM;
        $this->assertSame(
            ezcGraph::BOTTOM,
            $options->titlePosition,
            'Setting property value did not work for property titlePosition in class ezcGraphRendererOptions'
        );

        try
        {
            $options->titlePosition = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyTitleAlignement()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            ezcGraph::MIDDLE | ezcGraph::CENTER,
            $options->titleAlignement,
            'Wrong default value for property titleAlignement in class ezcGraphRendererOptions'
        );

        $options->titleAlignement = ezcGraph::BOTTOM;
        $this->assertSame(
            ezcGraph::BOTTOM,
            $options->titleAlignement,
            'Setting property value did not work for property titleAlignement in class ezcGraphRendererOptions'
        );

        try
        {
            $options->titleAlignement = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyDataBorder()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .5,
            $options->dataBorder,
            'Wrong default value for property dataBorder in class ezcGraphRendererOptions'
        );

        $options->dataBorder = 1.;
        $this->assertSame(
            1.,
            $options->dataBorder,
            'Setting property value did not work for property dataBorder in class ezcGraphRendererOptions'
        );

        $options->dataBorder = false;
        $this->assertSame(
            false,
            $options->dataBorder,
            'Setting property value did not work for property dataBorder in class ezcGraphRendererOptions'
        );

        try
        {
            $options->dataBorder = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyBarMargin()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .1,
            $options->barMargin,
            'Wrong default value for property barMargin in class ezcGraphRendererOptions'
        );

        $options->barMargin = .2;
        $this->assertSame(
            .2,
            $options->barMargin,
            'Setting property value did not work for property barMargin in class ezcGraphRendererOptions'
        );

        try
        {
            $options->barMargin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyBarPadding()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .05,
            $options->barPadding,
            'Wrong default value for property barPadding in class ezcGraphRendererOptions'
        );

        $options->barPadding = .1;
        $this->assertSame(
            .1,
            $options->barPadding,
            'Setting property value did not work for property barPadding in class ezcGraphRendererOptions'
        );

        try
        {
            $options->barPadding = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyPieChartOffset()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            0,
            $options->pieChartOffset,
            'Wrong default value for property pieChartOffset in class ezcGraphRendererOptions'
        );

        $options->pieChartOffset = 1;
        $this->assertSame(
            1.,
            $options->pieChartOffset,
            'Setting property value did not work for property pieChartOffset in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieChartOffset = 450;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyLegendSymbolGleam()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            false,
            $options->legendSymbolGleam,
            'Wrong default value for property legendSymbolGleam in class ezcGraphRendererOptions'
        );

        $options->legendSymbolGleam = .1;
        $this->assertSame(
            .1,
            $options->legendSymbolGleam,
            'Setting property value did not work for property legendSymbolGleam in class ezcGraphRendererOptions'
        );

        $options->legendSymbolGleam = false;
        $this->assertSame(
            false,
            $options->legendSymbolGleam,
            'Setting property value did not work for property legendSymbolGleam in class ezcGraphRendererOptions'
        );

        try
        {
            $options->legendSymbolGleam = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyLegendSymbolGleamSize()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .9,
            $options->legendSymbolGleamSize,
            'Wrong default value for property legendSymbolGleamSize in class ezcGraphRendererOptions'
        );

        $options->legendSymbolGleamSize = .8;
        $this->assertSame(
            .8,
            $options->legendSymbolGleamSize,
            'Setting property value did not work for property legendSymbolGleamSize in class ezcGraphRendererOptions'
        );

        try
        {
            $options->legendSymbolGleamSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyLegendSymbolGleamColor()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FFFFFF' ),
            $options->legendSymbolGleamColor,
            'Wrong default value for property pieChartSymbolColor in class ezcGraphRendererOptions'
        );

        $options->legendSymbolGleamColor = $color = ezcGraphColor::fromHex( '#000000' );
        $this->assertSame(
            $color,
            $options->legendSymbolGleamColor,
            'Setting property value did not work for property pieChartSymbolColor in class ezcGraphRendererOptions'
        );

        try
        {
            $options->legendSymbolGleamColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }


    public function testRendererOptionsPropertyPieVerticalSize()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .5,
            $options->pieVerticalSize,
            'Wrong default value for property pieVerticalSize in class ezcGraphRendererOptions'
        );

        $options->pieVerticalSize = .6;
        $this->assertSame(
            .6,
            $options->pieVerticalSize,
            'Setting property value did not work for property pieVerticalSize in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieVerticalSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyPieHorizontalSize()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            .25,
            $options->pieHorizontalSize,
            'Wrong default value for property pieHorizontalSize in class ezcGraphRendererOptions'
        );

        $options->pieHorizontalSize = .5;
        $this->assertSame(
            .5,
            $options->pieHorizontalSize,
            'Setting property value did not work for property pieHorizontalSize in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieHorizontalSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyPieChartSymbolColor()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000' ),
            $options->pieChartSymbolColor,
            'Wrong default value for property pieChartSymbolColor in class ezcGraphRendererOptions'
        );

        $options->pieChartSymbolColor = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->pieChartSymbolColor,
            'Setting property value did not work for property pieChartSymbolColor in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieChartSymbolColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testRendererOptionsPropertyPieChartGleam()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            false,
            $options->pieChartGleam,
            'Wrong default value for property pieChartGleam in class ezcGraphRendererOptions'
        );

        $options->pieChartGleam = .2;
        $this->assertSame(
            .2,
            $options->pieChartGleam,
            'Setting property value did not work for property pieChartGleam in class ezcGraphRendererOptions'
        );

        $options->pieChartGleam = false;
        $this->assertSame(
            false,
            $options->pieChartGleam,
            'Setting property value did not work for property pieChartGleam in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieChartGleam = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRendererOptionsPropertyPieChartGleamColor()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FFFFFF' ),
            $options->pieChartGleamColor,
            'Wrong default value for property pieChartGleamColor in class ezcGraphRendererOptions'
        );

        $options->pieChartGleamColor = $color = ezcGraphColor::fromHex( '#000000' );
        $this->assertSame(
            $color,
            $options->pieChartGleamColor,
            'Setting property value did not work for property pieChartGleamColor in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieChartGleamColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testRendererOptionsPropertyPieChartGleamBorder()
    {
        $options = new ezcGraphRendererOptions();

        $this->assertSame(
            0,
            $options->pieChartGleamBorder,
            'Wrong default value for property pieChartGleamBorder in class ezcGraphRendererOptions'
        );

        $options->pieChartGleamBorder = 1;
        $this->assertSame(
            1,
            $options->pieChartGleamBorder,
            'Setting property value did not work for property pieChartGleamBorder in class ezcGraphRendererOptions'
        );

        try
        {
            $options->pieChartGleamBorder = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer2dOptionsPropertyPieChartShadowSize()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertSame(
            0,
            $options->pieChartShadowSize,
            'Wrong default value for property pieChartShadowSize in class ezcGraphRenderer2dOptions'
        );

        $options->pieChartShadowSize = 5;
        $this->assertSame(
            5,
            $options->pieChartShadowSize,
            'Setting property value did not work for property pieChartShadowSize in class ezcGraphRenderer2dOptions'
        );

        try
        {
            $options->pieChartShadowSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer2dOptionsPropertyPieChartShadowTransparency()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertSame(
            .3,
            $options->pieChartShadowTransparency,
            'Wrong default value for property pieChartShadowTransparency in class ezcGraphRenderer2dOptions'
        );

        $options->pieChartShadowTransparency = .5;
        $this->assertSame(
            .5,
            $options->pieChartShadowTransparency,
            'Setting property value did not work for property pieChartShadowTransparency in class ezcGraphRenderer2dOptions'
        );

        try
        {
            $options->pieChartShadowTransparency = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer2dOptionsPropertyPieChartShadowColor()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000' ),
            $options->pieChartShadowColor,
            'Wrong default value for property pieChartShadowColor in class ezcGraphRenderer2dOptions'
        );

        $options->pieChartShadowColor = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->pieChartShadowColor,
            'Setting property value did not work for property pieChartShadowColor in class ezcGraphRenderer2dOptions'
        );

        try
        {
            $options->pieChartShadowColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testRendererOptionsPropertyAxisEndStyle()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertSame(
            ezcGraph::ARROW,
            $options->axisEndStyle,
            'Wrong default value for property axisEndStyle in class ezcGraphRenderer2dOptions'
        );

        $options->axisEndStyle = ezcGraph::NO_SYMBOL;
        $this->assertSame(
            ezcGraph::NO_SYMBOL,
            $options->axisEndStyle,
            'Setting property value did not work for property axisEndStyle in class ezcGraphRenderer2dOptions'
        );

        try
        {
            $options->axisEndStyle = false;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        { /* Expected */ }
    }

    public function testRendererOptionsPropertyShortAxis()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertSame(
            false,
            $options->shortAxis,
            'Wrong default value for property shortAxis in class ezcGraphRenderer2dOptions'
        );

        $options->shortAxis = true;
        $this->assertSame(
            true,
            $options->shortAxis,
            'Setting property value did not work for property shortAxis in class ezcGraphRenderer2dOptions'
        );

        try
        {
            $options->shortAxis = 'true';
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        { /* Expected */ }
    }

    public function testChartOptionsPropertyWidth()
    {
        $options = new ezcGraphRenderer2dOptions();

        $this->assertSame(
            null,
            $options->width,
            'Wrong default value for property width in class ezcGraphChartOptions'
        );

        $options->width = 100;
        $this->assertSame(
            100,
            $options->width,
            'Setting property value did not work for property width in class ezcGraphChartOptions'
        );

        try
        {
            $options->width = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartOptionsPropertyHeigh()
    {
        $options = new ezcGraphChartOptions();

        $this->assertSame(
            null,
            $options->height,
            'Wrong default value for property heigh in class ezcGraphChartOptions'
        );

        $options->height = 100;
        $this->assertSame(
            100,
            $options->height,
            'Setting property value did not work for property heigh in class ezcGraphChartOptions'
        );

        try
        {
            $options->height = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartOptionsPropertyFont()
    {
        $options = new ezcGraphChartOptions();

        $this->assertSame(
            'ezcGraphFontOptions',
            get_class( $options->font ),
            'Wrong default value for property font in class ezcGraphChartOptions'
        );

        $options->font = $file = dirname( __FILE__ ) . '/data/font2.ttf';
        $this->assertSame(
            $file,
            $options->font->path,
            'Setting property value did not work for property font in class ezcGraphChartOptions'
        );

        try
        {
            $options->font = false;
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseFileNotFoundException.' );
    }
}
?>
