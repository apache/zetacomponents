<?php
/**
 * ezcGraphLegendTest 
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
class ezcGraphLegendTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphLegendTest" );
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

    protected function addSampleData( ezcGraphChart $chart )
    {
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['sampleData']->color = '#0000FF';
        $chart['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart['moreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['moreData']->color = '#FF0000';
        $chart['evenMoreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['evenMoreData']->color = '#FF0000';
        $chart['evenMoreData']->label = 'Even more data';
    }

    public function testFactoryLegend()
    {
        $chart = new ezcGraphPieChart();

        $this->assertTrue(
            $chart->legend instanceof ezcGraphChartElementLegend
            );
    }

    public function testLegendSetBackground()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->background = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->background
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getAttribute( $chart->legend, 'background' )
        );
    }

    public function testLegendSetBorder()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->border = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->border
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getAttribute( $chart->legend, 'border' )
        );
    }

    public function testLegendSetBorderWidth()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->borderWidth = 1;

        $this->assertEquals(
            1,
            $chart->legend->borderWidth
        );

        $this->assertEquals(
            1,
            $this->getAttribute( $chart->legend, 'borderWidth' )
        );
    }

    public function testLegendSetPosition()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->position = ezcGraph::LEFT;

        $this->assertEquals(
            ezcGraph::LEFT,
            $chart->legend->position
        );

        $this->assertEquals(
            ezcGraph::LEFT,
            $this->getAttribute( $chart->legend, 'position' )
        );
    }
}
?>
