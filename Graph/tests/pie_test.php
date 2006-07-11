<?php
/**
 * ezcGraphPieChartTest 
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
class ezcGraphPieChartTest extends ezcTestCase
{

    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphPieChartTest" );
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

    public function testElementGenerationLegend()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->render( 500, 200 );
        
        $legend = $this->getNonPublicProperty( $chart->legend, 'labels' );

        $this->assertEquals(
            5,
            count( $legend ),
            'Count of legends items should be <5>'
        );

        $this->assertEquals(
            'sample 1',
            $legend[0]['label'],
            'Label of first legend item should be <sample 1>.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#CC0000' ),
            $legend[1]['color'],
            'Default color for single label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EDD400' ),
            $legend[2]['color'],
            'Special color for single label is wrong.'
        );
    }

    public function testPieRenderPieSegments()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['sample'] = array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        );

        $chart['sample']->highlight['wget'] = true;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawPieSegment',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#4E9A06' ) ),
                $this->equalTo( 0., 1. ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 'Mozilla' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
               $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 'IE' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#EDD400' ) ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 'Opera' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#75505B' ) ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 'wget' ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#F57900' ) ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 360., 1. ),
                $this->equalTo( 'Safari' ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 400, 200 );
    }
}
?>
