<?php
/**
 * ezcGraphPieChartTest 
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
class ezcGraphPieChartTest extends ezcImageTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphPieChartTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "These tests required atleast PHP 5.1.3" );
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

    /**
     * Compares a generated image with a stored file
     * 
     * @param string $generated Filename of generated image
     * @param string $compare Filename of stored image
     * @return void
     */
    protected function compare( $generated, $compare )
    {
        $this->assertTrue(
            file_exists( $generated ),
            'No image file has been created.'
        );

        $this->assertTrue(
            file_exists( $compare ),
            'Comparision image does not exist.'
        );

        if ( md5_file( $generated ) !== md5_file( $compare ) )
        {
            // Adding a diff makes no sense here, because created XML uses
            // only two lines
            $this->fail( 'Rendered image is not correct.');
        }
    }

    public function testPieChartOptionsPropertyLabel()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            '%1$s: %2$d (%3$.1f%%)',
            $options->label,
            'Wrong default value for property label in class ezcGraphPieChartOptions'
        );

        $options->label = '%1$s';
        $this->assertSame(
            '%1$s',
            $options->label,
            'Setting property value did not work for property label in class ezcGraphPieChartOptions'
        );
    }

    public function testPieChartOptionsPropertySum()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            false,
            $options->sum,
            'Wrong default value for property sum in class ezcGraphPieChartOptions'
        );

        $options->sum = 100;
        $this->assertSame(
            100.,
            $options->sum,
            'Setting property value did not work for property sum in class ezcGraphPieChartOptions'
        );
    }

    public function testPieChartOptionsPropertyPercentTreshHold()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            0.,
            $options->percentTreshHold,
            'Wrong default value for property percentTreshHold in class ezcGraphPieChartOptions'
        );

        $options->percentTreshHold = .5;
        $this->assertSame(
            .5,
            $options->percentTreshHold,
            'Setting property value did not work for property percentTreshHold in class ezcGraphPieChartOptions'
        );
    }

    public function testPieChartOptionsPropertyAbsoluteTreshHold()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            0.,
            $options->absoluteTreshHold,
            'Wrong default value for property absoluteTreshHold in class ezcGraphPieChartOptions'
        );

        $options->absoluteTreshHold = 5;
        $this->assertSame(
            5.,
            $options->absoluteTreshHold,
            'Setting property value did not work for property absoluteTreshHold in class ezcGraphPieChartOptions'
        );
    }

    public function testPieChartOptionsPropertySummarizeCaption()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            'Misc',
            $options->summarizeCaption,
            'Wrong default value for property summarizeCaption in class ezcGraphPieChartOptions'
        );

        $options->summarizeCaption = 'Others';
        $this->assertSame(
            'Others',
            $options->summarizeCaption,
            'Setting property value did not work for property summarizeCaption in class ezcGraphPieChartOptions'
        );
    }

    public function testElementGenerationLegend()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->render( 500, 200 );
        
        $legend = $this->getAttribute( $chart->legend, 'labels' );

        $this->assertEquals(
            5,
            count( $legend ),
            'Count of legends items should be <5>'
        );

        $this->assertEquals(
            'sample 1',
            $legend[0]['label'],
            'Label of first legend item should be <sample 1>.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#CC0000' ),
            $legend[1]['color'],
            'Default color for single label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#EDD400' ),
            $legend[2]['color'],
            'Special color for single label is wrong.'
        );
    }

    public function testInvalidDisplayType()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->displayType = ezcGraph::LINE;

        try 
        {
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphInvalidDisplayTypeException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDisplayTypeException.' );
    }

    public function testPieRenderPieSegments()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['wget'] = true;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawPieSegment',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Mozilla' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#4E9A06' ) ),
                $this->equalTo( 0., 1. ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 'Mozilla: 4375 (61.3%)' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'IE' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 'IE: 345 (4.8%)' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Opera' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#EDD400' ) ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 'Opera: 1204 (16.9%)' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'wget' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#75505B' ) ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 'wget: 231 (3.2%)' ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Safari' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#F57900' ) ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 360., 1. ),
                $this->equalTo( 'Safari: 987 (13.8%)' ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 400, 200 );
    }

    public function testRenderSmallPieChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );
        $chart->data['Skien']->highlight['Norwegian'] = true;

        $chart->renderer->options->pieVerticalSize = .2;
        $chart->renderer->options->pieHorizontalSize = .2;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->data['Skien']->highlight['Norwegian'] = true;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPortraitPieChartWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->data['Skien']->highlight['Norwegian'] = true;

        $chart->render( 500, 500, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithCustomSum()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->sum = 30;
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithAbsoluteTreshHold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->absoluteTreshHold = 1;
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithPercentageTreshHold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->percentTreshHold = .05;
        $chart->options->summarizeCaption = 'Others';
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithPercentageTreshHoldAndCustomSum()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->sum = 30;
        $chart->options->percentTreshHold = .05;
        $chart->options->summarizeCaption = 'Others';
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
