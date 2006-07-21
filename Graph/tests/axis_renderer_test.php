<?php
/**
 * ezcGraphAxisRendererTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphAxisRendererTest extends ezcTestCase
{

    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphAxisRendererTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        $this->renderer = new ezcGraphRenderer2D();

        $this->driver = $this->getMock( 'ezcGraphGdDriver', array(
            'drawPolygon',
            'drawLine',
            'drawTextBox',
            'drawCircleSector',
            'drawCircularArc',
            'drawCircle',
            'drawImage',
        ) );
        $this->renderer->setDriver( $this->driver );

        $this->driver->options->width = 400;
        $this->driver->options->height = 200;
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
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
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 180. ), 1. ),
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

    public function testRenderAxisOuterGrid()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart->xAxis->axisLabelRenderer->outerGrid = true;
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawGridLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 0. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 200. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 0. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 200. ), 1. ),
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
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220, 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220, 180. ), 1. ),
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

    public function testRenderAxisOuterSteps()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart->xAxis->axisLabelRenderer->outerStep = true;
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 177. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 183. ), 1. ),
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

    public function testRenderAxisNoInnerSteps()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart->xAxis->axisLabelRenderer->innerStep = false;
        $chart->xAxis->axisLabelRenderer->outerStep = true;
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 140., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 140., 183. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#EEEEEC' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawStepLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 220., 180. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 220., 183. ), 1. ),
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
        $chart = ezcGraph::create( 'Line' );
        $chart->palette = 'Black';
        $chart->xAxis->axisLabelRenderer->innerStep = false;
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        
        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawStepLine',
        ) );

        $mockedRenderer
            ->expects( $this->exactly( 0 ) )
            ->method( 'drawStepLine' );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}
?>
