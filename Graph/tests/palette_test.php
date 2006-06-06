<?php
/**
 * ezcGraphPaletteTest 
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
class ezcGraphPaletteTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphPaletteTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testDefaultPalette()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertTrue(
            $chart->palette instanceof ezcGraphPalette,
            'No default palette was set.'
        );
        
        $this->assertTrue(
            $chart->palette instanceof ezcGraphPaletteTango,
            'Default pallete should be tango.'
        );
    }

    public function testChangePalette()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->palette = 'Black';
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertTrue(
            $chart->palette instanceof ezcGraphPalette,
            'No default palette was set.'
        );
        
        $this->assertTrue(
            $chart->palette instanceof ezcGraphPaletteBlack,
            'Default pallete should be tango.'
        );
    }

    public function testInvalidPalette()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->palette = 'Undefined';
        }
        catch ( ezcGraphUnknownPaletteException $e )
        {
            return true;
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphUnknownPaletteException.' );
    }

    public function testBackgroundColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EEEEEC' ),
            $chart->palette->background,
            'Background color not properly set.'
        );
    }

    public function testAxisColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#2E3436' ),
            $chart->palette->axisColor,
            'Axis color not properly set.'
        );
    }

    public function testDataSetColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#3465A4' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#4E9A06' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#CC0000' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EDD400' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#75505B' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#F57900' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#204A87' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#C17D11' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#3465A4' ),
            $chart->palette->dataSetColor,
            'Dataset color not properly set.'
        );
    }

    public function testDataSetSymbol()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraph::BULLET,
            $chart->palette->dataSetSymbol,
            'Symbol for datasets not properly set.'
        );

        $this->assertEquals(
            ezcGraph::BULLET,
            $chart->palette->dataSetSymbol,
            'Symbol for datasets not properly set.'
        );
    }

    public function testFontFace()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            'Vera.ttf',
            $chart->palette->fontFace,
            'Font face not properly set.'
        );
    }

    public function testFontColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#888A85' ),
            $chart->palette->fontColor,
            'Font color not properly set.'
        );
    }

    public function testBorderColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#BABDB6' ),
            $chart->palette->borderColor,
            'Border color not properly set.'
        );
    }

    public function testBorderWidth()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            0,
            $chart->palette->borderWidth,
            'Border width not properly set.'
        );
    }

    public function testPadding()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1,
            $chart->palette->padding,
            'Padding not properly set.'
        );
    }

    public function testMargin()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1,
            $chart->palette->margin,
            'Margin not properly set.'
        );
    }
}

?>
