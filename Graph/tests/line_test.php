<?php
/**
 * ezcGraphLineChartTest 
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
class ezcGraphLineChartTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphLineChartTest" );
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

    protected function addSampleData( ezcGraphChart $chart )
    {
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 112, 'sample 2' => 54, 'sample 3' => 12, 'sample 4' => -167, 'sample 5' => 329) );
        $chart->data['Even more data'] = new ezcGraphArrayDataSet( array( 'sample 1' => 300, 'sample 2' => -30, 'sample 3' => 220, 'sample 4' => 67, 'sample 5' => 450) );
    }

    public function testLineChartOptionsPropertyLineThickness()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertSame(
            1,
            $options->lineThickness,
            'Wrong default value for property lineThickness in class ezcGraphLineChartOptions'
        );

        $options->lineThickness = 4;
        $this->assertSame(
            4,
            $options->lineThickness,
            'Setting property value did not work for property lineThickness in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->lineThickness = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyFillLines()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertSame(
            false,
            $options->fillLines,
            'Wrong default value for property fillLines in class ezcGraphLineChartOptions'
        );

        $options->fillLines = 230;
        $this->assertSame(
            230,
            $options->fillLines,
            'Setting property value did not work for property fillLines in class ezcGraphLineChartOptions'
        );

        $options->fillLines = false;
        $this->assertSame(
            false,
            $options->fillLines,
            'Setting property value did not work for property fillLines in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->fillLines = true;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertySymbolSize()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertSame(
            8,
            $options->symbolSize,
            'Wrong default value for property symbolSize in class ezcGraphLineChartOptions'
        );

        $options->symbolSize = 10;
        $this->assertSame(
            10,
            $options->symbolSize,
            'Setting property value did not work for property symbolSize in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->symbolSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyHighlightFont()
    {
        $options = new ezcGraphLineChartOptions();

        $options->highlightFont = $file = $this->basePath . 'font.ttf';
        $this->assertSame(
            $file,
            $options->highlightFont->path,
            'Setting property value did not work for property highlightFont in class ezcGraphLineChartOptions'
        );

        $this->assertSame(
            true,
            $options->highlightFontCloned,
            'Font should be cloned now.'
        );

        $fontOptions = new ezcGraphFontOptions();
        $fontOptions->path = $this->basePath . 'font2.ttf';

        $options->highlightFont = $fontOptions;
        $this->assertSame(
            $fontOptions,
            $options->highlightFont,
            'Setting property value did not work for property highlightFont in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->highlightFont = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyHighlightSize()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertSame(
            14,
            $options->highlightSize,
            'Wrong default value for property highlightSize in class ezcGraphLineChartOptions'
        );

        $options->highlightSize = 20;
        $this->assertSame(
            20,
            $options->highlightSize,
            'Setting property value did not work for property highlightSize in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->highlightSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyHighlightLines()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertSame(
            false,
            $options->highlightLines,
            'Wrong default value for property highlightLines in class ezcGraphLineChartOptions'
        );

        $options->highlightLines = true;
        $this->assertSame(
            true,
            $options->highlightLines,
            'Setting property value did not work for property highlightLines in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->highlightLines = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testElementGenerationLegend()
    {
        $chart = new ezcGraphLineChart();
        $this->addSampleData( $chart );
        $chart->render( 500, 200 );
        
        $legend = $this->readAttribute( $chart->legend, 'labels' );

        $this->assertEquals(
            3,
            count( $legend ),
            'Count of legends items should be <3>'
        );

        $this->assertEquals(
            'sampleData',
            $legend[0]['label'],
            'Label of first legend item should be <sampleData>.'
        );

        $this->assertEquals(
            'Even more data',
            $legend[2]['label'],
            'Label of first legend item should be <Even more data>.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#3465A4' ),
            $legend[0]['color'],
            'Color for first label is wrong.'
        );

        $this->assertEquals(
            ezcGraphColor::fromHex( '#4E9A06' ),
            $legend[1]['color'],
            'Color for second label is wrong.'
        );
    }

    public function testInvalidDisplayType()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->displayType = ezcGraph::PIE;

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

    public function testRenderChartLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 3' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartMixedBarsAndLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->displayType = ezcGraph::BAR;

        $chart->data['sampleData2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData2']->color = '#CC0000';
        $chart->data['sampleData2']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawBar',
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData2', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
           ->expects( $this->at( 9 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData2', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartBars()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['sampleData']->displayType = ezcGraph::BAR;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawBar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .95 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 3' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .5, .2 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 80., 1. ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartStackedBars()
    {
        $chart = new ezcGraphBarChart();

        $chart->options->stackBars = true;

        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => -324, 'sample 4' => 120, 'sample 5' => -16 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['moreData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => 220, 'sample 5' => -34 ) );
        $chart->data['moreData']->color = '#0000CC';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawStackedBar',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .1, .5 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .1, .266 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( .9, .5 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .9, .516 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'moreData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000CC' ) ),
                $this->equalTo( new ezcGraphCoordinate( .1, .266 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .1, .032 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 6 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'moreData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000CC' ) ),
                $this->equalTo( new ezcGraphCoordinate( .3, .5 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .3, .521 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 7 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'moreData', 'sample 3' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000CC' ) ),
                $this->equalTo( new ezcGraphCoordinate( .5, .5 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .5, .176 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 8 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'moreData', 'sample 4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000CC' ) ),
                $this->equalTo( new ezcGraphCoordinate( .7, .38 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .7, .16 ), .05 )
            );
        $mockedRenderer
            ->expects( $this->at( 9 ) )
            ->method( 'drawStackedBar' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'moreData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#0000CC' ) ),
                $this->equalTo( new ezcGraphCoordinate( .9, .516 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .9, .55 ), .05 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartFilledLines()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => -46, 'sample 4' => 120, 'sample 5'  => 100 ) );
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 100;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .165 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .6975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .45 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .5 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::NO_SYMBOL ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A4' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#3465A464' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderChartSymbols()
    {
        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;
        $chart->data['sampleData']->symbol['sample 3'] = ezcGraph::CIRCLE;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawDataLine',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .415 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 3' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .25, .9475 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .5, .19 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::CIRCLE ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 140., 20., 460., 180. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( new ezcGraphCoordinate( .75, .7 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .9975 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#729FCF' ) ),
                $this->equalTo( null )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testLineChartOptionsPropertyXAxis()
    {
        $options = new ezcGraphLineChart();

        $this->assertSame(
            'ezcGraphChartElementLabeledAxis',
            get_class( $options->xAxis ),
            'Wrong default value for property xAxis in class ezcGraphLineChart'
        );
        $options->xAxis = $axis = new ezcGraphChartElementDateAxis();
        $this->assertSame(
            $axis,
            $options->xAxis,
            'Setting property value did not work for property xAxis in class ezcGraphLineChart'
        );

        try
        {
            $options->xAxis = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyYAxis()
    {
        $options = new ezcGraphLineChart();

        $this->assertSame(
            'ezcGraphChartElementNumericAxis',
            get_class( $options->yAxis ),
            'Wrong default value for property yAxis in class ezcGraphLineChart'
        );
        $options->yAxis = $axis = new ezcGraphChartElementDateAxis();
        $this->assertSame(
            $axis,
            $options->yAxis,
            'Setting property value did not work for property yAxis in class ezcGraphLineChart'
        );

        try
        {
            $options->yAxis = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLineChartOptionsPropertyLegend()
    {
        $chart = new ezcGraphLineChart();

        $chart->legend = false;

        try
        {
            $chart->legend = 12;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
    
    public function testLineChartNoDataFailure()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteTango();

        try
        {
            $chart->render( 500, 200, $filename );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoDataException.' );
    }

    public function testLineChartHighlightValue()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight = true;
        $chart->data['sample']->highlightValue['Opera'] = 'Opera!';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartHighlightValueOffset()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight = true;
        $chart->data['sample']->highlightValue['Opera'] = 'Opera!';

        $chart->options->highlightXOffset = 20;
        $chart->options->highlightYOffset = -10;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartHighlightFontPadding()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight = true;
        $chart->data['sample']->highlightValue['Opera'] = 'Opera!';

        $chart->options->highlightFont->background = '#EEEEEC88';
        $chart->options->highlightFont->border = '#000000';
        $chart->options->highlightFont->borderWidth = 1;
        $chart->options->highlightFont->padding = 2;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartThickLines2d()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->options->lineThickness = 4;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartThickLinesPerDataSet()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->options->lineThickness = 4;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );
        $chart->data['sample 2'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 2375,
            'IE' => 145,
            'Opera' => 804,
            'wget' => 131,
            'Safari' => 1287,
        ) );

        $chart->data['sample']->lineThickness = 2;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartThickLines3d()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->options->lineThickness = 4;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBarChartHighlightValue()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight = true;
        $chart->data['sample']->highlight['IE'] = false;
        $chart->data['sample']->highlightValue = 'foo';
        $chart->data['sample']->highlightValue['Opera'] = 'Opera!';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartNoLine()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->options->lineThickness = 0;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBarChartDataPointColors()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->color['Mozilla'] = '#204a874F';
        $chart->data['sample']->color['Opera']   = '#4e9a064F';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartUnsyncedFonts()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->renderer->options->syncAxisFonts = false;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLineChartUnsyncedFonts3d()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->syncAxisFonts = false;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testStackedBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();

        $chart->options->stackBars = true;

        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample 2'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4352,
            'IE' => 745,
            'Opera' => 204,
            'wget' => 2231,
            'Safari' => 487,
        ) );

        $chart->data['sample 3'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 234,
            'IE' => 100,
            'Opera' => 0,
            'wget' => -934,
            'Safari' => 2043,
        ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testStackedBarChart3d()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();

        $chart->options->stackBars = true;

        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample 2'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4352,
            'IE' => 745,
            'Opera' => 204,
            'wget' => 2231,
            'Safari' => 487,
        ) );

        $chart->data['sample 3'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 234,
            'IE' => 100,
            'Opera' => 0,
            'wget' => -934,
            'Safari' => 2043,
        ) );

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testStackedBarChartBug13253()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        $graph = new ezcGraphBarChart();

        $graph->data['values']  = new ezcGraphArrayDataSet( array(
            'string 1' => 55,
            'string 2' => 25,
            'string 3' => 10,
            'string 4' => 10,
            'string 5' => 5,
        ) );
        $graph->data['remains']  = new ezcGraphArrayDataSet( array(
            'string 1' => 45,
            'string 2' => 75,
            'string 3' => 90,
            'string 4' => 90,
            'string 5' => 95,
        ) );
        
        $graph->palette = new ezcGraphPaletteEzRed();
        $graph->options->stackBars = true;

        $graph->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
