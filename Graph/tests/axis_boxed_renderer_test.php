<?php
/**
 * ezcGraphAxisBoxedRendererTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphAxisBoxedRendererTest extends ezcTestCase
{
    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphAxisBoxedRendererTest" );
	}

    protected function setUp()
    {
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "These tests required atleast PHP 5.1.3" );
        }
    }

    public function testRenderAxisGrid()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridZeroAxisSpace()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0;
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
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->outerGrid = true;
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
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepLine' )
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
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->outerStep = false;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepLine' )
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
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->innerStep = false;
        $chart->xAxis->axisLabelRenderer->outerStep = true;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 204., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 204., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStepLine' )
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
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->innerStep = false;
        $chart->xAxis->axisLabelRenderer->outerStep = false;
        $chart->yAxis->axisLabelRenderer->innerStep = false;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->exactly( 0 ) )
            ->method( 'drawStepLine' );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxes()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
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

    public function testRenderAxisGridFromRight()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 396., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 396., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridFromTop()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 52. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 52. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridFromBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 148. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 148. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromRight()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 398., 182., 458., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 142., 182., 202., 198. ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromTop()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 22., 138., 50. ), 1. ),
                $this->equalTo( '0' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 150., 138., 178. ), 1. ),
                $this->equalTo( '400' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 150., 138., 178. ), 1. ),
                $this->equalTo( '0' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 22., 138., 50. ), 1. ),
                $this->equalTo( '400' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}
?>
