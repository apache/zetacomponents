<?php
/**
 * ezcGraphFontTest 
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
class ezcGraphFontTest extends ezcGraphTestCase
{
    protected $tempDir;

    protected $basePath;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphFontTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        unset( $this->driver );
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testSetGeneralFont()
    {
        $chart = new ezcGraphPieChart();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        
        $this->assertTrue(
            $chart->options->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->path,
            'Font face was not properly assigned.'
        );

        $this->assertEquals(
            6,
            $chart->options->font->minFontSize,
            'Deafult minimum font size invalid.'
        );
    }

    public function testGetGeneralFontForElement()
    {
        $chart = new ezcGraphPieChart();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->legend->font->path,
            'Font face was not properly assigned.'
        );
    }

    public function testSetFontForElement()
    {
        $chart = new ezcGraphLineChart();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        $chart->legend->font->path = $this->basePath . 'font2.ttf';

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->path,
            'General font face should be the old one.'
        );
        
        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->title->font->path,
            'Font face for X axis should be the old one.'
        );
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font2.ttf',
            $chart->legend->font->path,
            'Font face for legend has not changed.'
        );
    }

    public function testSetFontForElementWithRendering()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->options->font->path = $this->basePath . 'font.ttf';
        $chart->legend->font->path = $this->basePath . 'font2.ttf';
        $chart->render( 500, 200 );

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->path,
            'General font face should be the old one.'
        );
        
        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->title->font->path,
            'Font face for X axis should be the old one.'
        );
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font2.ttf',
            $chart->legend->font->path,
            'Font face for legend has not changed.'
        );
    }

    public function testTTFFontType()
    {
        $chart = new ezcGraphLineChart();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        
        $this->assertSame( 
            $chart->options->font->type,
            ezcGraph::TTF_FONT,
            'Font type is not TTF.'
        );
    }

    public function testPSFontType()
    {
        $chart = new ezcGraphLineChart();
        $chart->options->font->path = $this->basePath . 'ps_font.pfb';
        
        $this->assertSame( 
            $chart->options->font->type,
            ezcGraph::PS_FONT,
            'Font type is not TTF.'
        );
    }

    public function testUnknownFontType()
    {
        $chart = new ezcGraphLineChart();

        try
        {
            $chart->options->font->path = $this->basePath . 'ez.png';
        }
        catch ( ezcGraphUnknownFontTypeException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownFontTypeException.' );
    }

    public function testFontOptionsPropertyName()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            'sans-serif',
            $options->name,
            'Wrong default value for property name in class ezcGraphFontOptions'
        );

        $options->name = 'serif';
        $this->assertSame(
            'serif',
            $options->name,
            'Setting property value did not work for property name in class ezcGraphFontOptions'
        );

        try
        {
            $options->name = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyPath()
    {
        $options = new ezcGraphFontOptions();

        try
        {
            $catched = false;
            $options->path;
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $catched = true;

            $this->assertEquals(
                $e->getMessage(),
                'The font file \'\' could not be found.',
                'Wrong default content mentioned in exception.'
            );
        }

        if ( !$catched )
        {
            $this->fail( 'Expected ezcBaseFileNotFoundException.' );
        }

        $options->path = $file = dirname( __FILE__ ) . '/data/font2.ttf';
        $this->assertSame(
            $file,
            $options->path,
            'Setting property value did not work for property path in class ezcGraphFontOptions'
        );

        try
        {
            $options->path = false;
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseFileNotFoundException.' );
    }

    public function testFontOptionsPropertyType()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            ezcGraph::TTF_FONT,
            $options->type,
            'Wrong default value for property type in class ezcGraphFontOptions'
        );

        $options->type = ezcGraph::PS_FONT;
        $this->assertSame(
            ezcGraph::PS_FONT,
            $options->type,
            'Setting property value did not work for property type in class ezcGraphFontOptions'
        );

        try
        {
            $options->type = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyMinFontSize()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            6,
            $options->minFontSize,
            'Wrong default value for property minFontSize in class ezcGraphFontOptions'
        );

        $options->minFontSize = 8;
        $this->assertSame(
            8.,
            $options->minFontSize,
            'Setting property value did not work for property minFontSize in class ezcGraphFontOptions'
        );

        try
        {
            $options->minFontSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyMaxFontSize()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            96,
            $options->maxFontSize,
            'Wrong default value for property maxFontSize in class ezcGraphFontOptions'
        );

        $options->maxFontSize = 12;
        $this->assertSame(
            12.,
            $options->maxFontSize,
            'Setting property value did not work for property maxFontSize in class ezcGraphFontOptions'
        );

        try
        {
            $options->maxFontSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyMaxFontSizeLowerThenMinFonSize()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            96,
            $options->maxFontSize,
            'Wrong default value for property maxFontSize in class ezcGraphFontOptions'
        );

        try
        {
            $options->maxFontSize = 1;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyMinimalUsedFont()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            96,
            $options->minimalUsedFont,
            'Wrong default value for property minimalUsedFont in class ezcGraphFontOptions'
        );

        $options->minimalUsedFont = 24;
        $this->assertSame(
            24.,
            $options->minimalUsedFont,
            'Setting property value did not work for property minimalUsedFont in class ezcGraphFontOptions'
        );

        $options->minimalUsedFont = 36.;
        $this->assertSame(
            24.,
            $options->minimalUsedFont,
            'Setting property value did not work for property minimalUsedFont in class ezcGraphFontOptions'
        );
    }

    public function testFontOptionsPropertyMinFontSizeGreaterThenMaxFonSize()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            6,
            $options->minFontSize,
            'Wrong default value for property minFontSize in class ezcGraphFontOptions'
        );

        try
        {
            $options->minFontSize = 100;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyColor()
    {
        $options = new ezcGraphFontOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000' ),
            $options->color,
            'Wrong default value for property color in class ezcGraphFontOptions'
        );

        $options->color = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->color,
            'Setting property value did not work for property color in class ezcGraphFontOptions'
        );

        try
        {
            $options->color = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testFontOptionsPropertyBackground()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            false,
            $options->background,
            'Wrong default value for property background in class ezcGraphFontOptions'
        );

        $options->background = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->background,
            'Setting property value did not work for property background in class ezcGraphFontOptions'
        );

        try
        {
            $options->background = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testFontOptionsPropertyBorder()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            false,
            $options->border,
            'Wrong default value for property border in class ezcGraphFontOptions'
        );

        $options->border = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->border,
            'Setting property value did not work for property border in class ezcGraphFontOptions'
        );

        try
        {
            $options->border = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testFontOptionsPropertyBorderWidth()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            1,
            $options->borderWidth,
            'Wrong default value for property borderWidth in class ezcGraphFontOptions'
        );

        $options->borderWidth = 2;
        $this->assertSame(
            2,
            $options->borderWidth,
            'Setting property value did not work for property borderWidth in class ezcGraphFontOptions'
        );

        try
        {
            $options->borderWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyPadding()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            0,
            $options->padding,
            'Wrong default value for property padding in class ezcGraphFontOptions'
        );

        $options->padding = 1;
        $this->assertSame(
            1,
            $options->padding,
            'Setting property value did not work for property padding in class ezcGraphFontOptions'
        );

        try
        {
            $options->padding = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyMinimizeBorder()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            true,
            $options->minimizeBorder,
            'Wrong default value for property minimizeBorder in class ezcGraphFontOptions'
        );

        $options->minimizeBorder = false;
        $this->assertSame(
            false,
            $options->minimizeBorder,
            'Setting property value did not work for property minimizeBorder in class ezcGraphFontOptions'
        );

        try
        {
            $options->minimizeBorder = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyTextShadow()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            false,
            $options->textShadow,
            'Wrong default value for property textShadow in class ezcGraphFontOptions'
        );

        $options->textShadow = true;
        $this->assertSame(
            true,
            $options->textShadow,
            'Setting property value did not work for property textShadow in class ezcGraphFontOptions'
        );

        try
        {
            $options->textShadow = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyTextShadowOffset()
    {
        $options = new ezcGraphFontOptions();

        $this->assertSame(
            1,
            $options->textShadowOffset,
            'Wrong default value for property textShadowOffset in class ezcGraphFontOptions'
        );

        $options->textShadowOffset = 2;
        $this->assertSame(
            2,
            $options->textShadowOffset,
            'Setting property value did not work for property textShadowOffset in class ezcGraphFontOptions'
        );

        try
        {
            $options->textShadowOffset = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testFontOptionsPropertyTextShadowColor()
    {
        $options = new ezcGraphFontOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FFFFFF' ),
            $options->textShadowColor,
            'Wrong default value for property textShadowColor in class ezcGraphFontOptions'
        );

        $options->textShadowColor = $color = ezcGraphColor::fromHex( '#CCCCCC' );
        $this->assertSame(
            $color,
            $options->textShadowColor,
            'Setting property value did not work for property textShadowColor in class ezcGraphFontOptions'
        );

        try
        {
            $options->textShadowColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testPropertyNotFoundException()
    {
        $options = new ezcGraphFontOptions();

        try
        {
            $options->unknown = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testUTF8SpecialCharsSVG()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $driver = new ezcGraphSvgDriver();
        $driver->options->width = 200;
        $driver->options->height = 100;

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $driver->drawTextBox(
            'öäüÖÄÜß',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testISO_8859_15SpecialCharsSVG()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $driver = new ezcGraphSvgDriver();
        $driver->options->width = 200;
        $driver->options->height = 100;
        $driver->options->encoding = 'ISO-8859-15';

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $driver->drawTextBox(
            iconv( 'UTF-8', 'ISO-8859-15', 'öäüÖÄÜß' ),
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testUTF8SpecialCharsGD()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $driver = new ezcGraphGdDriver();
        $driver->options->font->path = $this->basePath . 'font.ttf';
        $driver->options->width = 200;
        $driver->options->height = 100;

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $return = $driver->drawTextBox(
            'öäüÖÄÜß',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testISO_8859_15SpecialCharsGD()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $driver = new ezcGraphGdDriver();
        $driver->options->font->path = $this->basePath . 'font.ttf';
        $driver->options->width = 200;
        $driver->options->height = 100;

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $return = $driver->drawTextBox(
            iconv( 'UTF-8', 'ISO-8859-15', 'öäüÖÄÜß' ),
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testUTF8SpecialCharsFlash()
    {
        $this->markTestSkipped( 'No support for UTF-8 chars in SWFTextField. SWFText is not usable by driver for other reasons.' );

        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $driver = new ezcGraphFlashDriver();
        $driver->options->font->path = $this->basePath . 'fdb_font.fdb';
        $driver->options->width = 200;
        $driver->options->height = 100;

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $driver->drawTextBox(
            'öäüÖÄÜß',
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }

    public function testISO_8859_15SpecialCharsFlash()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( "ming" ) )
        {
            $this->markTestSkipped( "ext/ming not found" );
        }

        $filename = $this->tempDir . __FUNCTION__ . '.swf';

        $driver = new ezcGraphFlashDriver();
        $driver->options->font->path = $this->basePath . 'fdb_font.fdb';
        $driver->options->width = 200;
        $driver->options->height = 100;

        $driver->drawPolygon(
            array( 
                new ezcGraphCoordinate( 10, 10 ),
                new ezcGraphCoordinate( 160, 10 ),
                new ezcGraphCoordinate( 160, 80 ),
                new ezcGraphCoordinate( 10, 80 ),
            ),
            ezcGraphColor::fromHex( '#eeeeec' ),
            true
        );
        $driver->drawTextBox(
            iconv( 'UTF-8', 'ISO-8859-15', 'öäüÖÄÜß' ),
            new ezcGraphCoordinate( 10, 10 ),
            150,
            70,
            ezcGraph::LEFT
        );

        $driver->render( $filename );

        $this->swfCompare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.swf'
        );
    }
}
?>
