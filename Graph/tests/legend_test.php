<?php
/**
 * ezcGraphLegendTest 
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
class ezcGraphLegendTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphLegendTest" );
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

    public function testFactoryLegend()
    {
        $chart = ezcGraph::create( 'Pie' );

        $this->assertTrue(
            $chart->legend instanceof ezcGraphChartElementLegend
            );
    }

    public function testLegendSetBackground()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->background = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->background
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getNonPublicProperty( $chart->legend, 'background' )
        );
    }

    public function testLegendSetBorder()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->border = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->border
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $this->getNonPublicProperty( $chart->legend, 'border' )
        );
    }

    public function testLegendSetBorderWidth()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->borderWidth = 1;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            1,
            $chart->legend->borderWidth
        );

        $this->assertEquals(
            1,
            $this->getNonPublicProperty( $chart->legend, 'borderWidth' )
        );
    }

    public function testLegendSetPosition()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->legend->position = ezcGraph::LEFT;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraph::LEFT,
            $chart->legend->position
        );

        $this->assertEquals(
            ezcGraph::LEFT,
            $this->getNonPublicProperty( $chart->legend, 'position' )
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
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );
            
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
                'drawSymbol',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 1 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 15 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
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
                'drawTextBox',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 14, 1 ) ),
                    'sampleData',
                    $this->equalTo( 85 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 14, 15 ) ),
                    'moreData',
                    $this->equalTo( 85 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
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
                'drawLine',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );
            $mockedRenderer
                ->expects( $this->once() )
                ->method( 'drawBackground' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 400, 0 ) ),
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
                'drawSymbol',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401, 1 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401, 15 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 401, 29 ) ),
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
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );
            $mockedRenderer
                ->expects( $this->once() )
                ->method( 'drawBackground' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 0, 180 ) ),
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
                'drawSymbol',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 1, 181 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 101, 181 ) ),
                    $this->equalTo( 12 ),
                    $this->equalTo( 12 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 201, 181 ) ),
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

    public function testRenderLegendTextBottom()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->position = ezcGraph::TOP;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawTextBox',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 15, 1 ) ),
                    'sampleData',
                    $this->equalTo( 185 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 215, 1 ) ),
                    'moreData',
                    $this->equalTo( 185 ),
                    $this->equalTo( 12 )
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 415, 1 ) ),
                    'Even more data',
                    $this->equalTo( 185 ),
                    $this->equalTo( 12 )
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 600, 200 );
        }
        catch ( Exception $e )
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderLegendBigSymbolsPadding()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $this->addSampleData( $chart );
            $chart->legend->background = '#0000FF';
            $chart->legend->padding = 3;
            $chart->legend->symbolSize = 20;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawSymbol',
            ), array(), 'mocked_ezcGraphRenderer2D' . __FUNCTION__ );

            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 3, 3 ) ),
                    $this->equalTo( 14 ),
                    $this->equalTo( 14 ),
                    ezcGraph::DIAMOND
                );
            $mockedRenderer
                ->expects( $this->at( 1 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 3, 23 ) ),
                    $this->equalTo( 14 ),
                    $this->equalTo( 14 ),
                    ezcGraph::NO_SYMBOL
                );
            $mockedRenderer
                ->expects( $this->at( 2 ) )
                ->method( 'drawSymbol' )
                ->with(
                    $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                    $this->equalTo( new ezcGraphCoordinate( 3, 43 ) ),
                    $this->equalTo( 14 ),
                    $this->equalTo( 14 ),
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
}
?>
