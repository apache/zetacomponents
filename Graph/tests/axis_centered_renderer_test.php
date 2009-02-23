<?php
/**
 * ezcGraphAxisCenteredRendererTest 
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
class ezcGraphAxisCenteredRendererTest extends ezcTestCase
{
    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphAxisCenteredRendererTest" );
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
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
                $this->equalTo( new ezcGraphCoordinate( 200., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
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
                $this->equalTo( new ezcGraphCoordinate( 220., 0. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 200. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220, 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220, 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisOuterSteps()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->outerStep = true;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 460., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisNoInnerSteps()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
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
                $this->equalTo( new ezcGraphCoordinate( 220., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->innerStep = false;
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 182., 182., 258., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 422., 182., 498., 198. ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesWithZeroValue()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->showZeroValue = true;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 182., 178., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 182., 182., 258., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 422., 182., 498., 198. ), 1. ),
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
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
                $this->equalTo( new ezcGraphCoordinate( 380., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 380., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
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
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 30. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 30. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A8588' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridFromBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 170. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 460., 170. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A8588' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromRight()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
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
                $this->equalTo( new ezcGraphBoundings( 342., 182., 418., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::CENTER )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 182., 178., 198. ), 1. ),
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
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 42., 138., 78. ), 1. ),
                $this->equalTo( '100' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 162., 138., 198. ), 1. ),
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
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 122., 138., 158. ), 1. ),
                $this->equalTo( '100' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 2., 138., 38. ), 1. ),
                $this->equalTo( '400' ),
                $this->equalTo( ezcGraph::MIDDLE | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testAxisCenteredLabelRendererPropertyShowZeroValue()
    {
        $options = new ezcGraphAxisCenteredLabelRenderer();

        $this->assertSame(
            false,
            $options->showZeroValue,
            'Wrong default value for property showZeroValue in class ezcGraphAxisCenteredLabelRenderer'
        );

        $options->showZeroValue = true;
        $this->assertSame(
            true,
            $options->showZeroValue,
            'Setting property value did not work for property showZeroValue in class ezcGraphAxisCenteredLabelRenderer'
        );

        try
        {
            $options->showZeroValue = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
