<?php
/**
 * ezcGraphImageMapTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
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

        $chart->render( 500, 200, $filename );
        
        $reference = $chart->renderer->getElementReferences();

        // Check data references
        $this->assertSame( 3, count( $reference['data'] ), '3 datasets expected.' );
        $this->assertSame( 5, count( $reference['data']['sampleData'] ), '5 datapoints expected.' );
        $this->assertSame( 1, count( $reference['data']['sampleData']['sample 2'] ), '1 element for datapoint expected.' );
        $this->assertSame( 'ezcGraphCircle_116', $reference['data']['sampleData']['sample 2'][0], 'ezcGraphCircle element expected.' );

        // Check legend references
        $this->assertSame( 3, count( $reference['legend'] ), '3 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['moreData'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['moreData']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['moreData']['text'], 'ezcGraphTextBox expected for legend text.' );
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
        $this->assertSame( 'ezcGraphCircleSector_40', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_61', $reference['data']['sample']['Mozilla'][1], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphCircle_6', $reference['legend']['IE']['symbol'], 'ezcGraphCircle expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_7', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
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
        $this->assertSame( 'ezcGraphCircleSector_39', $reference['data']['sample']['Mozilla'][0], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphCircleSector_40', $reference['data']['sample']['Mozilla'][1], 'ezcGraphCircleSector expected.' );
        $this->assertSame( 'ezcGraphTextBox_71', $reference['data']['sample']['Mozilla'][2], 'ezcGraphTextBox expected.' );

        // Check legend references
        $this->assertSame( 5, count( $reference['legend'] ), '5 legend items expected.' );
        $this->assertSame( 2, count( $reference['legend']['IE'] ), '2 elements for legend item expected.' );
        $this->assertSame( 'ezcGraphPolygon_5', $reference['legend']['IE']['symbol'], 'ezcGraphPolygon expected as legend symbol.' );
        $this->assertSame( 'ezcGraphTextBox_6', $reference['legend']['IE']['text'], 'ezcGraphTextBox expected for legend text.' );
    }
}

?>
