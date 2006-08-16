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

    protected $basePath;

    protected $tempDir;

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
        static $i = 0;
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

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    /**
     * Compares a generated image with a stored file
     * 
     * @param string $generated Filename of generated image
     * @param string $compare Filename of stored image
     * @return void
     */
    protected function compare( $generated, $compare )
    {
        $this->assertTrue(
            file_exists( $generated ),
            'No image file has been created.'
        );

        $this->assertTrue(
            file_exists( $compare ),
            'Comparision image does not exist.'
        );

        if ( md5_file( $generated ) !== md5_file( $compare ) )
        {
            // Adding a diff makes no sense here, because created XML uses
            // only two lines
            $this->fail( 'Rendered image is not correct.');
        }
    }

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
                $this->equalTo( new ezcGraphCoordinate( 205., 160. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 292.5, 150. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#000000' ) ),
                $this->equalTo( 1 )
            );

        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 205., 160. ), 1. ),
                $this->equalTo( 6 ),
                $this->equalTo( 6 ),
                $this->equalTo( ezcGraphColor::fromHex( '#000000' ) ),
                $this->equalTo( true )
            );
        $this->driver
            ->expects( $this->at( 4 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 292.5, 150. ), 1. ),
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
                $this->equalTo( new ezcGraphCoordinate( 298.5, 135. ), 1. ),
                $this->equalTo( 101.5, 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 36 )
            );


        // Render
        $this->renderer->drawPieSegment(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            'Testlabel',
            0
        );

        $this->renderer->render( 'foo.svg' );
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
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            false,
            0
        );

        $this->renderer->render( 'foo.svg' );
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
            ezcGraphColor::fromHex( '#FF0000' ),
            15,
            156,
            false,
            true
        );

        $this->renderer->render( 'foo.svg' );
    }

    public function testRenderLotsOfLabeledPieSegments()
    {
        $this->driver
            ->expects( $this->at( 13 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 5' ),
                $this->equalTo( new ezcGraphCoordinate( 0, 143. ), 1. ),
                $this->equalTo( 106., 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 40 )
            );
        $this->driver
            ->expects( $this->at( 17 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 1' ),
                $this->equalTo( new ezcGraphCoordinate( 302., 42. ), 1. ),
                $this->equalTo( 97., 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 21 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 2' ),
                $this->equalTo( new ezcGraphCoordinate( 312., 92. ), 1. ),
                $this->equalTo( 88., 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 25 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 3' ),
                $this->equalTo( new ezcGraphCoordinate( 303., 127. ), 1. ),
                $this->equalTo( 97., 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 36 )
            );
        $this->driver
            ->expects( $this->at( 29 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( 'Label 4' ),
                $this->equalTo( new ezcGraphCoordinate( 281., 157. ), 1. ),
                $this->equalTo( 119., 1. ),
                $this->equalTo( 30., 1. ),
                $this->equalTo( 36 )
            );

        // Render
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), ezcGraphColor::fromHex( '#FF0000' ), 15, 27, 'Label 1', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), ezcGraphColor::fromHex( '#FF0000' ), 27, 38, 'Label 2', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), ezcGraphColor::fromHex( '#FF0000' ), 38, 45, 'Label 3', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), ezcGraphColor::fromHex( '#FF0000' ), 45, 70, 'Label 4', true );
        $this->renderer->drawPieSegment( new ezcGraphBoundings( 0, 0, 400, 200 ), ezcGraphColor::fromHex( '#FF0000' ), 70, 119, 'Label 5', true );

        $this->renderer->render( 'foo.svg' );
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
                    new ezcGraphCoordinate( 202.5, 0. ),
                    new ezcGraphCoordinate( 202.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 40. ),
                    new ezcGraphCoordinate( 242.5, 0. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawBar( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            ezcGraphColor::fromHex( '#FF0000' ), 
            new ezcGraphCoordinate( .5, .2 ),
            100,
            1,
            2,
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
                $this->equalTo( new ezcGraphCoordinate( 40., 160. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 60. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
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
                $this->equalTo( new ezcGraphCoordinate( 40., 160. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 60. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 280, 60 ) ),
                $this->equalTo( 6 ),
                $this->equalTo( 6 ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( false )
            );

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
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
                $this->equalTo( new ezcGraphCoordinate( 40., 160. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 280., 60. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawCircle' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 280, 60 ) ),
                $this->equalTo( 10 ),
                $this->equalTo( 10 ),
                $this->equalTo( ezcGraphColor::fromHex( '#00FF00' ) ),
                $this->equalTo( true )
            );

        $this->renderer->options->symbolSize = 10;

        $this->renderer->drawDataLine( 
            new ezcGraphBoundings( 0, 0, 400, 200 ),
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
    }

    public function testRenderBox()
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
        $this->driver
            ->expects( $this->at( 1 ) )
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
            ->expects( $this->at( 0 ) )
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
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 5., 5. ),
                    new ezcGraphCoordinate( 395., 5. ),
                    new ezcGraphCoordinate( 395., 195. ),
                    new ezcGraphCoordinate( 5., 195. ),
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
        $this->driver
            ->expects( $this->at( 1 ) )
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
        $this->driver
            ->expects( $this->at( 1 ) )
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

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 120., 220. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 120., 20. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 120., 20. ),
                    new ezcGraphCoordinate( 122.5, 25. ),
                    new ezcGraphCoordinate( 117.5, 25. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 20, 200 ),
            new ezcGraphCoordinate( 20, 0 ),
            $chart->yAxis
        );
    }
    
    public function testRenderVerticalAxisReverse()
    {
        $chart = new ezcGraphLineChart();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 120., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 120., 220. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 120., 220. ),
                    new ezcGraphCoordinate( 117.5, 215. ),
                    new ezcGraphCoordinate( 122.5, 215. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 20, 0 ),
            new ezcGraphCoordinate( 20, 200 ),
            $chart->yAxis
        );
    }
    
    public function testRenderHorizontalAxis()
    {
        $chart = new ezcGraphLineChart();

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
                    new ezcGraphCoordinate( 442., 116. ),
                    new ezcGraphCoordinate( 442., 124. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 50, 100 ),
            new ezcGraphCoordinate( 350, 100 ),
            $chart->yAxis
        );
    }
    
    public function testRenderHorizontalAxisReverse()
    {
        $chart = new ezcGraphLineChart();

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
                    new ezcGraphCoordinate( 157., 123.5 ),
                    new ezcGraphCoordinate( 157., 116.5 ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 350, 100 ),
            new ezcGraphCoordinate( 50, 100 ),
            $chart->yAxis
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
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithBackgroundBottomRight()
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

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/ez.png';
        $chart->background->position = ezcGraph::BOTTOM | ezcGraph::RIGHT;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithTextureBackground()
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

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/texture.png';
        $chart->background->repeat = ezcGraph::HORIZONTAL | ezcGraph::VERTICAL;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
