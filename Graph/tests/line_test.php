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
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    protected function addSampleData( ezcGraphChart $chart )
    {
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->sampleData->color = '#0000FF';
        $chart->sampleData->symbol = ezcGraph::DIAMOND;
        $chart->moreData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->moreData->color = '#FF0000';
        $chart->evenMoreData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->evenMoreData->color = '#FF0000';
        $chart->evenMoreData->label = 'Even more data';
    }

    public function testElementGenerationLegend()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
        
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
            ezcGraphColor::fromHex( '#0000FF' ),
            $legend[0]['color'],
            'Color for first label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $legend[1]['color'],
            'Color for second label is wrong.'
        );
    }

    public function testRenderLegendBackground()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );
            $mockedRenderer
                ->expects( $this->once() )
                ->method( 'drawBackground' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 0, 0 ) ),
                    $this->equalTo( 100 ),
                    $this->equalTo( 200 )
                );
            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendSymbols()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );

            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 1 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 3 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 15 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 5 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 29 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendText()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );

            $mockedRenderer
                ->expects( $this->at( 2 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 14, 1 ) ),
                    'sampleData',
                    $this->equalTo( 85 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 4 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 14, 15 ) ),
                    'moreData',
                    $this->equalTo( 85 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 6 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 14, 29 ) ),
                    'Even more data',
                    $this->equalTo( 85 ),
                    $this->equalTo( 12 )
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendBackgroundRight()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->position = ezcGraph::RIGHT;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );
            $mockedRenderer
                ->expects( $this->once() )
                ->method( 'drawBackground' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 400., 0 ) ),
                    $this->equalTo( 100 ),
                    $this->equalTo( 200 )
                );
            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendSymbolsRight()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->position = ezcGraph::RIGHT;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );

            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401., 1 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 3 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401., 15 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 5 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401., 29 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }


    public function testRenderLegendBackgroundBottom()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->position = ezcGraph::BOTTOM;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );
            $mockedRenderer
                ->expects( $this->once() )
                ->method( 'drawBackground' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 0, 180. ) ),
                    $this->equalTo( 500 ),
                    $this->equalTo( 20 )
                );
            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendSymbolsBottom()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->position = ezcGraph::BOTTOM;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawBackground',
                'drawTextBox',
                'drawSymbol',
            ) );

            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 181. ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 3 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 101, 181. ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 5 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 201, 181. ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 300, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRender()
    {
        throw new PHPUnit2_Framework_IncompleteTestError(
            '@TODO: Implement renderer tests for custom padding size.'
        );
        throw new PHPUnit2_Framework_IncompleteTestError(
            '@TODO: Implement renderer tests checking minum symbol size'
        );
    }
}
?>

