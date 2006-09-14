<?php
/**
 * ezcGraphFontTest 
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
class ezcGraphFontTest extends ezcTestCase
{
    protected $basePath;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphFontTest" );
	}

    protected function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
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
}

?>
