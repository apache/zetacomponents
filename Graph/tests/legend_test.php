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
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['sampleData']->color = '#0000FF';
        $chart['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart['moreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['moreData']->color = '#FF0000';
        $chart['evenMoreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['evenMoreData']->color = '#FF0000';
        $chart['evenMoreData']->label = 'Even more data';
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
        $chart = ezcGraph::create( 'Pie' );
        $chart->legend->background = '#FF0000';

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
        $chart = ezcGraph::create( 'Pie' );
        $chart->legend->border = '#FF0000';

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
        $chart = ezcGraph::create( 'Pie' );
        $chart->legend->borderWidth = 1;

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
        $chart = ezcGraph::create( 'Pie' );
        $chart->legend->position = ezcGraph::LEFT;

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
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackground',
        ) );
        
        $mockedRenderer
            ->expects( $this->at( 1 ) )
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

    public function testRenderLegendSymbols()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawSymbol',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( new ezcGraphCoordinate( 2, 2 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::DIAMOND
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 2, 18 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 2, 34 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLegendText()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 17, 2 ) ),
                'sampleData',
                $this->equalTo( 81 ),
                $this->equalTo( 12 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::MIDDLE )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 17, 18 ) ),
                'moreData',
                $this->equalTo( 81 ),
                $this->equalTo( 12 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::MIDDLE )

            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 17, 34 ) ),
                'Even more data',
                $this->equalTo( 81 ),
                $this->equalTo( 12 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::MIDDLE )

            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLegendBackgroundRight()
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
        ) );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
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

    public function testRenderLegendSymbolsRight()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';
        $chart->legend->position = ezcGraph::RIGHT;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawSymbol',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( new ezcGraphCoordinate( 402, 2 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::DIAMOND
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 402, 18 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 402, 34 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLegendBackgroundBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';
        $chart->legend->position = ezcGraph::BOTTOM;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackground',
        ) );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
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

    public function testRenderLegendSymbolsBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';
        $chart->legend->position = ezcGraph::BOTTOM;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawSymbol',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( new ezcGraphCoordinate( 2, 182 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::DIAMOND
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 101, 182 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200, 182 ) ),
                $this->equalTo( 12 ),
                $this->equalTo( 12 ),
                ezcGraph::NO_SYMBOL
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 300, 200 );
    }

    public function testRenderLegendTextBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';
        $chart->legend->position = ezcGraph::TOP;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 18, 2 ) ),
                'sampleData',
                $this->equalTo( 182 ),
                $this->equalTo( 12 )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 217, 2 ) ),
                'moreData',
                $this->equalTo( 182 ),
                $this->equalTo( 12 )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 416, 2 ) ),
                'Even more data',
                $this->equalTo( 182 ),
                $this->equalTo( 12 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 600, 200 );
    }

    public function testRenderLegendBigSymbolsPadding()
    {
        $chart = ezcGraph::create( 'Line' );
        $this->addSampleData( $chart );
        $chart->legend->background = '#0000FF';
        $chart->legend->padding = 3;
        $chart->legend->symbolSize = 20;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawSymbol',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#0000FF' ) ),
                $this->equalTo( new ezcGraphCoordinate( 6, 6 ) ),
                $this->equalTo( 14 ),
                $this->equalTo( 14 ),
                ezcGraph::DIAMOND
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 6, 28 ) ),
                $this->equalTo( 14 ),
                $this->equalTo( 14 ),
                ezcGraph::NO_SYMBOL
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawSymbol' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#FF0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 6, 50 ) ),
                $this->equalTo( 14 ),
                $this->equalTo( 14 ),
                ezcGraph::NO_SYMBOL
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}
?>
