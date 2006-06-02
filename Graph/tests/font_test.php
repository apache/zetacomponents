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
            $chart = ezcGraph::create( 'Pie' );
            $chart->options->font = $this->basePath . 'font.ttf';
            $chart->legend->font->font = $this->basePath . 'font2.ttf';
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            $this->basePath . 'font.ttf',
            $chart->options->font->font,
            'Font face was not properly assigned.'
        );
        
        $this->assertTrue(
            $chart->legend->font instanceof ezcGraphFontOptions,
            'No fontOptions object was created.'
        );

        $this->assertEquals(
            $this->basePath . 'font2.ttf',
            $chart->legend->font->font,
            'Font face was not properly assigned.'
        );
    }
}
?>

