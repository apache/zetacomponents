<?php
/**
 * ezcGraphAxisExactRendererTest 
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
class ezcGraphAxisExactRendererTest extends ezcGraphTestCase
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

    public function testDetermineCuttingPoint()
    {
        $aStart = new ezcGraphCoordinate( -1, -5 );
        $aDir = new ezcGraphCoordinate( 4, 3 );

        $bStart = new ezcGraphCoordinate( 1, 2 );
        $bDir = new ezcGraphCoordinate( 1, -2 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertEquals(
            $cuttingPosition,
            2.,
            'Cutting position should be <2>',
            .1
        );

        $cuttingPoint = new ezcGraphCoordinate(
            $bStart->x + $cuttingPosition * $bDir->x,
            $bStart->y + $cuttingPosition * $bDir->y
        );

        $this->assertEquals(
            $cuttingPoint,
            new ezcGraphCoordinate( 3., -2. ),
            'Wrong cutting point.',
            .1
        );
    }

    public function testDetermineCuttingPoint2()
    {
        $aStart = new ezcGraphCoordinate( 0, 2 );
        $aDir = new ezcGraphCoordinate( 3, 1 );

        $bStart = new ezcGraphCoordinate( 2, -1 );
        $bDir = new ezcGraphCoordinate( 1, 2 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertEquals(
            $cuttingPosition,
            2.2,
            'Cutting position should be <2.2>',
            .1
        );

        $cuttingPoint = new ezcGraphCoordinate(
            $bStart->x + $cuttingPosition * $bDir->x,
            $bStart->y + $cuttingPosition * $bDir->y
        );

        $this->assertEquals(
            $cuttingPoint,
            new ezcGraphCoordinate( 4.2, 3.4 ),
            'Wrong cutting point.',
            .1
        );
    }

    public function testNoCuttingPoint()
    {
        $aStart = new ezcGraphCoordinate( 0, 0 );
        $aDir = new ezcGraphCoordinate( 1, 0 );

        $bStart = new ezcGraphCoordinate( 0, 1 );
        $bDir = new ezcGraphCoordinate( 3, 0 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertSame(
            $cuttingPosition,
            false,
            'There should not be a cutting point.'
        );
    }

    public function testRenderAxisGrid()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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

    public function testRenderAxisOuterGrid()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 142., 182., 178., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 222., 182., 258., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 422., 182., 458., 198. ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesWithoutLastLabel()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->xAxis->axisLabelRenderer->showLastValue = false;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 142., 182., 218., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 222., 182., 298., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 382., 182., 458., 198. ), 1. ),
                $this->equalTo( 'sample 4' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderAxisGridFromRight()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
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
                $this->equalTo( new ezcGraphBoundings( 422., 182., 458., 198. ), 1. ),
                $this->equalTo( 'sample 1' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 342., 182., 378., 198. ), 1. ),
                $this->equalTo( 'sample 2' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 142., 182., 178., 198. ), 1. ),
                $this->equalTo( 'sample 5' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::LEFT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromTop()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $chart->yAxis->position = ezcGraph::TOP;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 22., 138., 38. ), 1. ),
                $this->equalTo( '0' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 62., 138., 78. ), 1. ),
                $this->equalTo( '100' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 162., 138., 178. ), 1. ),
                $this->equalTo( '400' ),
                $this->equalTo( ezcGraph::BOTTOM | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBoxesFromBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $chart->yAxis->position = ezcGraph::BOTTOM;
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 162., 138., 178. ), 1. ),
                $this->equalTo( '0' ),
                $this->equalTo( ezcGraph::BOTTOM | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 122., 138., 138. ), 1. ),
                $this->equalTo( '100' ),
                $this->equalTo( ezcGraph::BOTTOM | ezcGraph::RIGHT )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 102., 22., 138., 38. ), 1. ),
                $this->equalTo( '400' ),
                $this->equalTo( ezcGraph::TOP | ezcGraph::RIGHT )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testAxisLabelRendererPropertyMajorStepCount()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            false,
            $axisLabelRenderer->majorStepCount,
            'Wrong default value for property majorStepCount in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->majorStepCount = 1;
        $this->assertSame(
            1,
            $axisLabelRenderer->majorStepCount,
            'Setting property value did not work for property majorStepCount in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->majorStepCount = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyMinorStepCount()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            false,
            $axisLabelRenderer->minorStepCount,
            'Wrong default value for property minorStepCount in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->minorStepCount = 1;
        $this->assertSame(
            1,
            $axisLabelRenderer->minorStepCount,
            'Setting property value did not work for property minorStepCount in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->minorStepCount = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyMajorStepSize()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            3,
            $axisLabelRenderer->majorStepSize,
            'Wrong default value for property majorStepSize in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->majorStepSize = 1;
        $this->assertSame(
            1,
            $axisLabelRenderer->majorStepSize,
            'Setting property value did not work for property majorStepSize in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->majorStepSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyMinorStepSize()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            1,
            $axisLabelRenderer->minorStepSize,
            'Wrong default value for property minorStepSize in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->minorStepSize = 2;
        $this->assertSame(
            2,
            $axisLabelRenderer->minorStepSize,
            'Setting property value did not work for property minorStepSize in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->minorStepSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyInnerStep()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            true,
            $axisLabelRenderer->innerStep,
            'Wrong default value for property innerStep in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->innerStep = false;
        $this->assertSame(
            false,
            $axisLabelRenderer->innerStep,
            'Setting property value did not work for property innerStep in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->innerStep = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyOuterStep()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            false,
            $axisLabelRenderer->outerStep,
            'Wrong default value for property outerStep in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->outerStep = true;
        $this->assertSame(
            true,
            $axisLabelRenderer->outerStep,
            'Setting property value did not work for property outerStep in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->outerStep = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyOuterGrid()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            false,
            $axisLabelRenderer->outerGrid,
            'Wrong default value for property outerGrid in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->outerGrid = true;
        $this->assertSame(
            true,
            $axisLabelRenderer->outerGrid,
            'Setting property value did not work for property outerGrid in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->outerGrid = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisLabelRendererPropertyLabelPadding()
    {
        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            2,
            $axisLabelRenderer->labelPadding,
            'Wrong default value for property labelPadding in class ezcGraphAxisExactLabelRenderer'
        );

        $axisLabelRenderer->labelPadding = 1;
        $this->assertSame(
            1,
            $axisLabelRenderer->labelPadding,
            'Setting property value did not work for property labelPadding in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $axisLabelRenderer->labelPadding = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisExactLabelRendererPropertyShowLastValue()
    {
        $options = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            true,
            $options->showLastValue,
            'Wrong default value for property showLastValue in class ezcGraphAxisExactLabelRenderer'
        );

        $options->showLastValue = false;
        $this->assertSame(
            false,
            $options->showLastValue,
            'Setting property value did not work for property showLastValue in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $options->showLastValue = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisExactLabelRendererPropertyRenderLastOutside()
    {
        $options = new ezcGraphAxisExactLabelRenderer();

        $this->assertSame(
            false,
            $options->renderLastOutside,
            'Wrong default value for property renderLastOutside in class ezcGraphAxisExactLabelRenderer'
        );

        $options->renderLastOutside = true;
        $this->assertSame(
            true,
            $options->renderLastOutside,
            'Setting property value did not work for property renderLastOutside in class ezcGraphAxisExactLabelRenderer'
        );

        try
        {
            $options->renderLastOutside = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testOutsideLabelsBottomLeft()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->legend = false;

        $graph->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $graph->xAxis->axisLabelRenderer->renderLastOutside = true;
        $graph->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $graph->yAxis->axisLabelRenderer->renderLastOutside = true;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testOutsideLabelsTopRight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->legend = false;

        $graph->xAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $graph->xAxis->axisLabelRenderer->renderLastOutside = true;
        $graph->xAxis->position = ezcGraph::RIGHT;
        $graph->yAxis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $graph->yAxis->axisLabelRenderer->renderLastOutside = true;
        $graph->yAxis->position = ezcGraph::TOP;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
