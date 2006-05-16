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

    public function testFactoryLegend()
    {
        $chart = ezcGraph::create( 'Pie' );

        $this->assertTrue(
            $chart->legend instanceof ezcGraphChartElementLegend
            );
    }

    public function testLegendSetBackground()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->background = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->background
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getNonPublicProperty( $chart->legend, 'background' )
        );
    }

    public function testLegendSetBorder()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->border = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->border
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getNonPublicProperty( $chart->legend, 'border' )
        );
    }

    public function testLegendSetBorderWidth()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->borderWidth = 1;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1,
            $chart->legend->borderWidth
        );

        $this->assertEquals(
            1,
            $this->getNonPublicProperty( $chart->legend, 'borderWidth' )
        );
    }

    public function testLegendSetPosition()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->position = ezcGraph::LEFT;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            3,
            $chart->legend->position
        );

        $this->assertEquals(
            3,
            $this->getNonPublicProperty( $chart->legend, 'position' )
        );
    }

    public function testRender()
    {
        throw new PHPUnit2_Framework_IncompleteTestError(
            '@TODO: Implement renderer tests.'
        );
    }
}
?>
