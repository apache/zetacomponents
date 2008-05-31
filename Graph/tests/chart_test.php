<?php
/**
 * ezcGraphChartTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';
require_once dirname( __FILE__ ) . '/custom_chart.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphChartTest extends ezcGraphTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

    protected $tempDir;
    protected $basePath;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphChartTest" );
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

    public function testSetTitle()
    {
        $pieChart = new ezcGraphPieChart();
        $pieChart->title = 'Test title';

        $this->assertSame(
            'Test title',
            $pieChart->title->title
        );

        $this->assertTrue(
            $pieChart->title instanceof ezcGraphChartElementText
        );
    }

    public function testSetOptionsUnknown()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->options->unknown = 'unknown';
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException' );
    }

    public function testSetRenderer()
    {
        $pieChart = new ezcGraphPieChart();
        $renderer = $pieChart->renderer = new ezcGraphRenderer2d();

        $this->assertSame(
            $renderer,
            $pieChart->renderer
        );
    }

    public function testSetInvalidRenderer()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->renderer = 'invalid';
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException' );
    }

    public function testAccessUnknownElement()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            //Read
            $pieChart->unknownElement;
        }
        catch ( ezcGraphNoSuchElementException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoSuchElementException' );
    }

    public function testSetDriver()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) && 
             ( ezcBaseFeatures::hasFunction( 'imagefttext' ) || ezcBaseFeatures::hasFunction( 'imagettftext' ) ) )
        {
            $this->markTestSkipped( 'This test needs ext/gd with native ttf support or FreeType 2 support.' );
        }

        $pieChart = new ezcGraphPieChart();
        $driver = $pieChart->driver = new ezcGraphGdDriver();

        $this->assertSame(
            $driver,
            $pieChart->driver
        );
    }

    public function testSetInvalidDriver()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->driver = 'invalid';
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDriverException' );
    }

    public function testPieChartWithoutData()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->render( 400, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoDataException.' );
    }

    public function testBarChartWithoutData()
    {
        try
        {
            $barChart = new ezcGraphBarChart();
            $barChart->render( 400, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoDataException.' );
    }

    public function testBarChartWithSingleDataPoint()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $barChart = new ezcGraphBarChart();
        $barChart->data['test'] = new ezcGraphArrayDataSet(
            array( 23 )
        );
        $barChart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBarChartWithTwoSingleDataPoint()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $barChart = new ezcGraphBarChart();
        $barChart->data['test'] = new ezcGraphArrayDataSet(
            array( 23 )
        );
        $barChart->data['test 2'] = new ezcGraphArrayDataSet(
            array( 5 )
        );
        $barChart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBarChartWithSingleDataPointNumericAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $barChart = new ezcGraphBarChart();
        $barChart->xAxis = new ezcGraphChartElementNumericAxis();

        $barChart->data['test'] = new ezcGraphArrayDataSet(
            array( 23 )
        );
        $barChart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testReRenderChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $barChart = new ezcGraphLineChart();

        $barChart->data['test'] = new ezcGraphArrayDataSet(
            array( 5, 23, 42 )
        );
        $color = $barChart->data['test']->color->default;
        $barChart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        // Render a second time with a new dataset, and expect the same result
        $barChart->data['test'] = new ezcGraphArrayDataSet(
            array( 5, 23, 42 )
        );
        $barChart->data['test']->color = $color;
        $barChart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testCustomChartClass()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcCustomTestChart();
        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
