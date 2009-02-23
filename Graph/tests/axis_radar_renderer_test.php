<?php
/**
 * ezcGraphAxisRadarRendererTest 
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
class ezcGraphAxisRadarRendererTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $renderer;

    protected $driver;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

    public function testRenderAxisGrid()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120 ) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 1340., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 1300., 80. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 1370., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 1300., 65. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

//        $chart->renderer = $mockedRenderer;
        $chart->driver = new ezcGraphVerboseDriver();

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridZeroAxisSpace()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->axis->axisSpace = 0;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 180., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 180., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 500., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 500., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisOuterGrid()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->axis->axisLabelRenderer->outerGrid = true;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 0. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 200. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 0. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 200. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisSteps()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepRadar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204, 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204, 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisNoOuterSteps()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->axis->axisLabelRenderer->outerStep = false;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepRadar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisNoInnerSteps()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->axis->axisLabelRenderer->innerStep = false;
        $chart->axis->axisLabelRenderer->outerStep = true;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepRadar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepRadar' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisNoSteps()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->axis->axisLabelRenderer->innerStep = false;
        $chart->axis->axisLabelRenderer->outerStep = false;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepRadar',
        ) );

        $mockedRenderer
            ->expects( $this->exactly( 0 ) )
            ->method( 'drawStepRadar' );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxes()
    {
        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 142., 182., 202., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 398., 182., 458., 198. ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}
?>
