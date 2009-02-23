<?php
/**
 * ezcGraphLogarithmicalAxisTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphLogarithmicalAxisTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphLogarithmicalAxisTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testChartElementLogarithmicalAxisPropertyMin()
    {
        $options = new ezcGraphChartElementLogarithmicalAxis();

        $this->assertSame(
            null,
            $options->min,
            'Wrong default value for property min in class ezcGraphChartElementLogarithmicalAxis'
        );

        $options->min = 1;
        $this->assertSame(
            1.,
            $options->min,
            'Setting property value did not work for property min in class ezcGraphChartElementLogarithmicalAxis'
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

    public function testChartElementLogarithmicalAxisPropertyMax()
    {
        $options = new ezcGraphChartElementLogarithmicalAxis();

        $this->assertSame(
            null,
            $options->max,
            'Wrong default value for property max in class ezcGraphChartElementLogarithmicalAxis'
        );

        $options->max = 1;
        $this->assertSame(
            1.,
            $options->max,
            'Setting property value did not work for property max in class ezcGraphChartElementLogarithmicalAxis'
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

    public function testChartElementLogarithmicalAxisPropertyBase()
    {
        $options = new ezcGraphChartElementLogarithmicalAxis();

        $this->assertSame(
            10,
            $options->base,
            'Wrong default value for property base in class ezcGraphChartElementLogarithmicalAxis'
        );

        $options->base = M_E;
        $this->assertSame(
            M_E,
            $options->base,
            'Setting property value did not work for property base in class ezcGraphChartElementLogarithmicalAxis'
        );

        try
        {
            $options->base = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLogarithmicalAxisPropertyFormatString()
    {
        $options = new ezcGraphChartElementLogarithmicalAxis();

        $this->assertSame(
            '%1$d^%2$d',
            $options->logarithmicalFormatString,
            'Wrong default value for property logarithmicalFormatString in class ezcGraphChartElementLogarithmicalAxis'
        );

        $options->logarithmicalFormatString = '%2$.2f^%1$d';
        $this->assertSame(
            '%2$.2f^%1$d',
            $options->logarithmicalFormatString,
            'Setting property value did not work for property logarithmicalFormatString in class ezcGraphChartElementLogarithmicalAxis'
        );
    }

    public function testManualScaling()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis->min = -5;
        $chart->yAxis->max = 5;
        $chart->yAxis->majorStep = 2;
        $chart->yAxis->minorStep = 1;

        $this->assertEquals(
            -5.,
            $chart->yAxis->min
        );

        $this->assertEquals(
            5.,
            $chart->yAxis->max
        );

        $this->assertEquals(
            2.,
            $chart->yAxis->majorStep
        );

        $this->assertEquals(
            1.,
            $chart->yAxis->minorStep
        );
    }

    public function testAutomagicScalingMultiple()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( .003, 12, 43, 1023, .02, 1.5 ) );
        $chart->render( 500, 300 );

        $this->assertEquals(
            -3,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            4,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals(
            1,
            $chart->yAxis->majorStep,
            'As value for: majorStep; '
        );

        $this->assertEquals(
            1,
            $chart->yAxis->minorStep,
            'As value for: minorStep; '
        );
    }

    public function testAutomagicScalingException()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();

        try
        {
            $chart->data['sample'] = new ezcGraphArrayDataSet( array( .003, 12, 43, 1023, .02, -1.5 ) );
            $chart->render( 500, 300 );
        }
        catch ( ezcGraphOutOfLogithmicalBoundingsException $e )
        {
            return true;
        }

        $this->fail( 'Expect ezcGraphOutOfLogithmicalBoundingsException.' );
    }

    public function testAutomagicScalingValues()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();

        $chart->data['sample'] = new ezcGraphArrayDataSet( array( .03, 12, 43, 1023, .02, 1.5, 9823 ) );
        $chart->render( 500, 300 );

        $this->assertEquals(
            -2,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            4,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( .01 ),
            1,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( .1 ),
            .833,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 1 ),
            .667,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 10 ),
            .5,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 100 ),
            .333,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 1000 ),
            .167,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 10000 ),
            0,
            'Wrong value calculated on logarithmical axis.',
            .001
        );
    }

    public function testAutomagicScalingValuesBase2()
    {
        $chart = new ezcGraphLineChart();
        $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();
        $chart->yAxis->base = 2;

        $chart->data['sample'] = new ezcGraphArrayDataSet( array( .03, 12, 43, 1023, .02, 1.5, 3823 ) );
        $chart->render( 500, 300 );

        $this->assertEquals(
            -6,
            $chart->yAxis->min,
            'As value for: min; '
        );

        $this->assertEquals(
            12,
            $chart->yAxis->max,
            'As value for: max; '
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( .015625 ),
            1,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( .125 ),
            .833,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 1 ),
            .667,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 8 ),
            .5,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 64 ),
            .333,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 512 ),
            .167,
            'Wrong value calculated on logarithmical axis.',
            .001
        );

        $this->assertEquals( 
            $chart->yAxis->getCoordinate( 4096 ),
            0,
            'Wrong value calculated on logarithmical axis.',
            .001
        );
    }

    public function testRenderCompleteImage()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteEz();
        $chart->title = 'Function x^2 with logarithmical axis scaling';
        $chart->legend = false;
        
        $chart->xAxis = new ezcGraphChartElementNumericAxis();

        $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();
        $chart->yAxis->logarithmicalFormatString = '^%2$d';
        $chart->yAxis->label = 'Base 10';

        $values = array();
        for ( $x = -50; $x <= 50; $x += 1 )
        {
            $values[$x] = $x * $x + .01;
        }

        $chart->data['x^2'] = new ezcGraphArrayDataSet( $values );
        $chart->data['x^2']->symbol = ezcGraph::NO_SYMBOL;

        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderedLabels()
    {
        try
        {
            $chart = new ezcGraphLineChart();
            $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();
            $chart->data['sample'] = new ezcGraphArrayDataSet( array( .03, 12, 43, 1023, .02, 1.5, 9823 ) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->yAxis->getSteps();

        $expectedLabels = array(
            '10^-2', '10^-1', '10^0', '10^1', '10^2', '10^3', '10^4',
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

    public function testRenderedLabelsWithLabelFormattingCallback()
    {
        try
        {
            $chart = new ezcGraphLineChart();

            $chart->yAxis = new ezcGraphChartElementLogarithmicalAxis();
            $chart->yAxis->labelCallback = create_function(
                '$label',
                'return "*$label*";'
            );

            $chart->data['sample'] = new ezcGraphArrayDataSet( array( .03, 12, 43, 1023, .02, 1.5, 9823 ) );

            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->yAxis->getSteps();

        $expectedLabels = array(
            '*10^-2*', '*10^-1*', '*10^0*', '*10^1*', '*10^2*', '*10^3*', '*10^4*',
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
