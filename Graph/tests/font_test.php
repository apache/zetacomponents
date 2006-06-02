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

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testSetGeneralFont()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->options->font = $this->basePath . 'font.ttf';
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
        
        $this->assertTrue(
            $chart->options->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->font,
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
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->options->font = $this->basePath . 'font.ttf';
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->legend->font->font,
            'Font face was not properly assigned.'
        );
    }

    public function testSetFontForElement()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->options->font = $this->basePath . 'font.ttf';
            $chart->legend->font = $this->basePath . 'font2.ttf';
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->font,
            'General font face should be the old one.'
        );
        
        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->title->font->font,
            'Font face for X axis should be the old one.'
        );
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font2.ttf',
            $chart->legend->font->font,
            'Font face for legend has not changed.'
        );
    }

    public function testSetFontForElementWithRendering()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
            $chart->sampleData->color = '#CC0000';
            $chart->options->font = $this->basePath . 'font.ttf';
            $chart->legend->font = $this->basePath . 'font2.ttf';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->font,
            'General font face should be the old one.'
        );
        
        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->title->font->font,
            'Font face for X axis should be the old one.'
        );
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font2.ttf',
            $chart->legend->font->font,
            'Font face for legend has not changed.'
        );
    }
}
?>

