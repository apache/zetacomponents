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
        $chart->sample = array( 2000 => 20, 70, 12, 130 );
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
        $chart->sample = array( 2000 => 1, 4.3, .2, 3.82 );
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
        $chart->sample = array( 2000 => -1.8, 4.3, .2, 3.82 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            67.5,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            193.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionRight()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::RIGHT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            382.5,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            382.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            256.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            67.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionTop()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            87.75,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            87.75,
            $chart->yAxis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            179.55,
            $chart->yAxis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            317.25,
            $chart->yAxis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            317.25,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            317.25,
            $chart->yAxis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            225.45,
            $chart->yAxis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            87.75,
            $chart->yAxis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionLeftNegativMinimum()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => -300, 1300, 1012, 1450 );
        $chart->yAxis->majorStep = 500;
        $chart->yAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            146.25,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->yAxis->getCoordinate( $testBoundings, -500 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            335.25,
            $chart->yAxis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->yAxis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testNullPositionMultipleDatasets()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->moreData = array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329);
        $chart->evenMoreData = array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450);
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 100;
        $testBoundings->x1 = 500;
        $testBoundings->y0 = 0;
        $testBoundings->y1 = 200;

        $this->assertEquals(
            130,
            $chart->yAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );
    }

    public function testRenderNumericAxisBase()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // Y-Axis
            // Base line
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 200 ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 0 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisArrowHead()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawPolygon',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 120, 0 ),
                    new ezcGraphCoordinate( 123, 5 ),
                    new ezcGraphCoordinate( 118, 5 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisMajor()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // Y-Axis
            // Major step lines
        $mockedRenderer
            ->expects( $this->at( 6 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 124, 190 ) ),
                $this->equalTo( new ezcGraphCoordinate( 116, 190 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 7 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 124, 130 ) ),
                $this->equalTo( new ezcGraphCoordinate( 116, 130 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 8 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 124, 70 ) ),
                $this->equalTo( new ezcGraphCoordinate( 116, 70 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 9 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 124, 10 ) ),
                $this->equalTo( new ezcGraphCoordinate( 116, 10 ) ),
                $this->equalTo( false )
            );


        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisMajorGrid()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->grid = ezcGraphColor::fromHex( '#BBBBBB' );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 6 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 190 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 190 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 8 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 154 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 154 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 16 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 10 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 10 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisMinor()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // Y-Axis
            // Minor step lines
        $mockedRenderer
            ->expects( $this->at( 10 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 122, 190 ) ),
                $this->equalTo( new ezcGraphCoordinate( 118, 190 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 11 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 122, 178 ) ),
                $this->equalTo( new ezcGraphCoordinate( 118, 178 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 12 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 122, 166 ) ),
                $this->equalTo( new ezcGraphCoordinate( 118, 166 ) ),
                $this->equalTo( false )
            );

            // Last minor step
        $mockedRenderer
            ->expects( $this->at( 24 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 122, 22 ) ),
                $this->equalTo( new ezcGraphCoordinate( 118, 22 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisMinorGrid()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->yAxis->minorGrid = '#BBBBBB';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 12 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 190 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 190 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 14 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 181 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 181 ) ),
                $this->equalTo( false )
            );

            // Last minor step
        $mockedRenderer
            ->expects( $this->at( 50 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 19 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 19 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisLabels()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 7 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 130 ) ),
                $this->equalTo( '1000' ),
                $this->equalTo( 18 ),
                $this->equalTo( 58 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::BOTTOM )
            );
        $mockedRenderer
            ->expects( $this->at( 8 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 70 ) ),
                $this->equalTo( '1250' ),
                $this->equalTo( 18 ),
                $this->equalTo( 58 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::BOTTOM )
            );
        $mockedRenderer
            ->expects( $this->at( 9 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 100, 10 ) ),
                $this->equalTo( '1500' ),
                $this->equalTo( 18 ),
                $this->equalTo( 58 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::BOTTOM )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericXAndYAxisLabels()
    {
        $sin = array();
        for ( $i = -200; $i < 500; $i += 2 )
        {
            $sin[$i] = 25 * sin( $i / 50 );
        }

        $chart = ezcGraph::create( 'Line' );
        $chart->xAxis = new ezcGraphChartElementNumericAxis();
        $chart->sinus = $sin;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 122, 102 ) ),
                $this->equalTo( '-250' ),
                $this->equalTo( 118 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 242, 102 ) ),
                $this->equalTo( '0' ),
                $this->equalTo( 118 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 363, 102 ) ),
                $this->equalTo( '250' ),
                $this->equalTo( 118 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 363, 102 ) ),
                $this->equalTo( '500' ),
                $this->equalTo( 118 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::TOP )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 500, 200 );
    }

    public function testValueZeroAmplitude()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 70, 70, 70, 70 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            60.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            80.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testValueAllZero()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 0, 0 );
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            .25,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .05,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testSetNumericAxis()
    {
        $chart = ezcGraph::create( 'line' );
        $chart->xAxis = new ezcGraphChartElementNumericAxis();
        $chart->yAxis = new ezcGraphChartElementNumericAxis();

        $this->assertTrue(
            $chart->xAxis instanceof ezcGraphChartElementNumericAxis,
            'X axis should be numeric.'
        );

        $this->assertTrue(
            $chart->yAxis instanceof ezcGraphChartElementNumericAxis,
            'Y axis should be numeric.'
        );
    }
}

?>
