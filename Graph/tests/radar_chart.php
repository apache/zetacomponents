<?php
/**
 * ezcGraphRadarChartTest 
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
class ezcGraphRadarChartTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphRadarChartTest" );
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

    public function testDrawMultipleAxis()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawAxis',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 0. ), 1. )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 400., 100. ), 1. )
            );
        $mockedRenderer
           ->expects( $this->at( 3 ) )
            ->method( 'drawAxis' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 0., 100. ), 1. )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testDrawDataLines()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawRadarDataLine',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .0525 ), .05 )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .75, .3 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .0025 ), .05 )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testDrawDataLinesWithSymbols()
    {
        $chart = new ezcGraphRadarChart();
        $chart->data['sampleData'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1 ) );
        $chart->data['sampleData']->color = '#CC0000';
        $chart->data['sampleData']->symbol = ezcGraph::DIAMOND;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawRadarDataLine',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 1' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 2' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .0, .585 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( .25, .0525 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );
        $mockedRenderer
           ->expects( $this->at( 4 ) )
            ->method( 'drawRadarDataLine' )
            ->with(
                $this->equalTo( new ezcGraphBoundings( 100., 0., 500., 200. ), 1. ),
                $this->equalTo( new ezcGraphContext( 'sampleData', 'sample 5' ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) ),
                $this->equalTo( new ezcGraphCoordinate( 200., 100. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( .75, .3 ), .05 ),
                $this->equalTo( new ezcGraphCoordinate( 1., .0025 ), .05 ),
                $this->equalTo( 0 ),
                $this->equalTo( 1 ),
                $this->equalTo( ezcGraph::DIAMOND ),
                $this->equalTo( ezcGraphColor::fromHex( '#CC0000' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testDrawGridLines()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 6 ) );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2d', array(
            'drawGridLine',
        ) );

        $mockedRenderer
           ->expects( $this->at( 0 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 338., 93.8 ), .1 ),
                $this->equalTo( new ezcGraphCoordinate( 300., 80. ), .1 ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );
        $mockedRenderer
           ->expects( $this->at( 1 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 343.75, 92.9 ), .1 ),
                $this->equalTo( new ezcGraphCoordinate( 300., 77. ), .1 ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A8588' ) )
            );

        // Next axis
        $mockedRenderer
           ->expects( $this->at( 21 ) )
            ->method( 'drawGridLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 323.5, 116.2 ), .1 ),
                $this->equalTo( new ezcGraphCoordinate( 338., 93.8 ), .1 ),
                $this->equalTo( ezcGraphColor::fromHex( '#888A85' ) )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRadarChartOptionsPropertyFillRadars()
    {
        $options = new ezcGraphRadarChartOptions();

        $this->assertSame(
            false,
            $options->fillLines,
            'Wrong default value for property fillLines in class ezcGraphRadarChartOptions'
        );

        $options->fillLines = 230;
        $this->assertSame(
            230,
            $options->fillLines,
            'Setting property value did not work for property fillLines in class ezcGraphRadarChartOptions'
        );

        $options->fillLines = false;
        $this->assertSame(
            false,
            $options->fillLines,
            'Setting property value did not work for property fillLines in class ezcGraphRadarChartOptions'
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

    public function testRadarChartOptionsPropertySymbolSize()
    {
        $options = new ezcGraphRadarChartOptions();

        $this->assertSame(
            8,
            $options->symbolSize,
            'Wrong default value for property symbolSize in class ezcGraphRadarChartOptions'
        );

        $options->symbolSize = 10;
        $this->assertSame(
            10,
            $options->symbolSize,
            'Setting property value did not work for property symbolSize in class ezcGraphRadarChartOptions'
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

    public function testRadarChartOptionsPropertyHighlightFont()
    {
        $options = new ezcGraphRadarChartOptions();

        $options->highlightFont = $file = $this->basePath . 'font.ttf';
        $this->assertSame(
            $file,
            $options->highlightFont->path,
            'Setting property value did not work for property highlightFont in class ezcGraphRadarChartOptions'
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
            'Setting property value did not work for property highlightFont in class ezcGraphRadarChartOptions'
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

    public function testRadarChartOptionsPropertyHighlightSize()
    {
        $options = new ezcGraphRadarChartOptions();

        $this->assertSame(
            14,
            $options->highlightSize,
            'Wrong default value for property highlightSize in class ezcGraphRadarChartOptions'
        );

        $options->highlightSize = 20;
        $this->assertSame(
            20,
            $options->highlightSize,
            'Setting property value did not work for property highlightSize in class ezcGraphRadarChartOptions'
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

    public function testRadarChartOptionsPropertyHighlightRadars()
    {
        $options = new ezcGraphRadarChartOptions();

        $this->assertSame(
            false,
            $options->highlightRadars,
            'Wrong default value for property highlightRadars in class ezcGraphRadarChartOptions'
        );

        $options->highlightRadars = true;
        $this->assertSame(
            true,
            $options->highlightRadars,
            'Setting property value did not work for property highlightRadars in class ezcGraphRadarChartOptions'
        );

        try
        {
            $options->highlightRadars = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadarChartElementAxis()
    {
        $chart = new ezcGraphRadarChart();

        $this->assertSame(
            true,
            $chart->axis instanceof ezcGraphChartElementNumericAxis,
            'Wrong default value for chart element axis in class ezcGraphRadarChart'
        );

        $chart->axis = new ezcGraphChartElementLogarithmicalAxis();
        $this->assertSame(
            true,
            $chart->axis instanceof ezcGraphChartElementLogarithmicalAxis,
            'Setting element value for chart element axis in class ezcGraphRadarChart'
        );

        try
        {
            $chart->axis = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadarChartElementRotationAxis()
    {
        $chart = new ezcGraphRadarChart();

        $this->assertSame(
            true,
            $chart->rotationAxis instanceof ezcGraphChartElementLabeledAxis,
            'Wrong default value for chart element axis in class ezcGraphRadarChart'
        );

        $chart->rotationAxis = new ezcGraphChartElementLogarithmicalAxis();
        $this->assertSame(
            true,
            $chart->rotationAxis instanceof ezcGraphChartElementLogarithmicalAxis,
            'Setting element value for chart element axis in class ezcGraphRadarChart'
        );

        try
        {
            $chart->rotationAxis = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadarSimple()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteTango();

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 6 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRadarSimpleNoDataFailure()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
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

    public function testRadarMinorAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->options->fillLines = 210;

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 31 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteTango();

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 6 ) );

        ob_start();
        // Suppress header already sent warning
        @$chart->renderToOutput( 500, 200 );
        file_put_contents( $filename, ob_get_clean() );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRadarNumericRotationAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->options->fillLines = 210;

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 31 ) );
        $chart->rotationAxis = new ezcGraphChartElementNumericAxis();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRadarRendererFailure()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteTango();

        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 6 ) );

        try
        {
            $chart->renderer = new ezcGraphRenderer3d();
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyValueException.' );
    }

    public function testRadarMultiple()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->options->fillLines = 210;

        $chart->data['sample 1'] = new ezcGraphArrayDataSet( $this->getRandomData( 8 ) );
        $chart->data['sample 2'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 250, 1000, 12 ) );
        $chart->data['sample 3'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 0, 500, 42 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRadarLogarithmicalAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->axis = new ezcGraphChartElementLogarithmicalAxis();

        $chart->options->fillLines = 210;

        $chart->data['sample 1'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 1, 1000000 ) );
        $chart->data['sample 2'] = new ezcGraphArrayDataSet( $this->getRandomData( 8, 1, 1000000, 42 ) );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
