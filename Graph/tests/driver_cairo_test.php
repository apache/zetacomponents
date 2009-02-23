<?php
/**
 * ezcGraphCairoDriverTest 
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
class ezcGraphCairoDriverTest extends ezcTestImageCase
{
    protected $driver;

    protected $tempDir;

    protected $basePath;

    protected $testFiles = array(
        'png'           => 'png.png',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphCairoDriverTest" );
	}

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'cairo_wrapper' ) )
        {
            $this->markTestSkipped( 'This test needs pecl/cairo_wrapper support.' );
        }

        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->driver = new ezcGraphCairoDriver();
        $this->driver->options->width = 200;
        $this->driver->options->height = 100;
        $this->driver->options->font->path = $this->basePath . 'font.ttf';
    }

    protected function tearDown()
    {
        unset( $this->driver );
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testRenderPngToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->assertEquals(
            $this->driver->getMimeType(),
            'image/png',
            'Wrong mime type returned.'
        );

        ob_start();
        // Suppress header already sent warning
        @$this->driver->renderToOutput();
        file_put_contents( $filename, ob_get_clean() );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
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
        $this->assertSame(
            'resource',
            gettype( $resource['surface'] )
        );
        $this->assertSame(
            'resource',
            gettype( $resource['context'] )
        );
    }

    public function testDrawLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawLineWithDifferentWidths()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 134, 12 ),
            ezcGraphColor::fromHex( '#3465A4' ),
            3
        );

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 35 ),
            new ezcGraphCoordinate( 134, 2 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawPolygonThreePointsFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );

        $this->assertEquals(
            $return,
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            'Expected point array as return value.'
        );
    }

    public function testDrawTransparentPolygon()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            ezcGraphColor::fromHex( '#3465A47F' ),
            true
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawPolygonThreePointsNotFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawPolygonFivePoints()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircleSectorAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $return = $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            12.5,
            25,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );

        $this->assertEquals(
            $return,
            array(
                new ezcGraphCoordinate( 100., 50. ),
                new ezcGraphCoordinate( 139., 54. ),
                new ezcGraphCoordinate( 137., 58. ),
                new ezcGraphCoordinate( 136., 58.5 ),
            ),
            'Expected point array as return value.',
            1.
        );
    }

    public function testDrawCircleSectorAcuteNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircleSectorAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            25,
            12.5,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircleSectorObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircleSector(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            25,
            273,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
        $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircularArcAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->options->imageMapResolution = 90;
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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );

        $this->assertEquals(
            $return,
            array(
                new ezcGraphCoordinate( 173., 59. ),
                new ezcGraphCoordinate( 143., 83. ),
                new ezcGraphCoordinate( 153., 83. ),
                new ezcGraphCoordinate( 183., 59. ),
            ),
            'Expected point array as return value.',
            1.
        );
    }

    public function testDrawCircularArcAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircularArcObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircularArc(
            new ezcGraphCoordinate( 100, 50 ),
            150,
            70,
            10,
            25,
            300,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircularArcAcuteBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            0
        );
    }

    public function testDrawCircleFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->options->imageMapResolution = 90;
        $return = $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );

        $this->assertEquals(
            $return,
            array(
                new ezcGraphCoordinate( 140., 50. ),
                new ezcGraphCoordinate( 100., 70. ),
                new ezcGraphCoordinate( 60., 50. ),
                new ezcGraphCoordinate( 100., 30. ),
            ),
            'Expected point array as return value.',
            1.
        );
    }

    public function testDrawCircleNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircle(
            new ezcGraphCoordinate( 100, 50 ),
            80,
            40,
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawImagePng()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawImage(
            $this->basePath . $this->testFiles['png'],
            new ezcGraphCoordinate( 10, 10 ),
            100,
            50
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircleRadialFill()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawCircleLinearFill()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxShortString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );

        $this->assertEquals(
            $return,
            array(
                new ezcGraphCoordinate( 10., 10. ),
                new ezcGraphCoordinate( 160., 10. ),
                new ezcGraphCoordinate( 160., 80. ),
                new ezcGraphCoordinate( 10., 80. ),
            ),
            'Expected point array as return value.',
            1.
        );
    }

    public function testDrawTextBoxShortStringRotated10Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        
        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 10 )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxShortStringRotated45Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        
        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 45, new ezcGraphCoordinate( 100, 50 ) )
        );

        $this->driver->render( $filename );

        $this->assertImageSimilar( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxShortStringRotated340Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        
        $this->driver->options->font->border = ezcGraphColor::fromHex( '#555555' );
        $this->driver->options->font->background = ezcGraphColor::fromHex( '#DDDDDD' );
        $this->driver->options->font->minimizeBorder = true;
        $this->driver->options->font->padding = 2;

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 340, new ezcGraphCoordinate( 200, 100 ) )
        );

        $this->driver->render( $filename );

        $this->assertImageSimilar( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongSpacedString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxManualBreak()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            "New\nLine",
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxStringSampleRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongSpacedStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongSpacedStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxStringRightBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT | ezcGraph::BOTTOM
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongSpacedStringRightMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::RIGHT | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxStringCenterMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER | ezcGraph::MIDDLE
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextBoxLongSpacedStringCenterBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::CENTER | ezcGraph::BOTTOM
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawSmallStringWithSpecialChars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            10
        );
    }

    public function testDrawTooLongTextException()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        try
        {
            $this->driver->drawTextBox(
                'This is very long text which is not supposed to fit in the bounding box.',
                new ezcGraphCoordinate( 10, 10 ),
                1,
                20,
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

    public function testDrawTextWithTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithCustomTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawRotatedTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertImageSimilar( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundMiddleCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundBottomRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testShortenStringMoreChars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'Teststring foo',
            new ezcGraphCoordinate( 10, 10 ),
            24,
            6,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->assertImageSimilar( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }
}
?>
