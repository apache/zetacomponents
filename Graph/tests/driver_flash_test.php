<?php
/**
 * ezcGraphFlashDriverTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphFlashDriverTest extends ezcGraphTestCase
{
    protected $driver;

    protected $tempDir;

    protected $basePath;

    protected $testFiles = array(
        'jpeg'           => 'jpeg.jpg',
        'png'            => 'png.png',
        'gif'            => 'gif.gif',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphFlashDriverTest" );
	}

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'ming' ) ) 
        {
            $this->markTestSkipped( 'This test needs ext/ming support.' );
        }

        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->driver = new ezcGraphFlashDriver();
        $this->driver->options->width = 200;
        $this->driver->options->height = 100;

        $this->driver->options->font->path = $this->basePath . 'fdb_font.fdb';
    }

    protected function tearDown()
    {
        unset( $this->driver );
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testDrawLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testGetResource()
    {
        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        ob_start();
        // Suppress header already sent warning
        @$this->driver->renderToOutput();
        ob_end_clean();

        $resource = $this->driver->getResource();
        $this->assertTrue(
            $resource instanceof SWFMovie
        );
    }

    public function testDrawPolygonThreePointsFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            true
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );

        $this->assertEquals(
            'ezcGraphPolygon_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawPolygonThreePointsNotFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawPolygonFivePoints()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
                new ezcGraphCoordinate( 3, 45 ),
                new ezcGraphCoordinate( 60, 32 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            true
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleSectorAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            12.5,
            25,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircleSector_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawWideEllipse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            20,
            0,
            310,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircleSector_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawMultipleCircleSectors()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $angles = array( 10, 25, 45, 75, 110, 55 );

        $startAngle = 0;
        foreach ( $angles as $angle )
        {
            $this->driver->drawCircleSector(
                new ezcGraphCoordinate( 100, 50 ),
                80,
                40,
                $startAngle,
                $startAngle += $angle,
                ezcGraphColor::fromHex( '#3465A4' )
            );
            $startAngle += 5;
        }
        
        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleSectorBorderReducement()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $angles = array( 10, 25, 45, 90, 125, 180, 235, 340 );

        $position = 0;
        $radius = 80;
        foreach ( $angles as $angle )
        {
            while ( $position < 360 )
            {
                $this->driver->drawCircleSector(
                    new ezcGraphCoordinate( 100, 50 ),
                    $radius,
                    $radius / 2,
                    $position,
                    $position += $angle,
                    ezcGraphColor::fromHex( '#3465A480' ),
                    false
                );
    
                $position += 5;
            }

            $position = 0;
            $radius += 15;
        }

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawMultipleBigCircleSectors()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $angles = array( 135, 250 );

        $startAngle = 5;
        foreach ( $angles as $angle )
        {
            $this->driver->drawCircleSector(
                new ezcGraphCoordinate( 100, 50 ),
                80,
                40,
                $startAngle,
                $startAngle += $angle,
                ezcGraphColor::fromHex( '#3465A4' )
            );
            $startAngle += 5;
        }
        
        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleSectorAcuteNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            12.5,
            45,
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleSectorAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            25,
            12.5,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleSectorObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            25,
            273,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircularArcAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircularArc(
            new ezcGraphCoordinate( 100, 50 ),
            150,
            80,
            10,
            12.5,
            55,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircularArc_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawCircularArcAcuteBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircularArc(
            new ezcGraphCoordinate( 100, 50 ),
            150,
            80,
            10,
            12.5,
            55,
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircularArcAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircularArc(
            new ezcGraphCoordinate( 100, 50 ),
            150,
            80,
            10,
            55,
            12.5,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircularArcObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircularArc(
            new ezcGraphCoordinate( 100, 50 ),
            150,
            80,
            10,
            25,
            300,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircle_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawCircleNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawImageGif()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        try
        {
            $return = $this->driver->drawImage(
                $this->basePath . $this->testFiles['gif'],
                new ezcGraphCoordinate( 10, 10 ),
                150,
                100
            );
        } 
        catch ( ezcGraphFlashBitmapTypeException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphFlashBitmapTypeException.' );
    }

    public function testDrawImagePng()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawImage(
            $this->basePath . $this->testFiles['png'],
            new ezcGraphCoordinate( 10, 10 ),
            177,
            100
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawImageJpeg()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawImage(
            $this->basePath . $this->testFiles['jpeg'],
            new ezcGraphCoordinate( 10, 10 ),
            177,
            100
        );
        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxShortString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphTextBox_2',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawTextBoxShortStringRotated10Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 10 )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxShortStringRotated45Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 45, new ezcGraphCoordinate( 100, 50 ) )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxShortStringRotated340Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 340, new ezcGraphCoordinate( 200, 100 ) )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongSpacedString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxManualBreak()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            "New\nLine",
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxStringSampleRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 20, 20 ),
                new ezcGraphCoordinate( 110, 20 ),
                new ezcGraphCoordinate( 110, 30 ),
                new ezcGraphCoordinate( 20, 30 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'sample 4',
            new ezcGraphCoordinate( 21, 21 ),
            88,
            8,
            ezcGraph::RIGHT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongSpacedStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongSpacedStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxStringRightBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT | ezcGraph::BOTTOM
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongSpacedStringRightMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxStringCenterMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextBoxLongSpacedStringCenterBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER | ezcGraph::BOTTOM
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawStringWithSpecialChars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array(
                new ezcGraphCoordinate( 47, 54 ),
                new ezcGraphCoordinate( 47, 84 ),
                new ezcGraphCoordinate( 99, 84 ),
                new ezcGraphCoordinate( 99, 54 ),
            ),
            ezcGraphColor::fromHex( '#DDDDDD' ),
            true
        );
        $this->driver->drawTextBox(
            'Safari (13.8%)',
            new ezcGraphCoordinate( 47, 54 ),
            52,
            30,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->textShadow = true;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithCustomTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->textShadow = true;
        $this->driver->options->font->textShadowColor = '#888888';

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = false;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->minimizeBorder = false;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::TOP
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawRotatedTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT | ezcGraph::TOP,
            new ezcGraphRotation( 15 )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundMiddleCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundBottomRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $this->driver->drawTextBox(
            'Some test string',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT | ezcGraph::BOTTOM
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawTooLongTextException()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        try
        {
            $this->driver->drawTextBox(
                'Teststring foo',
                new ezcGraphCoordinate( 10, 10 ),
                1,
                6,
                ezcGraph::LEFT
            );

            $this->driver->render( $filename );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphFontRenderingException.' );
    }

    public function testShortenStringMoreChars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawTextBox(
            'Teststring foo',
            new ezcGraphCoordinate( 10, 10 ),
            24,
            6,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawCircleRadialFill()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            new ezcGraphRadialGradient(
                new ezcGraphCoordinate( 80, 40),
                80,
                40,
                ezcGraphColor::fromHex( '#729FCF' ),
                ezcGraphColor::fromHex( '#3465A4' )
            )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircle_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawCircleLinearFill()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            new ezcGraphLinearGradient(
                $start = new ezcGraphCoordinate( 80, 40 ),
                $end = new ezcGraphCoordinate( 130, 55 ),
                ezcGraphColor::fromHex( '#82BFFF' ),
                ezcGraphColor::fromHex( '#3465A4' )
            )
        );

        $this->driver->drawCircle(
            $start,
            2, 2, ezcGraphColor::fromHex( '#CC0000' )
        );
        $this->driver->drawCircle(
            $end,
            2, 2, ezcGraphColor::fromHex( '#CC0000' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircle_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawCircleRadialFilledLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            new ezcGraphRadialGradient(
                new ezcGraphCoordinate( 80, 40),
                80,
                40,
                ezcGraphColor::fromHex( '#729FCF' ),
                ezcGraphColor::fromHex( '#3465A4' )
            ),
            false
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircle_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testDrawCircleLinearFilledLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            new ezcGraphLinearGradient(
                $start = new ezcGraphCoordinate( 80, 40 ),
                $end = new ezcGraphCoordinate( 130, 55 ),
                ezcGraphColor::fromHex( '#82BFFF' ),
                ezcGraphColor::fromHex( '#3465A4' )
            ),
            false
        );

        $this->driver->drawCircle(
            $start,
            2, 2, ezcGraphColor::fromHex( '#CC0000' )
        );
        $this->driver->drawCircle(
            $end,
            2, 2, ezcGraphColor::fromHex( '#CC0000' )
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
        
        $this->assertEquals(
            'ezcGraphCircle_1',
            $return,
            'Expected flash object id as return value.'
        );
    }

    public function testRenderLabeledFlashPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $chart = new ezcGraphPieChart();
        $chart->options->font->path = dirname( __FILE__ ) . '/data/fdb_font.fdb';

        $chart->palette = new ezcGraphPaletteEz();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->pieChartShadowSize = 10;
        $chart->renderer->options->pieChartGleam = .5;
        $chart->renderer->options->dataBorder = false;
        $chart->renderer->options->pieChartHeight = 16;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->driver = new ezcGraphFlashDriver();
        $chart->render( 500, 200, $filename );

        $this->swfCompare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawMultipleFilledTransparentPolygons()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            ezcGraphColor::fromHex( '#3465A4DD' ),
            true
        );
        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 150, 13 ),
                new ezcGraphCoordinate( 90, 60 ),
                new ezcGraphCoordinate( 120, 5 ),
            ),
            ezcGraphColor::fromHex( '#A40000DD' ),
            true
        );
        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 170, 78 ),
                new ezcGraphCoordinate( 60, 24 ),
                new ezcGraphCoordinate( 140, 50 ),
            ),
            ezcGraphColor::fromHex( '#EDD400DD' ),
            true
        );

        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testDrawMultipleCircularArcs()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $angles = array( 10, 25, 45, 75, 110, 55 );

        $startAngle = 0;
        foreach ( $angles as $angle )
        {
            $this->driver->drawCircularArc(
                new ezcGraphCoordinate( 100, 50 ),
                80,
                40,
                10,
                $startAngle,
                $startAngle += $angle,
                ezcGraphColor::fromHex( '#3465A455' ),
                false
            );
            $startAngle += 5;
        }
        
        $this->driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testFlashDriverOptionsPropertyCompression()
    {
        $options = new ezcGraphFlashDriverOptions();

        $this->assertSame(
            9,
            $options->compression,
            'Wrong default value for property compression in class ezcGraphFlashDriverOptions'
        );

        $options->compression = 4;
        $this->assertSame(
            4,
            $options->compression,
            'Setting property value did not work for property compression in class ezcGraphFlashDriverOptions'
        );

        try
        {
            $options->compression = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFlashDriverOptionsPropertyCircleResolution()
    {
        $options = new ezcGraphFlashDriverOptions();

        $this->assertSame(
            2.,
            $options->circleResolution,
            'Wrong default value for property circleResolution in class ezcGraphFlashDriverOptions'
        );

        $options->circleResolution = 5.;
        $this->assertSame(
            5.,
            $options->circleResolution,
            'Setting property value did not work for property circleResolution in class ezcGraphFlashDriverOptions'
        );

        try
        {
            $options->circleResolution = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->assertEquals(
            $this->driver->getMimeType(),
            'application/x-shockwave-flash',
            'Wrong mime type returned.'
        );

        ob_start();
        // Suppress header already sent warning
        @$this->driver->renderToOutput();
        file_put_contents( $filename, ob_get_clean() );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }
}
?>
