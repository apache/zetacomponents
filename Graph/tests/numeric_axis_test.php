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
            $chart->yAxis instanceof ezcGraphChartElementNumericAxis
        );
    }

    public function testManualScaling()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->yAxis->min = 10;
        $chart->yAxis->max = 50;
        $chart->yAxis->majorStep = 10;
        $chart->yAxis->minorStep = 1;

        $this->assertEquals(
            10.,
            $this->getNonPublicProperty( $chart->yAxis, 'min' )
        );

        $this->assertEquals(
            50.,
            $this->getNonPublicProperty( $chart->yAxis, 'max' )
        );

        $this->assertEquals(
            10.,
            $this->getNonPublicProperty( $chart->yAxis, 'majorStep' )
        );

        $this->assertEquals(
            1.,
            $this->getNonPublicProperty( $chart->yAxis, 'minorStep' )
        );
    }

    public function testManualScalingPublicProperties()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->yAxis->min = 10;
        $chart->yAxis->max = 50;
        $chart->yAxis->majorStep = 10;
        $chart->yAxis->minorStep = 1;

        $this->assertEquals(
            10.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            50.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            10.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 20, 70, 12, 130 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            150.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            25.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle2()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1, 4.3, .2, 3.82 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .25,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle3()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => -1.8, 4.3, .2, 3.82 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            -2.5,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            2.5,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .5,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingSingle4()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            1000.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1500.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            100.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            25.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingMultiple()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            1000.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1750.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            250.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            50.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->majorStep = 50;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1000.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1450.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            50.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            10.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling2()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->min = 0;
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1500.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            500.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            100.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling3()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->max = 2000;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1000.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            2000.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            250.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            50.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling4()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->min = 0;
        $chart->yAxis->max = 2000;
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            2000.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            1000.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            250.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testPositionLeft()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( 1000 ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .4,
            $chart->yAxis->getCoordinate( 1200 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( 1500 ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testPositionRight()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::RIGHT;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( 1000 ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .6,
            $chart->yAxis->getCoordinate( 1200 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( 1500 ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testPositionTop()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( 1000 ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            0.4,
            $chart->yAxis->getCoordinate( 1200 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( 1500 ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testPositionBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( 1000 ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .6,
            $chart->yAxis->getCoordinate( 1200 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( 1500 ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testPositionLeftNegativMinimum()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => -300, 1300, 1012, 1450 );
        $chart->yAxis->majorStep = 500;
        $chart->yAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $this->assertEquals(
            .25,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            0.,
            $chart->yAxis->getCoordinate( -500 ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .85,
            $chart->yAxis->getCoordinate( 1200 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->getCoordinate( 1500 ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testNullPositionMultipleDatasets()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['moreData'] = array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329);
        $chart['evenMoreData'] = array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450);
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.66,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );
    }
}

?>
