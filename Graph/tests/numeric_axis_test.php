<?php
/**
 * ezcGraphNumericAxisTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphNumericAxisTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphNumericAxisTest" );
	}

    public function testFactoryNumericAxis()
    {
        $chart = new ezcGraphLineChart();

        $this->assertTrue(
            $chart->yAxis instanceof ezcGraphChartElementNumericAxis
        );
    }

    public function testGetSteps()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 70, 12, 39, 87 ) );
        $chart->render( 500, 200 );

        $steps = $chart->yAxis->getSteps();

        $position = 0.;
        $label = 0.;
        foreach ( $steps as $nr => $step )
        {
            $this->assertEquals(
                $step->position,
                $position,
                "[$nr] Step position wrong.",
                .00001
            );
            $position += .25;

            $this->assertEquals(
                $step->width,
                .25,
                "[$nr] Step width wrong.",
                .00001
            );

            $this->assertEquals(
                $step->label,
                $label,
                "[$nr] Step label wrong.",
                .00001
            );
            $label += 25;

            if ( $nr < ( count( $steps ) - 1 ) )
            {
                $this->assertSame(
                    count( $step->childs ),
                    4,
                    "[$nr] Step child count wrong."
                );
            }
        }
    }

    public function testManualScaling()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->min = 10;
        $chart->yAxis->max = 50;
        $chart->yAxis->majorStep = 10;
        $chart->yAxis->minorStep = 1;

        $this->assertEquals(
            10.,
            $chart->yAxis->min
        );

        $this->assertEquals(
            50.,
            $chart->yAxis->max
        );

        $this->assertEquals(
            10.,
            $chart->yAxis->majorStep
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->minorStep
        );
    }

    public function testManualScalingPublicProperties()
    {
        $chart = new ezcGraphLineChart();
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 20, 70, 12, 130 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1, 4.3, .2, 3.82 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => -1.8, 4.3, .2, 3.82 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->data['sample2'] = new ezcGraphArrayDataSet( array( 2000 => 1270, 1170, 1610, 1370 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->yAxis->majorStep = 50;
        $chart->render( 500, 300 );

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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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

    public function testMixedAutomagicAndManualScaling5()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 4.5 ) );
        $chart->yAxis->majorStep = .5;
        $chart->render( 500, 200 );

        $this->assertEquals(
            4.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            .5,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .1,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling6()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 113.5 ) );
        $chart->yAxis->majorStep = .5;
        $chart->render( 500, 200 );

        $this->assertEquals(
            113.,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            114.,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            .5,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            .1,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling7()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 113.5, 1800, -45 ) );
        $chart->yAxis->majorStep = 500;
        $chart->yAxis->min = -100;
        $chart->render( 500, 200 );

        $this->assertEquals(
            -100,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1900,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            500,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            100,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testMixedAutomagicAndManualScaling8()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 113.5, 1800, -45 ) );
        $chart->yAxis->majorStep = 500;
        $chart->yAxis->max = 1900;
        $chart->render( 500, 200 );

        $this->assertEquals(
            -100,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            1900,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            500,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            100,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    /**
     * Tests bug #12581
     * 
     * @return void
     */
    public function testMixedAutomagicAndManualScaling9()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Material1' => 10,
            'Material2' => 11.1,
            'Material3' => 11.1,
            'Material4' => 9.7,
            'Material5' => 12.3,
            'Material6' => 6.4,
            'Material7' => 5.8,
            'Material8' => 5.4
        ) );
        $chart->yAxis->min = 0;
        $chart->yAxis->max = 13.53;
        $chart->render( 500, 200 );

        $this->assertEquals(
            0,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            13.53,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            2.706,
            $chart->yAxis->majorStep,
            'As value for: majorStep; ',
            .01
        );

        $this->assertEquals(
            0.5412,
            $chart->yAxis->minorStep,
            'As value for: minorStep; ',
            .01
        );
    }

    public function testMixedAutomagicAndManualScaling10()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->yAxis->min = 0;
        $chart->yAxis->max = 2000;
        $chart->yAxis->majorStep = 250;
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

    public function testMixedAutomagicAndManualScalingStepSizeFailure1()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->yAxis->min = 0;
        $chart->yAxis->max = 2000;
        $chart->yAxis->majorStep = 300;

        try
        {
            $chart->render( 500, 200 );
            $this->fail( 'Expected ezcGraphInvalidStepSizeException.' );
        }
        catch ( ezcGraphInvalidStepSizeException $e )
        { /* Expected */ }
    }

    public function testMixedAutomagicAndManualScalingStepSizeFailure2()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->yAxis->min = 0;
        $chart->yAxis->max = 2000;
        $chart->yAxis->majorStep = 250;
        $chart->yAxis->minorStep = 100;

        try
        {
            $chart->render( 500, 200 );
            $this->fail( 'Expected ezcGraphInvalidStepSizeException.' );
        }
        catch ( ezcGraphInvalidStepSizeException $e )
        { /* Expected */ }
    }

    public function testPositionLeft()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
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
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => -300, 1300, 1012, 1450 ) );
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

    public function testNullPositionMultipleDataSets()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            0.66,
            $chart->yAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );
    }

    public function testChartElementNumericAxisPropertyMin()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->min,
            'Wrong default value for property min in class ezcGraphChartElementNumericAxis'
        );

        $options->min = 1;
        $this->assertSame(
            1.,
            $options->min,
            'Setting property value did not work for property min in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->min = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementNumericAxisPropertyMax()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->max,
            'Wrong default value for property max in class ezcGraphChartElementNumericAxis'
        );

        $options->max = 1;
        $this->assertSame(
            1.,
            $options->max,
            'Setting property value did not work for property max in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->max = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderedLabels()
    {
        try
        {
            $chart = new ezcGraphLineChart();
            $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->yAxis->getSteps();

        $expectedLabels = array(
            '-100', '0', '100', '200', '300', '400',
        );

        foreach ( $steps as $nr => $step )
        {
            $this->assertEquals(
                $step->label,
                $expectedLabels[$nr],
                'Label not as expected'
            );
        }
    }

    public function testRenderedLabelsWithLabelFormattingCallback()
    {
        try
        {
            $chart = new ezcGraphLineChart();

            $chart->yAxis->labelCallback = create_function(
                '$label',
                'return "*$label*";'
            );

            $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->yAxis->getSteps();

        $expectedLabels = array(
            '*-100*', '*0*', '*100*', '*200*', '*300*', '*400*',
        );

        foreach ( $steps as $nr => $step )
        {
            $this->assertSame(
                $step->label,
                $expectedLabels[$nr],
                'Label not as expected'
            );
        }
    }
}

?>
