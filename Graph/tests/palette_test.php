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
        $chart = ezcGraph::create( 'Line' );

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
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';

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
            // Silenced, because this throws an E_WARNING in devel mode,
            // caused by the non existing class ezcGraphPaletteUndefined
            @$chart->palette = 'Undefined';
        }
        catch ( ezcGraphUnknownPaletteException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownPaletteException.' );
    }

    public function testChartBackgroundColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EEEEEC' ),
            $chart->palette->chartBackground,
            'Background color not properly set.'
        );
    }

    public function testElementBackgroundColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000FF' ),
            $chart->palette->elementBackground,
            'Background color not properly set.'
        );
    }

    public function testAxisColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#2E3436' ),
            $chart->palette->axisColor,
            'Axis color not properly set.'
        );
    }

    public function testDataSetColor()
    {
        $chart = ezcGraph::create( 'Line' );

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
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraph::NO_SYMBOL,
            $chart->palette->dataSetSymbol,
            'Symbol for datasets not properly set.'
        );

        $this->assertEquals(
            ezcGraph::NO_SYMBOL,
            $chart->palette->dataSetSymbol,
            'Symbol for datasets not properly set.'
        );
    }

    public function testFontFace()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            'Vera.ttf',
            $chart->palette->fontFace,
            'Font face not properly set.'
        );
    }

    public function testFontColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#555753' ),
            $chart->palette->fontColor,
            'Font color not properly set.'
        );
    }

    public function testChartBorderColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000FF' ),
            $chart->palette->chartBorderColor,
            'Border color not properly set.'
        );
    }

    public function testChartBorderWidth()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            0,
            $chart->palette->chartBorderWidth,
            'Border width not properly set.'
        );
    }

    public function testElementBorderColor()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000FF' ),
            $chart->palette->elementBorderColor,
            'Border color not properly set.'
        );
    }

    public function testElementBorderWidth()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            0,
            $chart->palette->elementBorderWidth,
            'Border width not properly set.'
        );
    }

    public function testPadding()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            1,
            $chart->palette->padding,
            'Padding not properly set.'
        );
    }

    public function testMargin()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertEquals(
            0,
            $chart->palette->margin,
            'Margin not properly set.'
        );
    }

    public function testDatasetAutomaticColorization()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#3465A4' ),
            $chart->income->color->default,
            'Wrong automatic color set.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#4E9A06' ),
            $chart->spending->color->default,
            'Wrong automatic color set.'
        );
    }

    public function testChartBackground()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EEEEEC' ),
            $chart->options->background,
            'Chart background not set from pallet.'
        );
    }

    public function testChartElementBorder()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000FF' ),
            $chart->legend->border,
            'Chart background not set from pallet.'
        );
    }

    public function testChartElementBorderWidth()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $this->assertEquals(
            0,
            $chart->legend->borderWidth,
            'Chart background not set from pallet.'
        );
    }

    public function testChartElementAxisColor()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#2E3436' ),
            $chart->X_axis->border,
            'Chart background not set from pallet.'
        );
    }
}

?>
