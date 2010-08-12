<?php
/**
 * ezcGraphToolsTest 
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
class ezcGraphToolsTest extends ezcGraphTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphToolsTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
        $this->setLocale( LC_NUMERIC, 'en_US', 'en_US.UTF-8', 'en_US.UTF8', 'en', 'english', 'en_US@euro' );
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testPieChartImageMap()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        $htmlFilename = $this->tempDir . __FUNCTION__ . '.html';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->url = 'http://example.org/browsers';
        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';
        $chart->data['sample']->highlight['Opera'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        $chart->render( 500, 200, $filename );

        file_put_contents( $htmlFilename, ezcGraphTools::createImageMap( $chart ) );

        $this->compare(
            $htmlFilename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.html'
        );
    }

    public function testPieChartImageMapCustomName()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        $htmlFilename = $this->tempDir . __FUNCTION__ . '.html';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->url = 'http://example.org/browsers';
        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';
        $chart->data['sample']->highlight['Opera'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        $chart->render( 500, 200, $filename );

        file_put_contents( $htmlFilename, ezcGraphTools::createImageMap( $chart, 'CustomImageMapName' ) );

        $this->compare(
            $htmlFilename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.html'
        );
    }

    public function testLineChartImageMap()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        $htmlFilename = $this->tempDir . __FUNCTION__ . '.html';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 1']->url = 'http://example.org/line_1';
        $chart->data['Line 2']->url['sample 3'] = 'http://example.org/line_2/sample_3';

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        $chart->render( 500, 200, $filename );

        file_put_contents( $htmlFilename, ezcGraphTools::createImageMap( $chart ) );

        $this->compare(
            $htmlFilename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.html'
        );
    }

    public function testLineChartImageMapOnlyDataPoint()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        $htmlFilename = $this->tempDir . __FUNCTION__ . '.html';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 2']->url['sample 3'] = 'http://example.org/line_2/sample_3';

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        $chart->render( 500, 200, $filename );

        file_put_contents( $htmlFilename, ezcGraphTools::createImageMap( $chart ) );

        $this->compare(
            $htmlFilename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.html'
        );
    }

    public function testLineChartImageMapNoLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';
        $htmlFilename = $this->tempDir . __FUNCTION__ . '.html';

        $chart = new ezcGraphLineChart();
        $chart->legend = false;
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 2']->url['sample 3'] = 'http://example.org/line_2/sample_3';

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        $chart->render( 500, 200, $filename );

        file_put_contents( $htmlFilename, ezcGraphTools::createImageMap( $chart ) );

        $this->compare(
            $htmlFilename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.html'
        );
    }

    public function testImageMapWithWrongDriver()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->render( 500, 200, $filename );

        try
        {
            ezcGraphTools::createImageMap( $chart );
        }
        catch ( ezcGraphToolsIncompatibleDriverException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphToolsIncompatibleDriverException.' );
    }

    public function testImageMapWithoutRendering()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->driver = new ezcGraphGdDriver();

        try
        {
            ezcGraphTools::createImageMap( $chart );
        }
        catch ( ezcGraphToolsNotRenderedException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphToolsNotRenderedException.' );
    }

    public function testPieChartSvgLinking()
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

        $chart->data['sample']->url = 'http://example.org/browsers';
        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';
        $chart->data['sample']->highlight['Opera'] = true;

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testPieChartSvgLinkingOnlyDataPoint()
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

        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testPieChartSvgLinkingNoLegend()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';
        $chart->data['sample']->highlight['Opera'] = true;

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testPieChartSvgLinkingCustomCursor()
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

        $chart->data['sample']->url = 'http://example.org/browsers';
        $chart->data['sample']->url['Mozilla'] = 'http://example.org/browsers/mozilla';
        $chart->data['sample']->highlight['Opera'] = true;

        $chart->driver->options->linkCursor = 'crosshair';

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartSvgLinking()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 1']->url = 'http://example.org/line_1';
        $chart->data['Line 2']->url['sample 3'] = 'http://example.org/line_2/sample_3';

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function test3dBarChartSvgLinking()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        $chart->data['sampleData']->url = 'http://example.com/sampleData';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['moreData']->url = 'http://example.com/moreData';
        $chart->data['moreData']->symbol = ezcGraph::CIRCLE;
        $chart->data['evenMoreData']->url = 'http://example.com/evenMoreData';
        $chart->data['evenMoreData']->symbol = ezcGraph::BULLET;

        $chart->render( 500, 200, $filename );

        ezcGraphTools::linkSvgElements( $chart );

        $this->compare( 
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testSvgLinkingWithWrongDriver()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->render( 500, 200, $filename );

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';

        try
        {
            ezcGraphTools::linkSvgElements( $chart );
        }
        catch ( ezcGraphToolsIncompatibleDriverException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphToolsIncompatibleDriverException.' );
    }

    public function testSvgLinkingWithoutRendering()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        try
        {
            ezcGraphTools::linkSvgElements( $chart );
        }
        catch ( ezcGraphToolsNotRenderedException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphToolsNotRenderedException.' );
    }
}

?>
