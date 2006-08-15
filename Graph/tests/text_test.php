<?php
/**
 * ezcGraphTextTest 
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
class ezcGraphTextTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphTextTest" );
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

    public function testRenderTextTop()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->title = 'Title of a chart';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 1, 1, 499, 19 ) ),
                $this->equalTo( 'Title of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextBottom()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->title = 'Title of a chart';
        $chart->title->position = ezcGraph::BOTTOM;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 1, 181, 499, 199 ) ),
                $this->equalTo( 'Title of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTextTopMargin()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->title = 'Title of a chart';
        $chart->title->position = ezcGraph::TOP;
        $chart->title->margin = 5;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 6, 6, 494, 14 ) ),
                $this->equalTo( 'Title of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}

?>
