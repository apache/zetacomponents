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
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->moreData = array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329);
        $chart->evenMoreData = array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450);
        $chart->evenMoreData->label = 'Even more data';
    }

    public function testElementGenerationLegend()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->render( 500, 200 );
        
        $legend = $this->getNonPublicProperty( $chart->legend, 'labels' );

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

    public function testRenderChartLines()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->sampleData->color = '#CC0000';
        $chart->sampleData->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 28 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 85 ) ),
                $this->equalTo( new ezcGraphCoordinate( 210, 181 ) ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 29 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 210, 181 ) ),
                $this->equalTo( new ezcGraphCoordinate( 300, 44 ) ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 30 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 300, 44 ) ),
                $this->equalTo( new ezcGraphCoordinate( 390, 136 ) ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 31 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 390, 136 ) ),
                $this->equalTo( new ezcGraphCoordinate( 480, 190 ) ),
                $this->equalTo( true )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartSymbols()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->sampleData->color = '#CC0000';
        $chart->sampleData->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawSymbol',
        ) );

        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 116, 81 ) ),
                $this->equalTo( 8 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::DIAMOND )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 206, 177 ) ),
                $this->equalTo( 8 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::DIAMOND )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 296, 40 ) ),
                $this->equalTo( 8 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::DIAMOND )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 386, 132 ) ),
                $this->equalTo( 8 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::DIAMOND )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 476, 186 ) ),
                $this->equalTo( 8 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::DIAMOND )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testCompleteRendering()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'Line' );
        $chart->title = 'Test graph';
        $chart->palette = 'Black';

        $this->addSampleData( $chart );
        $chart->driver = new ezcGraphGdDriver();

        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->legend->font = $this->basePath . 'font2.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            'ef4deac70fa8c0ca3d4149fd65e31131',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }
}
?>
