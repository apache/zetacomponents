<?php
/**
 * ezcGraphTextTest 
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphTextTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphTextTest" );
	}

    protected function setUp()
    {
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.1.3 or later." );
        }
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

    public function testRenderSubtitleOnly()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->subtitle = 'Subtitle of a chart';
        $chart->subtitle->margin = 5;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawText',
        ) );

        // Y-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 6, 6, 494, 14 ) ),
                $this->equalTo( 'Subtitle of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTitleAndSubtitle()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->title    = 'Title of a chart';
        $chart->subtitle = 'Subtitle of a chart';

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
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 1, 21, 499, 37 ) ),
                $this->equalTo( 'Subtitle of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderTitleAndBottomSubtitle()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 'foo' => 1, 'bar' => 10 ) );

        $chart->title    = 'Title of a chart';
        $chart->subtitle = 'Subtitle of a chart';
        $chart->subtitle->position = ezcGraph::BOTTOM;

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
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawText' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 1, 183, 499, 199 ) ),
                $this->equalTo( 'Subtitle of a chart' ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::MIDDLE )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }
}

?>
