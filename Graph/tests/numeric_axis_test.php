<?php
/**
 * ezcGraphNumericAxisTest 
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
class ezcGraphNumericAxisTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphNumericAxisTest" );
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

    public function testFactoryNumericAxis()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertTrue(
            $chart->Y_axis instanceof ezcGraphChartElementNumericAxis
            );
    }

    public function testManualScaling()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->Y_axis->min = 10;
            $chart->Y_axis->max = 50;
            $chart->Y_axis->majorStep = 10;
            $chart->Y_axis->minorStep = 1;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            10.,
            $this->getNonPublicProperty( $chart->Y_axis, 'min' )
        );

        $this->assertEquals(
            50.,
            $this->getNonPublicProperty( $chart->Y_axis, 'max' )
        );

        $this->assertEquals(
            10.,
            $this->getNonPublicProperty( $chart->Y_axis, 'majorStep' )
        );

        $this->assertEquals(
            1.,
            $this->getNonPublicProperty( $chart->Y_axis, 'minorStep' )
        );
    }

    public function testManualScalingPublicProperties()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->Y_axis->min = 10;
            $chart->Y_axis->max = 50;
            $chart->Y_axis->majorStep = 10;
            $chart->Y_axis->minorStep = 1;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            10.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            50.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            10.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            1.,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 20, 70, 12, 130 );
            $chart->sample->color = '#FF0000';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            0.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            150.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            25.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            5.,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle2()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1, 4.3, .2, 3.82 );
            $chart->sample->color = '#FF0000';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            0.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            5.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            1.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .25,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle3()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => -1.8, 4.3, .2, 3.82 );
            $chart->sample->color = '#FF0000';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            -2.5,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            5.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            2.5,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .5,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle4()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1000.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1500.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            100.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            25.,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingMultiple()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1000.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1750.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            250.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            50.,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->majorStep = 50;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1000.,
            $chart->Y_axis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1450.,
            $chart->Y_axis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            50.,
            $chart->Y_axis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            10.,
            $chart->Y_axis->minorStep,
            'As value for: minorStep; '
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
