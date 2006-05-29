<?php
/**
 * ezcGraphGdDriverTest 
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
class ezcGraphGdDriverTest extends ezcTestCase
{

    protected $driver;

    protected $tempDir;

    protected $basePath;

    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'png'           => 'png.png',
    );

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphGdDriverTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        static $i = 1;
        $this->tempDir = $this->createTempDir( 'ezcGraphGdDriverTest_' . sprintf( '%03d', $i++ ) . '_' ) . '/';

        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->driver = new ezcGraphGdDriver();
        $this->driver->options->width = 200;
        $this->driver->options->height = 100;
        $this->driver->options->imageFormat = ezcGraphGdDriver::PNG;
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        unset( $this->driver );
        $this->removeTempDir();
    }

    public function testDrawLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawLine(
            new ezcGraphCoordinate( 12, 45 ),
            new ezcGraphCoordinate( 34, 112 ),
            ezcGraphColor::fromHex( '#3465A4' )
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonThreePointsFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 12, 45 ),
                new ezcGraphCoordinate( 34, 112 ),
                new ezcGraphCoordinate( 71, 12 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            true
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonThreePointsNotFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 12, 45 ),
                new ezcGraphCoordinate( 34, 112 ),
                new ezcGraphCoordinate( 71, 12 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonFivePoints()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 12, 45 ),
                new ezcGraphCoordinate( 34, 112 ),
                new ezcGraphCoordinate( 71, 12 ),
                new ezcGraphCoordinate( 45, 3 ),
                new ezcGraphCoordinate( 22, 80 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            true
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleSectorAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircleSector(
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircularArc(
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircularArc(
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircularArc(
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawCircle(
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawImageJpeg()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawImage(
            $this->basePath . $this->testFiles['jpeg'],
            new ezcGraphCoordinate( 10, 10 ),
            100,
            50
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
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

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxShortString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            50,
            30
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'ThisIsAPrettyLongString',
            new ezcGraphCoordinate( 10, 10 ),
            50,
            30
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            'This Is A Pretty Long String',
            new ezcGraphCoordinate( 10, 10 ),
            50,
            30
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxManualBreak()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $this->driver->drawTextBox(
            "New\nLine",
            new ezcGraphCoordinate( 10, 10 ),
            50,
            30
        );

        $this->driver->render( $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '$hash',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }
}

?>
