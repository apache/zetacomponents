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
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 'foo' => 1, 'bar' => 10 );
            $chart->sample->color = '#FF0000';

            $chart->title = 'Title of a chart';

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawTextBox',
            ) );

            // Y-Axis
            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 1, 1 ) ),
                    $this->equalTo( 'Title of a chart' ),
                    $this->equalTo( 498 ),
                    $this->equalTo( 18 ),
                    $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
                );

            $chart->renderer = $mockedRenderer;

            $chart->render( 500, 200 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }
    }

    public function testRenderTextBottom()
    {
        try
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->sample = array( 'foo' => 1, 'bar' => 10 );
            $chart->sample->color = '#FF0000';

            $chart->title = 'Title of a chart';
            $chart->title->position = ezcGraph::BOTTOM;

            $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
                'drawTextBox',
            ) );

            // Y-Axis
            $mockedRenderer
                ->expects( $this->at( 0 ) )
                ->method( 'drawTextBox' )
                ->with(
                    $this->equalTo( new ezcGraphCoordinate( 1, 181 ) ),
                    $this->equalTo( 'Title of a chart' ),
                    $this->equalTo( 498 ),
                    $this->equalTo( 18 ),
                    $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
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
