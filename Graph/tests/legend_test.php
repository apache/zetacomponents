<?php
/**
 * ezcGraphLegendTest 
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

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphLegendTest extends ezcGraphTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphLegendTest" );
	}

    protected function setUp()
    {
        static $i = 0;

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

    protected function addSampleData( ezcGraphChart $chart )
    {
        $chart->data['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->data['sampleData']->color = '#0000FF';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->data['moreData']->color = '#FF0000';
        $chart->data['evenMoreData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->data['evenMoreData']->color = '#FF0000';
        $chart->data['evenMoreData']->label = 'Even more data';
    }

    public function testFactoryLegend()
    {
        $chart = new ezcGraphPieChart();

        $this->assertTrue(
            $chart->legend instanceof ezcGraphChartElementLegend
            );
    }

    public function testLegendSetBackground()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->background = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->background
        );
    }

    public function testLegendSetBorder()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->border = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->legend->border
        );
    }

    public function testLegendSetBorderWidth()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->borderWidth = 1;

        $this->assertEquals(
            1,
            $chart->legend->borderWidth
        );
    }

    public function testLegendSetPosition()
    {
        $chart = new ezcGraphPieChart();
        $chart->legend->position = ezcGraph::LEFT;

        $this->assertEquals(
            ezcGraph::LEFT,
            $chart->legend->position
        );
    }

    public function testLeftLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->legend->position = ezcGraph::LEFT;
        $chart->legend->padding = 2;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRightLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->legend->position = ezcGraph::RIGHT;
        $chart->legend->padding = 2;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testTopLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->legend->position = ezcGraph::TOP;
        $chart->legend->padding = 2;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBottomLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->legend->position = ezcGraph::BOTTOM;
        $chart->legend->padding = 2;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
