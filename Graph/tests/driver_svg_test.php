<?php
/**
 * ezcGraphSvgDriverTest 
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
class ezcGraphSvgDriverTest extends ezcTestCase
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
		return new ezcTestSuite( "ezcGraphSvgDriverTest" );
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

        $this->driver = new ezcGraphSvgDriver();
        $this->driver->options->width = 200;
        $this->driver->options->height = 100;
        $this->driver->options->font->font = $this->basePath . 'font.ttf';
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
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '53b4c2d537fe72e0f02d3c79649071a9',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonThreePointsFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->driver->drawPolygon(
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

        $this->assertEquals(
            '0560d69e0a473521009ebb353a8d619a',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonThreePointsNotFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '805da20cc5bfa362014f48f6a9e7dadc',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawPolygonFivePoints()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '68fe9d21539e371fdac779cdc8b6bf7f',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleSectorAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'bb333f8f9aa563cbd79f238ed444dd49',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleSectorAcuteNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '9bcbb9f0076861e15a9f426923f9e64e',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleSectorAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'bb333f8f9aa563cbd79f238ed444dd49',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleSectorObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            '5425f0e9c0a1b101749eede1e8426e96',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcAcute()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->driver->drawCircularArc(
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

        $this->assertEquals(
            '7cc7bca87ad13efe8310826199854240',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcAcuteReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '7cc7bca87ad13efe8310826199854240',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircularArcObtuse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '5bd2450976479e57f1cf74f7e6345a5b',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'c748cd3c8720b98cbf8724296a7bd9c4',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawCircleNonFilled()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'bad8083fa82cb61db55f401fbc876037',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawImageJpeg()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'broken',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawImagePng()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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
            'broken',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxShortString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '21ad413d4b34220ce2dadf25fdfe93aa',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '58da91a8541e65abcd0ea3d170f53cef',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedString()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'ec91b1b2a65ccd8619f441c45b680ded',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxManualBreak()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'c4131ce32ed143c3b13749b13555151f',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxStringSampleRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '172d4886684c5868ae3c2be95f187c1e',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'a514061b35ba6ea8bbae39d59ecb263d',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedStringRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '5672013761efc0a1e28a17a96b0f05fb',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'be283e77d2527507374daec5668f0c93',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedStringCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'dde4bc623ba3ccfa6d5da72432381e90',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxStringRightBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '9c95e975d06a7dab5131d5ac4f859d52',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedStringRightMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'b1dfba96a96380b91056cf22b539d521',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxStringCenterMiddle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '856506208598ed3ec05e4009fda19fdc',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawTextBoxLongSpacedStringCenterBottom()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '72001c5cec1fc3432bc71577a49b2d1f',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testDrawStringWithSpecialChars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->assertEquals(
            '1bd0c084899d5025da3f66224c4cdef9',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }
}

?>
