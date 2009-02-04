<?php
/**
 * ezcGraphAxisRotatedRendererTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphAxisRotatedRendererTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphAxisRotatedRendererTest" );
	}

    protected function setUp()
    {
        static $i = 0;

        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.1.3 or later." );
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

    protected function getRandomData( $count, $min = 500, $max = 2000, $randomize = 23 )
    {
        $data = parent::getRandomData( $count, $min, $max, $randomize );

        foreach ( $data as $k => $v )
        {
            $data[(string) ($k + 2000)] = $v;
            unset( $data[$k] );
        }

        return $data;
    }

    public function testRenderTextBoxes()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 146.3, 180., 160., 208.3 ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 160, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 221.3, 180., 235., 236.6 ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 235, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 446.3, 180., 460., 208.3 ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 460, 180 ) ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesNoOffset()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->xAxis->axisLabelRenderer->labelOffset = false;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 130., 180., 140., 208.3 ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 140, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 210., 180., 220., 236.6 ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 220, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 450., 180., 460., 208.3 ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 460, 180 ) ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxes3D()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer3d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 146.3, 180., 160., 208.3 ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 160, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 221.3, 180., 235., 236.6 ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 235, 180 ) ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 446.3, 180., 460., 208.3 ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT ),
                $this->equalTo( new ezcGraphRotation( -45, new ezcGraphCoordinate( 460, 180 ) ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testAxisRotatedLabelRendererPropertyAngle()
    {
        $options = new ezcGraphAxisRotatedLabelRenderer();

        $this->assertSame(
            null,
            $options->angle,
            'Wrong default value for property angle in class ezcGraphAxisRotatedLabelRenderer'
        );

        $options->angle = 89.5;
        $this->assertSame(
            89.5,
            $options->angle,
            'Setting property value did not work for property angle in class ezcGraphAxisRotatedLabelRenderer'
        );

        $options->angle = 410.5;
        $this->assertSame(
            50.5,
            $options->angle,
            'Setting property value did not work for property angle in class ezcGraphAxisRotatedLabelRenderer'
        );

        try
        {
            $options->angle = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisRotatedLabelRendererPropertyLabelOffset()
    {
        $options = new ezcGraphAxisRotatedLabelRenderer();

        $this->assertSame(
            true,
            $options->labelOffset,
            'Wrong default value for property labelOffset in class ezcGraphAxisRotatedLabelRenderer'
        );

        $options->labelOffset = false;
        $this->assertSame(
            false,
            $options->labelOffset,
            'Setting property value did not work for property labelOffset in class ezcGraphAxisRotatedLabelRenderer'
        );

        try
        {
            $options->labelOffset = 'true';
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        { /* Expecetd */ }
    }

    public function testRenderCompleteLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisSpace = .25;
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->yAxis->axisLabelRenderer->angle = 45;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderCompleteLineChartReverseRotated()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisSpace = .25;
        $chart->xAxis->axisLabelRenderer->angle = -45;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->yAxis->axisLabelRenderer->angle = -45;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 30;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 31;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabelsVertical()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 0;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabelsLargeAngle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 10;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 11;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 75;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dRotatedAxisWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 30;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 31;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testOptimalAngleCalculation()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        $this->assertEquals(
            $chart->xAxis->axisLabelRenderer->angle,
            76.,
            'Angle estimation wrong.',
            1.
        );

        $this->assertEquals(
            $chart->yAxis->axisLabelRenderer->angle,
            53.,
            'Angle estimation wrong.',
            1.
        );
    }

    public function testRenderWithModifiedAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->xAxis->axisSpace = 0.1;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0.05;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderWithZeroAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->xAxis->axisSpace = 0.1;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
