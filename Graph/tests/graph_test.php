<?php
/**
 * ezcGraphTest 
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
class ezcGraphTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphTest" );
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

    public function testFactoryPieChart()
    {
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertTrue(
            $pieChart instanceof ezcGraphPieChart,
            'ezcGraph::create did not return a ezcGraphPieChart'
        );
    }

    public function testFactoryLineChart()
    {
        try 
        {
            $lineChart = ezcGraph::create( 'Line' );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertTrue(
            $lineChart instanceof ezcGraphLineChart,
            'ezcGraph::create did not return a ezcGraphLineChart'
        );
    }

    public function testFactoryUnknownChart()
    {
        try
        {
            $unknownChart = ezcGraph::create( 'Unknown' );
        }
        catch ( ezcGraphUnknownChartTypeException $e )
        {
            return true;
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphUnknownChartTypeException' );
    }
}
?>
