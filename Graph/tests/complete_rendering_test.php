<?php
/**
 * ezcGraphCompleteRenderingTest 
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
class ezcGraphCompleteRenderingTest extends ezcImageTestCase
{

    protected $testFiles = array(
        'png'          => 'png.png',
    );

    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphCompleteRenderingTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testRenderLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'line' );
        $chart->palette = 'Black';

        $chart['Line 1'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['Line 2'] = array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613);

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            10
        );
    }

    public function testRenderLineChartReverse()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'line' );
        $chart->palette = 'Black';

        $chart['Line 1'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['Line 2'] = array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613);

        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->yAxis->position = ezcGraph::TOP;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            10
        );
    }

    public function testRenderLineChartAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $renderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawAxis',
        ) );

        $chart = ezcGraph::create( 'line' );
        $chart->palette = 'Black';
        
        $renderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100, 0, 500, 200 ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 0, 180 ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 400, 180 ), 1. ),
                $this->equalTo( $chart->xAxis ),
                $this->equalTo( $chart->xAxis->axisLabelRenderer )
            );
        $renderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100, 0, 500, 200 ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 40, 200 ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 40, 0 ), 1. ),
                $this->equalTo( $chart->yAxis ),
                $this->equalTo( $chart->yAxis->axisLabelRenderer )
            );

        $chart['Line 1'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['Line 2'] = array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613);

        $chart->renderer = $renderer;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );
    }

    public function testRenderPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'Pie' );
        $chart['sample'] = array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        );

        $chart['sample']->highlight['Safari'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            10
        );
    }
}
?>
