<?php
/**
 * ezcGraphAxisRotatedRendererTest 
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
class ezcGraphAxisRotatedBoxedRendererTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        static $i = 0;

        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.1.3 or later." );
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

    public function testRenderCompleteBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 100, 'sample 2' => 0, 'sample 3' => 500, 'sample 4' => 250, 'sample 5' => 500) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderCompleteBarChartReverseRotated()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisSpace = .25;
        $chart->xAxis->axisLabelRenderer->angle = -45;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer->angle = -45;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 30;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 31;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabelsVertical()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 0;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderRotatedAxisWithLotsOfLabelsLargeAngle()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 10;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 11;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 75;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dRotatedAxisWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 30;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 31;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testOptimalAngleCalculation()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        $this->assertEquals(
            $chart->xAxis->axisLabelRenderer->angle,
            76.,
            'Angle estimation wrong.',
            1.
        );

        $this->assertEquals(
            $chart->yAxis->axisLabelRenderer->angle,
            53.,
            'Angle estimation wrong.',
            1.
        );
    }

    public function testRenderWithModifiedAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->xAxis->axisSpace = 0.1;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0.05;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderWithZeroAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $labelCount = 20;
        $data = $this->getRandomData( $labelCount, 500, 2000, 23 );

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $data );

        // Set manual label count
        $chart->xAxis->labelCount = 21;

        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedBoxedLabelRenderer();
        $chart->xAxis->axisLabelRenderer->angle = 45;
        $chart->xAxis->axisSpace = 0.1;

        $chart->yAxis->axisLabelRenderer = new ezcGraphAxisNoLabelRenderer();
        $chart->yAxis->axisSpace = 0;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
