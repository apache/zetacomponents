<?php
/**
 * ezcGraphSvgDriverTest 
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
class ezcGraphSvgSvgFontDriverTest extends ezcGraphTestCase
{
    protected $driver;

    protected $tempDir;

    protected $basePath;

    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'png'           => 'png.png',
        'gif'           => 'gif.gif',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->driver = new ezcGraphSvgDriver();
        $this->driver->options->width = 200;
        $this->driver->options->height = 100;

        $this->driver->options->font->path = $this->basePath . 'font.svg';

        $this->setLocale( LC_NUMERIC, 'en_US', 'en_US.UTF-8', 'en_US.UTF8', 'en', 'english', 'en_US@euro' );
    }

    protected function tearDown()
    {
        unset( $this->driver );
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
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
        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $this->driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
        
        $this->assertEquals(
            'ezcGraphTextBox_2',
            $return,
            'Expected xml id as return value.'
        );
    }

    public function testDrawTextBoxShortStringRotated10Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 10 )
        );

        $this->driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextBoxShortStringRotated45Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 45, new ezcGraphCoordinate( 100, 50 ) )
        );

        $this->driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextBoxShortStringRotated340Degrees()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $return = $this->driver->drawTextBox(
            'Short',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT,
            new ezcGraphRotation( 340, new ezcGraphCoordinate( 200, 100 ) )
        );

        $this->driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawChartInTemplate()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->font = $this->basePath . 'font.svg';
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->driver->options->templateDocument = dirname( __FILE__ ) . '/data/template.svg';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 300, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawChartInTemplateCustomGroup()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->font = $this->basePath . 'font.svg';
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->driver->options->templateDocument = dirname( __FILE__ ) . '/data/template.svg';
        $chart->driver->options->insertIntoGroup = 'graph_root_node';
        $chart->driver->options->graphOffset = new ezcGraphCoordinate( 50, 70 );

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 300, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawChartInTemplateUnknownGroup()
    {
        $chart = new ezcGraphPieChart();
        $chart->options->font = $this->basePath . 'font.svg';
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->driver->options->templateDocument = dirname( __FILE__ ) . '/data/template.svg';
        $chart->driver->options->insertIntoGroup = 'not_existing_group';

        try
        {
            $chart->render( 500, 300 );
        }
        catch ( ezcGraphSvgDriverInvalidIdException $e )
        {
            return;
        }

        $this->fail( 'Expected ezcGraphSvgDriverInvalidIdException.' );
    }

    public function testDrawChartWithCustomPrefix()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->font = $this->basePath . 'font.svg';
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->driver->options->idPrefix = 'customPrefix';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 300, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithCustomTextShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawRotatedTextWithMinimizedBorderAndBackgroundTopLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundMiddleCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDrawTextWithMinimizedBorderAndBackgroundBottomRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

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

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testChangeDefaultRenderSettings()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->driver->options->strokeLineJoin = 'bevel';
        $this->driver->options->strokeLineCap = 'square';
        $this->driver->options->shapeRendering = 'optimizeSpeed';
        $this->driver->options->colorRendering = 'optimizeSpeed';
        $this->driver->options->textRendering = 'optimizeSpeed';

        $return = $this->driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 45, 12 ),
                new ezcGraphCoordinate( 122, 34 ),
                new ezcGraphCoordinate( 12, 71 ),
            ),
            ezcGraphColor::fromHex( '#3465A4' ),
            false
        );

        $this->driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        $this->assertEquals(
            'ezcGraphPolygon_1',
            $return,
            'Expected xml id as return value.'
        );
    }

    public function testSvgDriverOptionsPropertyAssumedNumericCharacterWidth()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            .62,
            $options->assumedNumericCharacterWidth,
            'Wrong default value for property assumedNumericCharacterWidth in class ezcGraphSvgDriverOptions'
        );

        $options->assumedNumericCharacterWidth = .7;
        $this->assertSame(
            .7,
            $options->assumedNumericCharacterWidth,
            'Setting property value did not work for property assumedNumericCharacterWidth in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->assumedNumericCharacterWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyAssumedTextCharacterWidth()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            .53,
            $options->assumedTextCharacterWidth,
            'Wrong default value for property assumedTextCharacterWidth in class ezcGraphSvgDriverOptions'
        );

        $options->assumedTextCharacterWidth = .7;
        $this->assertSame(
            .7,
            $options->assumedTextCharacterWidth,
            'Setting property value did not work for property assumedTextCharacterWidth in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->assumedTextCharacterWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyStrokeLineCap()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'round',
            $options->strokeLineCap,
            'Wrong default value for property strokeLineCap in class ezcGraphSvgDriverOptions'
        );

        $options->strokeLineCap = 'butt';
        $this->assertSame(
            'butt',
            $options->strokeLineCap,
            'Setting property value did not work for property strokeLineCap in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->strokeLineCap = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyStrokeLineJoin()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'round',
            $options->strokeLineJoin,
            'Wrong default value for property strokeLineJoin in class ezcGraphSvgDriverOptions'
        );

        $options->strokeLineJoin = 'miter';
        $this->assertSame(
            'miter',
            $options->strokeLineJoin,
            'Setting property value did not work for property strokeLineJoin in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->strokeLineJoin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyShapeRendering()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'geometricPrecision',
            $options->shapeRendering,
            'Wrong default value for property shapeRendering in class ezcGraphSvgDriverOptions'
        );

        $options->shapeRendering = 'optimizeSpeed';
        $this->assertSame(
            'optimizeSpeed',
            $options->shapeRendering,
            'Setting property value did not work for property shapeRendering in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->shapeRendering = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyColorRendering()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'optimizeQuality',
            $options->colorRendering,
            'Wrong default value for property colorRendering in class ezcGraphSvgDriverOptions'
        );

        $options->colorRendering = 'optimizeSpeed';
        $this->assertSame(
            'optimizeSpeed',
            $options->colorRendering,
            'Setting property value did not work for property colorRendering in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->colorRendering = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyTextRendering()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'optimizeLegibility',
            $options->textRendering,
            'Wrong default value for property textRendering in class ezcGraphSvgDriverOptions'
        );

        $options->textRendering = 'optimizeSpeed';
        $this->assertSame(
            'optimizeSpeed',
            $options->textRendering,
            'Setting property value did not work for property textRendering in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->textRendering = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyTemplateDocument()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            false,
            $options->templateDocument,
            'Wrong default value for property templateDocument in class ezcGraphSvgDriverOptions'
        );

        $options->templateDocument = $file = dirname( __FILE__ ) . '/data/template.svg';
        $this->assertSame(
            $file,
            $options->templateDocument,
            'Setting property value did not work for property templateDocument in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->templateDocument = false;
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseFileNotFoundException.' );
    }

    public function testSvgDriverOptionsPropertyInsertIntoGroup()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            false,
            $options->insertIntoGroup,
            'Wrong default value for property insertIntoGroup in class ezcGraphSvgDriverOptions'
        );

        $options->insertIntoGroup = 'group';
        $this->assertSame(
            'group',
            $options->insertIntoGroup,
            'Setting property value did not work for property insertIntoGroup in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->insertIntoGroup = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyGraphOffset()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertEquals(
            new ezcGraphCoordinate( 0, 0 ),
            $options->graphOffset,
            'Wrong default value for property graphOffset in class ezcGraphSvgDriverOptions'
        );

        $options->graphOffset = $coord = new ezcGraphCoordinate( 10, 10 );
        $this->assertSame(
            $coord,
            $options->graphOffset,
            'Setting property value did not work for property graphOffset in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->graphOffset = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testSvgDriverOptionsPropertyIdPrefix()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'ezcGraph',
            $options->idPrefix,
            'Wrong default value for property idPrefix in class ezcGraphSvgDriverOptions'
        );

        $options->idPrefix = 'custom';
        $this->assertSame(
            'custom',
            $options->idPrefix,
            'Setting property value did not work for property idPrefix in class ezcGraphSvgDriverOptions'
        );
    }

    public function testSvgDriverOptionsPropertyEncoding()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            null,
            $options->encoding,
            'Wrong default value for property encoding in class ezcGraphSvgDriverOptions'
        );

        $options->encoding = 'ISO-8859-15';
        $this->assertSame(
            'ISO-8859-15',
            $options->encoding,
            'Setting property value did not work for property encoding in class ezcGraphSvgDriverOptions'
        );
    }

    public function testSvgWithDifferentLocales()
    {
        $this->setLocale( LC_NUMERIC, 'de_DE', 'de_DE.UTF-8', 'de_DE.UTF8', 'deu_deu', 'de', 'ge', 'deutsch', 'de_DE@euro' );

        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->palette = new ezcGraphPaletteEz();
        $chart->options->font = $this->basePath . 'font.svg';
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

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
