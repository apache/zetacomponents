<?php
/**
 * ezcGraphRenderer2dTest 
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
class ezcGraphHorizontalBarRendererTests extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
	    return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

    public function testRenderBasicHorizontalBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphHorizontalBarChart();

        $chart->data['Set 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 151, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1  ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderHorizontalBarChartMultipleBars()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphHorizontalBarChart();

        $chart->data['Set 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 151, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1  ) );
        $chart->data['Set 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5,   'sample 5' => 124) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderHorizontalBarChartNegativeValues()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphHorizontalBarChart();

        $chart->data['Set 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -151, 'sample 3' => -324, 'sample 4' => 120, 'sample 5' =>  1  ) );
        $chart->data['Set 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' =>  234, 'sample 3' => -298, 'sample 4' => 5,   'sample 5' => -124) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
