<?php
/**
 * ezcGraphLineChartTest 
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
class ezcGraphMultipleAxisTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphMultipleAxisTest" );
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

    public function testAxisPropertyChartPosition()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertEquals(
            null,
            $options->chartPosition,
            'Wrong default value for property chartPosition in class ezcGraphChartElementNumericAxis'
        );

        $options->chartPosition = .3;
        $this->assertSame(
            .3,
            $options->chartPosition,
            'Setting property value did not work for property chartPosition in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->chartPosition = 15;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisContainerIterator()
    {
        $options = new ezcGraphLineChart();

        $axis = array();

        $options->additionalAxis[] = $axis[] = new ezcGraphChartElementNumericAxis();
        $options->additionalAxis[] = $axis[] = new ezcGraphChartElementNumericAxis();
        $options->additionalAxis['foo'] = $axis['foo'] = new ezcGraphChartElementLabeledAxis();

        foreach ( $options->additionalAxis as $key => $value )
        {
            $this->assertTrue(
                array_key_exists( $key, $axis ),
                "Expecteded key '$key' in both arrays."
            );

            $this->assertSame(
                $axis[$key],
                $value,
                "Value should be the same for key '$key'."
            );
        }
    }

    public function testAddAdditionalAxisToChart()
    {
        $chart = new ezcGraphLineChart();

        $this->assertTrue(
            $chart->additionalAxis instanceof ezcGraphAxisContainer,
            'Line chart option additionalAxis should be of ezcGraphAxisContainer.'
        );

        $this->assertSame(
            count( $chart->additionalAxis ),
            0,
            'The initial count of additional axis should be zero.'
        );

        $chart->additionalAxis[] = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            count( $chart->additionalAxis ),
            1,
            'The count of additional axis should be one.'
        );

        $chart->additionalAxis[] = new ezcGraphChartElementLabeledAxis();

        $this->assertSame(
            count( $chart->additionalAxis ),
            2,
            'The count of additional axis should be two.'
        );

        try
        {
            $chart->additionalAxis[] = $chart;
        }
        catch( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDatasetAxisAssignement()
    {
        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = new ezcGraphChartElementNumericAxis();
        $chart->additionalAxis['new base'] = new ezcGraphChartElementLabeledAxis();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->yAxis = $chart->additionalAxis['marker'];
        $chart->data['sampleData']->xAxis = $chart->additionalAxis['new base'];
        
        $this->assertTrue(
            $chart->data['sampleData']->yAxis->default instanceof ezcGraphChartElementNumericAxis,
            'yAxis property should point to a ezcGraphChartElementNumericAxis.'
        );

        $this->assertTrue(
            $chart->data['sampleData']->xAxis->default instanceof ezcGraphChartElementLabeledAxis,
            'xAxis property should point to a ezcGraphChartElementLabeledAxis.'
        );

        try
        {
            $chart->data['sampleData']->yAxis['sample 1'] = $chart->additionalAxis['marker'];
        }
        catch ( ezcGraphInvalidAssignementException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidAssignementException.' );
    }

    public function testDatasetAxisAssignementWithoutRegistration()
    {
        $chart = new ezcGraphLineChart();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->yAxis = new ezcGraphChartElementNumericAxis();
        $chart->data['sampleData']->xAxis = new ezcGraphChartElementLabeledAxis();
        
        $this->assertEquals(
            new ezcGraphChartElementNumericAxis(),
            $chart->data['sampleData']->yAxis->default,
            'yAxis property should point to a ezcGraphChartElementNumericAxis.'
        );

        $this->assertEquals(
            new ezcGraphChartElementLabeledAxis(),
            $chart->data['sampleData']->xAxis->default,
            'xAxis property should point to a ezcGraphChartElementLabeledAxis.'
        );

        try
        {
            $chart->data['sampleData']->xAxis[100] = new ezcGraphChartElementLabeledAxis();
        }
        catch ( ezcGraphInvalidAssignementException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidAssignementException.' );
    }

    public function testRenderNoMainAxisAssignement()
    {
        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = new ezcGraphChartElementNumericAxis();
        $chart->additionalAxis['new base'] = new ezcGraphChartElementLabeledAxis();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->yAxis = $chart->additionalAxis['marker'];
        $chart->data['sampleData']->xAxis = $chart->additionalAxis['new base'];
        
        try
        {
            $chart->render( 400, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoDataException.' );
    }

    public function testRenderNoLabelRendererFallBack()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = $marker = new ezcGraphChartElementNumericAxis();
        $chart->additionalAxis['empty'] = $empty = new ezcGraphChartElementNumericAxis();

        $marker->position = ezcGraph::BOTTOM;
        $marker->chartPosition = 1;

        $empty->position =  ezcGraph::BOTTOM;
        $empty->chartPosition = .5;
        $empty->label = 'Marker';

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 620, 'sample 5' => 1) );
        $chart->data['sampleData']->yAxis = $chart->additionalAxis['marker'];
        
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );

        $chart->render( 500, 200, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderNoLabelRendererFallBackXAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = $marker = new ezcGraphChartElementLabeledAxis();
        $chart->additionalAxis['empty'] = $empty = new ezcGraphChartElementLabeledAxis();

        $marker->position = ezcGraph::LEFT;
        $marker->chartPosition = 1;

        $empty->position =  ezcGraph::RIGHT;
        $empty->chartPosition = .0;
        $empty->label = 'Marker';

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1, 'sample 6' => 74) );
        $chart->data['sampleData']->xAxis = $chart->additionalAxis['marker'];
        
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );

        $chart->render( 500, 200, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderNoLabelRendererDifferentAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = $marker = new ezcGraphChartElementLabeledAxis();
        $chart->additionalAxis['empty'] = $empty = new ezcGraphChartElementLabeledAxis();

        $chart->xAxis->axisSpace = 0.1;
        $chart->yAxis->axisSpace = 0.05;

        $marker->position = ezcGraph::LEFT;
        $marker->axisSpace = .1;
        $marker->chartPosition = 1;

        $empty->position =  ezcGraph::BOTTOM;
        $empty->chartPosition = .5;
        $empty->label = 'Marker';

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1, 'sample 6' => 74) );
        $chart->data['sampleData']->xAxis = $chart->additionalAxis['marker'];
        
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );

        $chart->render( 500, 200, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderNoLabelRendererZeroAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->additionalAxis['marker'] = $marker = new ezcGraphChartElementLabeledAxis();
        $chart->additionalAxis['empty'] = $empty = new ezcGraphChartElementLabeledAxis();

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisSpace = 0;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0;

        $marker->position = ezcGraph::LEFT;
        $marker->axisSpace = 0;
        $marker->chartPosition = 1;

        $empty->position =  ezcGraph::RIGHT;
        $empty->chartPosition = .0;
        $empty->axisSpace = 0;
        $empty->label = 'Marker';

        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );

        $chart->render( 500, 200, $filename );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
