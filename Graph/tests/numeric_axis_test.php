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

    public function testPositionLeft()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->position = ezcGraph::LEFT;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            67.5,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            193.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionRight()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->position = ezcGraph::RIGHT;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            382.5,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            382.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            256.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            67.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionTop()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->position = ezcGraph::TOP;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            87.75,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            87.75,
            $chart->Y_axis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            179.55,
            $chart->Y_axis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            317.25,
            $chart->Y_axis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionBottom()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->position = ezcGraph::BOTTOM;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            317.25,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            317.25,
            $chart->Y_axis->getCoordinate( $testBoundings, 1000 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            225.45,
            $chart->Y_axis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            87.75,
            $chart->Y_axis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testPositionLeftNegativMinimum()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => -300, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->Y_axis->majorStep = 500;
            $chart->Y_axis->position = ezcGraph::LEFT;
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            146.25,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->Y_axis->getCoordinate( $testBoundings, -500 ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            335.25,
            $chart->Y_axis->getCoordinate( $testBoundings, 1200 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->Y_axis->getCoordinate( $testBoundings, 1500 ),
            'Wrong maximum value. '
        );
    }

    public function testNullPositionMultipleDatasets()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
            $chart->sampleData->color = '#CC0000';
            $chart->moreData = array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329);
            $chart->moreData->color = '#3465A4';
            $chart->evenMoreData = array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450);
            $chart->evenMoreData->color = '#73D216';
            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 100;
        $testBoundings->x1 = 500;
        $testBoundings->y0 = 0;
        $testBoundings->y1 = 200;

        $this->assertEquals(
            130,
            $chart->Y_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );
    }

    public function testRenderNumericAxisBase()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';

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
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderNumericAxisArrowHead()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';

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
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderNumericAxisMajor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';

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
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderNumericAxisMinor()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';

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
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderNumericAxisLabels()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
            $chart->sample->color = '#FF0000';
            $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );
            $chart->sample2->color = '#00FF00';

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
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }
}
?>
