<?php
/**
 * ezcGraphLabeledAxisTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphLabeledAxisTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphLabeledAxisTest" );
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

    protected function getRandomData( $count, $min = 0, $max = 1000, $randomize = 23 )
    {
        $data = parent::getRandomData( $count, $min, $max, $randomize );

        foreach ( $data as $k => $v )
        {
            $data[(string) ($k + 2000)] = $v;
            unset( $data[$k] );
        }

        return $data;
    }

    public function testFactoryLabeledAxis()
    {
        $chart = new ezcGraphLineChart();

        $this->assertTrue(
            $chart->xAxis instanceof ezcGraphChartElementLabeledAxis
        );
    }

    public function testAutomaticLabelingSingle()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 20, 70, 12, 130 ) );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
            ),
            $this->readAttribute( $chart->xAxis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultiple()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->data['sample2'] = new ezcGraphArrayDataSet( array( 2002 => 1270, 1170, 1610, 1370 ) );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
            ),
            $this->readAttribute( $chart->xAxis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultiple2()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 1 => 1, 3 => 3, 5 => 5, 8 => 8 ) );
        $chart->data['sample2'] = new ezcGraphArrayDataSet( array( 1, 2, 3, 4, 5, 6, 7, 8 ) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array( 0, 1, 2, 3, 4, 5, 6, 7, 8 ),
            $this->readAttribute( $chart->xAxis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultipleMixed()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 2001 => 1300, 2004 => 1012, 2006 => 1450 ) );
        $chart->data['sample2'] = new ezcGraphArrayDataSet( array( 2001 => 1270, 1170, 1610, 1370, 1559 ) );
        $chart->render( 500, 200 );

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
            $this->readAttribute( $chart->xAxis, 'labels' )
        );
    }

    public function testPositionLeft()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->xAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '2000' ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .33,
            $chart->xAxis->getCoordinate( 2001 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '2003' ),
            'Wrong maximum value. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '1991' ),
            'Wrong return for unknown value. ',
            .05
        );
    }

    public function testPositionRight()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '2000' ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .66,
            $chart->xAxis->getCoordinate( 2001 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '2003' ),
            'Wrong maximum value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '1991' ),
            'Wrong return for unknown value. ',
            .05
        );
    }

    public function testPositionTop()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->xAxis->position = ezcGraph::TOP;
        $chart->render( 500, 200 );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '2000' ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .33,
            $chart->xAxis->getCoordinate( 2001 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '2003' ),
            'Wrong maximum value. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '1991' ),
            'Wrong return for unknown value. ',
            .05
        );
    }

    public function testPositionBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->xAxis->position = ezcGraph::BOTTOM;
        $chart->render( 500, 200 );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '2000' ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .66,
            $chart->xAxis->getCoordinate( 2001 ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            .0,
            $chart->xAxis->getCoordinate( '2003' ),
            'Wrong maximum value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $chart->xAxis->getCoordinate( '1991' ),
            'Wrong return for unknown value. ',
            .05
        );
    }

    public function testAutomaticLabelingWithLotsOfLabels()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450, 341, 421, 452, 1203, 540, 1104, 1503, 1204, 1402, 652, 972, 230, 1502, 1305, 983, 872, 934, 1423 ) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2003,
                2006,
                2009,
                2012,
                2015,
                2018,
                2021,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testAutomaticLabelingWithLotsOfLabels2()
    {
        $labelCount = 31;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2003,
                2006,
                2009,
                2012,
                2015,
                2018,
                2021,
                2024,
                2027,
                2030,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testAutomaticLabelingWithLotsOfLabels3()
    {
        $labelCount = 32;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2004,
                2007,
                2011,
                2014,
                2018,
                2021,
                2025,
                2028,
                2031,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testAutomaticLabelingWithLotsOfLabels4()
    {
        $labelCount = 165;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2041,
                2082,
                2123,
                2164,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testProvidedLabelsIdentity()
    {
        $chart = new ezcGraphLineChart();
        $chart->xAxis->provideLabels( array( 2000, 2001, 2002 ) );
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 
            2000 => 42,
            2001 => 23,
            2002 => 5,
        ) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2001,
                2002,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testProvidedLabelsReordered()
    {
        $chart = new ezcGraphLineChart();
        $chart->xAxis->provideLabels( array( 2002, 2001, 2000 ) );
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 
            2000 => 42,
            2001 => 23,
            2002 => 5,
        ) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2002,
                2001,
                2000,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testProvidedLabelsAdditionalLabels()
    {
        $chart = new ezcGraphLineChart();
        $chart->xAxis->provideLabels( array( 2000, 2001, 2003, 2004, 2005 ) );
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 
            2001 => 23,
            2002 => 5,
            2004 => 42,
        ) );
        $chart->render( 500, 200 );

        $this->assertEquals(
            array(
                2000,
                2001,
                2002,
                2003,
                2004,
                2005,
            ),
            $this->readAttribute( $chart->xAxis, 'displayedLabels' )
        );
    }

    public function testGetLabel()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->render( 500, 200 );

        $this->assertSame(
            '2001',
            $chart->xAxis->getLabel( 1 ),
            'Wrong label returned for step.'
        );
    }

    public function testGetNonexistantLabel()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 1300, 1012, 1450 ) );
        $chart->render( 500, 200 );

        $this->assertSame(
            false,
            $chart->xAxis->getLabel( 5 ),
            'Wrong label returned for nonexisting step.'
        );
    }

    public function testRenderUnregularLabeling()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 32;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testChartElementNumericAxisPropertyLabelCount()
    {
        $options = new ezcGraphChartElementLabeledAxis();

        $this->assertSame(
            null,
            $options->labelCount,
            'Wrong default value for property labelCount in class ezcGraphChartElementNumericAxis'
        );

        $options->labelCount = 10;
        $this->assertSame(
            10,
            $options->labelCount,
            'Setting property value did not work for property labelCount in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelCount = 1;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderManualLabelCount1()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 4;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 3;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderManualLabelCount2()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 4;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 10;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderManualLabelCount3()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 35;
        $data = $this->getRandomData( $labelCount, 500, 2000, 2 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 7;

        $chart->render( 500, 200, $filename );

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
            $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 2001 => 1300, 2004 => 1012 ) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->xAxis->getSteps();

        $expectedLabels = array(
            '2000', '2001', '2004'
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

            $chart->xAxis->labelCallback = create_function(
                '$label',
                'return "*$label*";'
            );

            $chart->data['sample'] = new ezcGraphArrayDataSet( array( 2000 => 1045, 2001 => 1300, 2004 => 1012 ) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $chart->xAxis->getSteps();

        $expectedLabels = array(
            '*2000*', '*2001*', '*2004*'
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
