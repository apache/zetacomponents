<?php
/**
 * ezcGraphOdometerChartTest 
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
class ezcGraphOdometerChartTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphOdometerChartTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "These tests required atleast PHP 5.1.3" );
        }
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

    public function testOdometerChartOptionsPropertyBorderColor()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            ezcGraphColor::create( '#000000' ),
            $options->borderColor,
            'Wrong default value for property borderColor in class ezcGraphOdometerChartOptions'
        );

        $options->borderColor = '#FF0000';
        $this->assertEquals(
            ezcGraphColor::create( '#FF0000' ),
            $options->borderColor,
            'Setting property value did not work for property borderColor in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->borderColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testOdometerChartOptionsPropertyBorderWidth()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            0,
            $options->borderWidth,
            'Wrong default value for property borderWidth in class ezcGraphOdometerChartOptions'
        );

        $options->borderWidth = 4;
        $this->assertEquals(
            4,
            $options->borderWidth,
            'Setting property value did not work for property borderWidth in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->borderWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testOdometerChartOptionsPropertyStartColor()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            ezcGraphColor::create( '#4e9a06A0' ),
            $options->startColor,
            'Wrong default value for property startColor in class ezcGraphOdometerChartOptions'
        );

        $options->startColor = '#00FF00';
        $this->assertEquals(
            ezcGraphColor::create( '#00FF00' ),
            $options->startColor,
            'Setting property value did not work for property startColor in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->startColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testOdometerChartOptionsPropertyEndColor()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            ezcGraphColor::create( '#A40000A0' ),
            $options->endColor,
            'Wrong default value for property endColor in class ezcGraphOdometerChartOptions'
        );

        $options->endColor = '#FF0000';
        $this->assertEquals(
            ezcGraphColor::create( '#FF0000' ),
            $options->endColor,
            'Setting property value did not work for property endColor in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->endColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testOdometerChartOptionsPropertyMarkerWidth()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            2,
            $options->markerWidth,
            'Wrong default value for property markerWidth in class ezcGraphOdometerChartOptions'
        );

        $options->markerWidth = 4;
        $this->assertEquals(
            4,
            $options->markerWidth,
            'Setting property value did not work for property markerWidth in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->markerWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testOdometerChartOptionsPropertyOdometerHeight()
    {
        $options = new ezcGraphOdometerChartOptions();

        $this->assertEquals(
            .5,
            $options->odometerHeight,
            'Wrong default value for property odometerHeight in class ezcGraphOdometerChartOptions'
        );

        $options->odometerHeight = .3;
        $this->assertEquals(
            .3,
            $options->odometerHeight,
            'Setting property value did not work for property odometerHeight in class ezcGraphOdometerChartOptions'
        );

        try
        {
            $options->odometerHeight = 1.2;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testOdometerChartPropertyAxis()
    {
        $chart = new ezcGraphOdometerChart();

        $this->assertTrue(
            $chart->axis instanceof ezcGraphChartElementNumericAxis,
            'Wrong default value for property axis in class ezcGraphOdometerChart'
        );

        $chart->axis = new ezcGraphChartElementLabeledAxis();
        $this->assertTrue(
            $chart->axis instanceof ezcGraphChartElementLabeledAxis,
            'Setting property value did not work for property axis in class ezcGraphOdometerChart'
        );

        try
        {
            $chart->axis = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderOdometer()
    {
        $chart = new ezcGraphOdometerChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawOdometer',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawOdometer' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 0., 0., 500., 200. ), 1. ),
                $this->equalTo( $chart->axis ),
                $this->equalTo( $chart->options )
            )
            ->will(
                $this->returnValue( new ezcGraphBoundings(  0., 0., 500., 200. ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderOdometerMarker()
    {
        $chart = new ezcGraphOdometerChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 1, 'sample 5' => 120 ) );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawOdometerMarker',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawOdometerMarker' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 25., 50., 475., 150. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .585, .0 ), .001 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::create( '#3465A4' ) ),
                $this->equalTo( 2 )
            );

        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawOdometerMarker' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 25., 50., 475., 150. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0525, .0 ), .001 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::create( '#4E9A06' ) ),
                $this->equalTo( 2 )
            );

        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawOdometerMarker' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 25., 50., 475., 150. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .81, .0 ), .001 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::create( '#CC0000' ) ),
                $this->equalTo( 2 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testAddMultipleDatasets()
    {
        $chart = new ezcGraphOdometerChart();

        try
        {
            $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 1, 'sample 5' => 120 ) );
            $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 1, 'sample 5' => 120 ) );

            $chart->render( 500, 200 );
        }
        catch ( ezcGraphTooManyDataSetsExceptions $e )
        {
            return;
        }

        $this->fail( 'Expected ezcGraphTooManyDataSetsExceptions.' );
    }

    public function testNoDatasets()
    {
        $chart = new ezcGraphOdometerChart();

        try
        {
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return;
        }

        $this->fail( 'Expected ezcGraphNoDataException.' );
    }

    public function testIncompatibleRenderer()
    {
        $chart = new ezcGraphOdometerChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 1, 'sample 5' => 120 ) );

        try
        {
            $chart->renderer = new ezcGraphRenderer3d();
            $chart->render( 500, 200 );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderCompleteOdometer()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphOdometerChart();

        $chart->data['data'] = new ezcGraphArrayDataSet(
            array( 1, 7, 18 )
        );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderCompleteOdometerWithDifferentOptions()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphOdometerChart();

        $chart->data['data'] = new ezcGraphArrayDataSet(
            array( 1, 7, 18 )
        );

        $chart->options->borderWidth = 2;
        $chart->options->borderColor = '#2e3436';

        $chart->options->startColor = '#EEEEEC';
        $chart->options->endColor = '#A00000';

        $chart->options->markerWidth = 5;
        $chart->options->odometerHeight = .7;

        $chart->render( 300, 100, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderCompleteOdometerToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphOdometerChart();

        $chart->data['data'] = new ezcGraphArrayDataSet(
            array( 1, 7, 18 )
        );

        ob_start();
        // Suppress header already sent warning
        @$chart->renderToOutput( 500, 200 );
        file_put_contents( $filename, ob_get_clean() );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
