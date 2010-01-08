<?php
/**
 * ezcGraphImageMapTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphImageMapTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $renderer;

    protected $driver;

	public static function suite()
	{
	    return new PHPUnit_Framework_TestSuite( "ezcGraphImageMapTest" );
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

    public function testReturnFrom2dSvgLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        $chart->data['sampleData']->url = 'http://example.com/';

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 3, count( $reference['data'] ), '3 datasets expected.' );
        $this->assertSame( 5, count( $reference['data']['sampleData'] ), '5 datapoints expected.' );
        $this->assertSame( 1, count( $reference['data']['sampleData']['sample 2'] ), '1 element for datapoint expected.' );
        $this->assertSame( 'ezcGraphCircle_79', $reference['data']['sampleData']['sample 2'][0], 'ezcGraphCircle element expected.' );

        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['moreData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['moreData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['moreData']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 3, count( $reference['legend_url'] ), '3 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['moreData'], 'No link expected for "moreData".' );
        $this->assertSame( 'http://example.com/', $reference['legend_url']['sampleData'], 'Link expected for "sampleData".' );
    }

    public function testReturnFrom2dSvgPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 1, count( $reference['data'] ), 'One dataset expected.' );
        $this->assertSame( 5, count( $reference['data']['sample'] ), '5 datapoints expected.' );
        $this->assertSame( 2, count( $reference['data']['sample']['Mozilla'] ), '2 elements for datapoint expexted' );
        $this->assertSame( 'ezcGraphCircleSector_13', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_34', $reference['data']['sample']['Mozilla'][1], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphPolygon_5', $reference['legend']['IE']['symbol'], 'ezcGraphPolygon expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_6', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 5, count( $reference['legend_url'] ), '5 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['Mozilla'], 'No link expected for "moreData".' );
    }

    public function testReturnFrom2dGdLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = dirname( __FILE__ ) . '/data/font.ttf';
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        $chart->data['sampleData']->url = 'http://example.com/';

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 3, count( $reference['data'] ), '3 datasets expected.' );
        $this->assertSame( 5, count( $reference['data']['sampleData'] ), '5 datapoints expected.' );
        $this->assertSame( 1, count( $reference['data']['sampleData']['sample 2'] ), '1 element for datapoint expected.' );

        $this->assertSame( 36, count( $reference['data']['sampleData']['sample 2'][0] ), 'Point array with 36 elements expected.' );
        $this->assertTrue(
            $reference['data']['sampleData']['sample 2'][0][5] instanceof ezcGraphCoordinate,
            'Expected ezcGraphCoordinate objects.'
        );

        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['moreData'] ), '2 elements for legend item expected.' );

        $this->assertSame( 36, count( $reference['legend']['moreData']['symbol'] ), 'Point array with 36 elements expected.' );
        $this->assertTrue(
            $reference['legend']['moreData']['symbol'][5] instanceof ezcGraphCoordinate,
            'Expected ezcGraphCoordinate objects.'
        );
        $this->assertSame( 4, count( $reference['legend']['moreData']['text'] ), 'Point array with 36 elements expected.' );
        $this->assertTrue(
            $reference['legend']['moreData']['text'][2] instanceof ezcGraphCoordinate,
            'Expected ezcGraphCoordinate objects.'
        );
        
        // Check for legend URLs
        $this->assertSame( 3, count( $reference['legend_url'] ), '3 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['moreData'], 'No link expected for "moreData".' );
        $this->assertSame( 'http://example.com/', $reference['legend_url']['sampleData'], 'Link expected for "sampleData".' );
    }

    public function testReturnFrom3dSvgLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['evenMoreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );

        $chart->data['sampleData']->url = 'http://example.com/';

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 3, count( $reference['data'] ), '3 datasets expected.' );
        $this->assertSame( 5, count( $reference['data']['sampleData'] ), '5 datapoints expected.' );
        $this->assertSame( 1, count( $reference['data']['sampleData']['sample 2'] ), '1 element for datapoint expected.' );
        $this->assertSame( 'ezcGraphCircle_113', $reference['data']['sampleData']['sample 2'][0], 'ezcGraphCircle element expected.' );

        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['moreData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['moreData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['moreData']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 3, count( $reference['legend_url'] ), '3 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['moreData'], 'No link expected for "moreData".' );
        $this->assertSame( 'http://example.com/', $reference['legend_url']['sampleData'], 'Link expected for "sampleData".' );
    }

    public function testReturnFrom3dSvgBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();
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
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 3, count( $reference['data'] ), '3 datasets expected.' );
        $this->assertSame( 5, count( $reference['data']['sampleData'] ), '[sampleData] 5 datapoints expected.' );
        $this->assertSame( 3, count( $reference['data']['sampleData']['sample 2'] ), '[sampleData] 3 elements for datapoint expected.' );
        $this->assertSame( 'ezcGraphPolygon_98', $reference['data']['sampleData']['sample 2'][0], '[sampleData] ezcGraph element expected.' );
        $this->assertSame( 'ezcGraphPolygon_99', $reference['data']['sampleData']['sample 2'][1], '[sampleData] ezcGraph element expected.' );
        $this->assertSame( 'ezcGraphPolygon_100', $reference['data']['sampleData']['sample 2'][2], '[sampleData] ezcGraph element expected.' );

        // Check data references
        $this->assertSame( 5, count( $reference['data']['moreData'] ), '[moreData] 5 datapoints expected.' );
        $this->assertSame( 2, count( $reference['data']['moreData']['sample 2'] ), '[moreData] 3 elements for datapoint expected.' );
        $this->assertSame( 'ezcGraphCircularArc_102', $reference['data']['moreData']['sample 2'][0], '[moreData] ezcGraph element expected.' );
        $this->assertSame( 'ezcGraphCircle_103', $reference['data']['moreData']['sample 2'][1], '[moreData] ezcGraph element expected.' );

        // Check data references
        $this->assertSame( 5, count( $reference['data']['evenMoreData'] ), '[evenMoreData] 5 datapoints expected.' );
        $this->assertSame( 2, count( $reference['data']['evenMoreData']['sample 2'] ), '[evenMoreData] 3 elements for datapoint expected.' );
        $this->assertSame( 'ezcGraphCircularArc_105', $reference['data']['evenMoreData']['sample 2'][0], '[evenMoreData] ezcGraph element expected.' );
        $this->assertSame( 'ezcGraphCircle_106', $reference['data']['evenMoreData']['sample 2'][1], '[evenMoreData] ezcGraph element expected.' );

        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['sampleData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphPolygon_4', $reference['legend']['sampleData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_5', $reference['legend']['sampleData']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['moreData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['moreData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['moreData']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['evenMoreData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_8', $reference['legend']['evenMoreData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_9', $reference['legend']['evenMoreData']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 3, count( $reference['legend_url'] ), '3 legend url items expected.' );
        $this->assertSame( 'http://example.com/moreData', $reference['legend_url']['moreData'], 'Link expected for "moreData".' );
        $this->assertSame( 'http://example.com/sampleData', $reference['legend_url']['sampleData'], 'Link expected for "sampleData".' );
    }

    public function testReturnFrom3dSvgPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 1, count( $reference['data'] ), 'One dataset expected.' );
        $this->assertSame( 5, count( $reference['data']['sample'] ), '5 datapoints expected.' );
        $this->assertSame( 2, count( $reference['data']['sample']['Mozilla'] ), '2 elements for datapoint expexted' );
        $this->assertSame( 'ezcGraphCircleSector_46', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_67', $reference['data']['sample']['Mozilla'][1], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['IE']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 5, count( $reference['legend_url'] ), '5 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['Mozilla'], 'No link expected for "moreData".' );
    }

    public function testReturnFrom2dSvgPieChartWithGleam()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->renderer->options->pieChartGleam = .5;

        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->render( 500, 200, $filename );

        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 1, count( $reference['data'] ), 'One dataset expected.' );
        $this->assertSame( 5, count( $reference['data']['sample'] ), '5 datapoints expected.' );
        $this->assertSame( 4, count( $reference['data']['sample']['Mozilla'] ), '2 elements for datapoint expexted' );
        $this->assertSame( 'ezcGraphCircleSector_13', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphCircleSector_15', $reference['data']['sample']['Mozilla'][1], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphCircleSector_16', $reference['data']['sample']['Mozilla'][2], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_44', $reference['data']['sample']['Mozilla'][3], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphPolygon_5', $reference['legend']['IE']['symbol'], 'ezcGraphPolygon expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_6', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 5, count( $reference['legend_url'] ), '5 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['Mozilla'], 'No link expected for "moreData".' );
    }

    public function testReturnFrom3dSvgPieChartWithGleam()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartGleam = .5;

        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->render( 500, 200, $filename );

        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 1, count( $reference['data'] ), 'One dataset expected.' );
        $this->assertSame( 5, count( $reference['data']['sample'] ), '5 datapoints expected.' );
        $this->assertSame( 3, count( $reference['data']['sample']['Mozilla'] ), '2 elements for datapoint expexted' );
        $this->assertSame( 'ezcGraphCircleSector_45', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphCircleSector_46', $reference['data']['sample']['Mozilla'][1], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_77', $reference['data']['sample']['Mozilla'][2], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphPolygon_5', $reference['legend']['IE']['symbol'], 'ezcGraphPolygon expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_6', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
        
        // Check for legend URLs
        $this->assertSame( 5, count( $reference['legend_url'] ), '5 legend url items expected.' );
        $this->assertSame( null, $reference['legend_url']['Mozilla'], 'No link expected for "moreData".' );
    }
}

?>
