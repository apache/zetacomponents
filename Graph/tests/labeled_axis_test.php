<?php
/**
 * ezcGraphLabeledAxisTest 
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
class ezcGraphLabeledAxisTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphLabeledAxisTest" );
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

    public function testFactoryLabeledAxis()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertTrue(
            $chart->X_axis instanceof ezcGraphChartElementLabeledAxis
            );
    }

    public function testAutomaticLabelingSingle()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 20, 70, 12, 130 );
            $chart->render();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
            ),
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultiple()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample2 = array( 2002 => 1270, 1170, 1610, 1370 );
            $chart->render();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
            ),
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultipleMixed()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 2001 => 1300, 2004 => 1012, 2006 => 1450 );
            $chart->sample2 = array( 2001 => 1270, 1170, 1610, 1370, 1559 );
            $chart->render();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
                '2006',
            ),
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testRender()
    {
        $this->fail( '@TODO: Implement renderer tests.' );
    }
}
?>
