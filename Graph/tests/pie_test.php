<?php
/**
 * ezcGraphPieChartTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphPieChartTest extends ezcGraphTestCase
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

    public function testPieChartOptionsPropertyLabelCallback()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            null,
            $options->labelCallback,
            'Wrong default value for property labelCallback in class ezcGraphPieChartOptions'
        );

        $options->labelCallback = 'printf';
        $this->assertSame(
            'printf',
            $options->labelCallback,
            'Setting property value did not work for property labelCallback in class ezcGraphPieChartOptions'
        );

        $options->labelCallback = array( $this, __METHOD__ );
        $this->assertSame(
            array( $this, __METHOD__ ),
            $options->labelCallback,
            'Setting property value did not work for property labelCallback in class ezcGraphPieChartOptions'
        );

        try
        {
            $options->labelCallback = 'undefined_function';
        }
        catch ( ezcBasevalueException $e )
        {
            return true;
        }

        $this->fail( 'ezcBasevalueException expected.' );
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

    public function testPieChartOptionsPropertyPercentThreshold()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            0.,
            $options->percentThreshold,
            'Wrong default value for property percentThreshold in class ezcGraphPieChartOptions'
        );

        $options->percentThreshold = .5;
        $this->assertSame(
            .5,
            $options->percentThreshold,
            'Setting property value did not work for property percentThreshold in class ezcGraphPieChartOptions'
        );
    }

    public function testPieChartOptionsPropertyAbsoluteThreshold()
    {
        $options = new ezcGraphPieChartOptions();

        $this->assertSame(
            0.,
            $options->absoluteThreshold,
            'Wrong default value for property absoluteThreshold in class ezcGraphPieChartOptions'
        );

        $options->absoluteThreshold = 5;
        $this->assertSame(
            5.,
            $options->absoluteThreshold,
            'Setting property value did not work for property absoluteThreshold in class ezcGraphPieChartOptions'
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
        
        $legend = $this->readAttribute( $chart->legend, 'labels' );

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
            ezcGraphColor::fromHex( '#4E9A06' ),
            $legend[1]['color'],
            'Default color for single label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#CC0000' ),
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
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
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
                $this->equalTo( ezcGraphColor::fromHex( '#4E9A06' ) ),
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
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
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
                $this->equalTo( ezcGraphColor::fromHex( '#EDD400' ) ),
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
                $this->equalTo( ezcGraphColor::fromHex( '#75505B' ) ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 360., 1. ),
                $this->equalTo( 'Safari: 987 (13.8%)' ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 400, 200 );
    }

    public function testPieRenderPieSegmentsWithLabelCallback()
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

        $chart->options->labelCallback = 
            create_function( 
                '$label, $value, $percent', 
                "return 'Callback: ' . \$label;"
            );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawPieSegment',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Mozilla' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( 0., 1. ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 'Callback: Mozilla' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'IE' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#4E9A06' ) ),
                $this->equalTo( 220.5, .1 ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 'Callback: IE' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Opera' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( 238., 1. ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 'Callback: Opera' ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'wget' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#EDD400' ) ),
                $this->equalTo( 298.6, 1. ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 'Callback: wget' ),
                $this->equalTo( true )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawPieSegment' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 80, 0, 400, 200 ) ),
                $this->equalTo( new ezcGraphContext( 'sample', 'Safari' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#75505B' ) ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 360., 1. ),
                $this->equalTo( 'Callback: Safari' ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 400, 200 );
    }

    public function testInvalidValues()
    {
        try
        {
            $chart = new ezcGraphPieChart();
            $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 3, -1, 2 ) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphInvalidDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDataException.' );
    }

    public function testInvalidValueSum()
    {
        try
        {
            $chart = new ezcGraphPieChart();
            $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 0, 0 ) );
            $chart->render( 500, 200 );
        }
        catch ( ezcGraphInvalidDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDataException.' );
    }

    public function testEmptyDataSet()
    {
        try
        {
            $chart = new ezcGraphPieChart();
            $chart->data['Skien'] = new ezcGraphArrayDataSet( array() );
            $chart->render( 500, 200 );
        } 
        catch ( ezcGraphInvalidDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDataException.' );
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

    public function testRenderSmallPieChartToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        ob_start();
        // Suppress header already sent warning
        @$chart->renderToOutput( 500, 200 );
        file_put_contents( $filename, ob_get_clean() );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithZeroValues()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 0, 'Brazilian' => 1, 'Venezuelan' => 0, 'Japanese' => 1, 'Czech' => 0, 'Hungarian' => 1, 'Romanian' => 1 ) );
        $chart->data['Skien']->highlight['Norwegian'] = true;

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

        try
        {
            $chart->options->sum = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderPieChartWithAbsoluteThreshold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->absoluteThreshold = 1;
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        try
        {
            $chart->options->absoluteThreshold = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderPieChartWithPercentageThreshold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->percentThreshold = .05;
        $chart->options->summarizeCaption = 'Others';
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        try
        {
            $chart->options->percentThreshold = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderPieChartWithLowAbsoluteThreshold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->absoluteThreshold = 1;
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        try
        {
            $chart->options->absoluteThreshold = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderPieChartWithLowPercentageThreshold()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->percentThreshold = .06;
        $chart->options->summarizeCaption = 'Others';
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );

        try
        {
            $chart->options->percentThreshold = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderPieChartWithPercentageThresholdAndCustomSum()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->options->sum = 30;
        $chart->options->percentThreshold = .05;
        $chart->options->summarizeCaption = 'Others';
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithOneDataPoint()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10 ) );

        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dPieChartWithOneDataPoint()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10 ) );

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = false;
        $chart->render( 500, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
