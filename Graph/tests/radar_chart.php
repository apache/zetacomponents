<?php
/**
 * ezcGraphRadarChartTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphRadarChartTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphRadarChartTest" );
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

    protected function getRandomData( $count, $min = 0, $max = 1000, $randomize = 23 )
    {
        // Make data reproducible
        mt_srand( $randomize );

        for ( $i = 0; $i < $count; ++$i )
        {
            $data[] = mt_rand( $min, $max );
        }

        return $data;
    }

    public function testDrawMultipleAxis()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawAxis',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 0. ), 1. )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 400., 100. ), 1. )
            );
        $mockedRenderer
           ->expects( $this->at( 3 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 0., 100. ), 1. )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testDrawDataLines()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawRadarDataLine',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .0525 ), .05 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .75, .3 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .0025 ), .05 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testDrawDataLinesWithSymbols()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawRadarDataLine',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .0525 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .75, .3 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .0025 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRadarSimple()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteTango();

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 6 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRadarMultiple()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->options->fillLines = 210;

        $chart->data['sample 1'] = new ezcGraphArrayDataSet( $this->getRandomData( 8 ) );
        $chart->data['sample 2'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 250, 1000, 12 ) );
        $chart->data['sample 3'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 0, 500, 42 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
