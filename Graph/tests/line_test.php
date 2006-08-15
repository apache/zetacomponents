<?php
/**
 * ezcGraphLineChartTest 
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
class ezcGraphLineChartTest extends ezcTestCase
{
    
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphLineChartTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( 'ezcGraphGdDriverTest' . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        $this->removeTempDir();
    }

    protected function addSampleData( ezcGraphChart $chart )
    {
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );
    }

    public function testElementGenerationLegend()
    {
        $chart = new ezcGraphLineChart();
        $this->addSampleData( $chart );
        $chart->render( 500, 200 );
        
        $legend = $this->getAttribute( $chart->legend, 'labels' );

        $this->assertEquals(
            3,
            count( $legend ),
            'Count of legends items should be <3>'
        );

        $this->assertEquals(
            'sampleData',
            $legend[0]['label'],
            'Label of first legend item should be <sampleData>.'
        );

        $this->assertEquals(
            'Even more data',
            $legend[2]['label'],
            'Label of first legend item should be <Even more data>.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#3465A4' ),
            $legend[0]['color'],
            'Color for first label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#4E9A06' ),
            $legend[1]['color'],
            'Color for second label is wrong.'
        );
    }

    public function testInvalidDisplayType()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->displayType = ezcGraph::PIE;

        try 
        {
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphInvalidDisplayTypeException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDisplayTypeException.' );
    }

    public function testRenderChartLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartMixedBarsAndLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->displayType = ezcGraph::BAR;

        $chart->data['sampleData2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData2']->color = '#CC0000';
        $chart->data['sampleData2']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawBar',
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
           ->expects( $this->at( 9 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartBars()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['sampleData']->displayType = ezcGraph::BAR;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawBar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartFilledLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => -46, 'sample 4' => 120, 'sample 5'  => 100 ) );
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 100;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .6975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .45 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .5 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartSymbols()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['sampleData']->symbol['sample 3'] = ezcGraph::CIRCLE;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .9475 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .5, .19 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::CIRCLE ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}
?>
