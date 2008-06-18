<?php
/**
 * ezcGraphRenderer3dTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphRenderer3dTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphRenderer3dTest" );
	}

    protected function setUp()
    {
        static $i = 0;

        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "This test requires PHP 5.1.3 or later." );
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

    public function testRenderBackgroundImage()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 125., 43.5 ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg'
        );
    }

    public function testRenderTopLeftBackgroundImage()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::TOP | ezcGraph::LEFT
        );
    }

    public function testRenderBottomRightBackgroundImage()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT
        );
    }

    public function testRenderToBigBackgroundImage()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 100., 1. ),
                $this->equalTo( 100., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 100, 100 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT
        );
    }

    public function testRenderBackgroundImageRepeatX()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 150., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $driver
            ->expects( $this->at( 2 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 300., 87. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::HORIZONTAL
        );
    }

    public function testRenderBackgroundImageRepeatY()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 250., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::VERTICAL
        );
    }

    public function testRenderBackgroundImageRepeatBoth()
    {
        $driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawImage',
        ) );

        $driver->options->width = 400;
        $driver->options->height = 200;

        $driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 0., 0. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $driver
            ->expects( $this->at( 3 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 150., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );
        $driver
            ->expects( $this->at( 5 ) )
            ->method( 'drawImage' )
            ->with(
                $this->equalTo( dirname( __FILE__ ) . '/data/jpeg.jpg' ),
                $this->equalTo( new ezcGraphCoordinate( 300., 113. ), 1. ),
                $this->equalTo( 150., 1. ),
                $this->equalTo( 113., 1. )
            );

        $renderer = new ezcGraphRenderer3d();
        $renderer->setDriver( $driver );
        $renderer->drawBackgroundImage(
            new ezcGraphBoundings( 0, 0, 400, 200 ),
            dirname( __FILE__ ) . '/data/jpeg.jpg',
            ezcGraph::BOTTOM | ezcGraph::RIGHT,
            ezcGraph::VERTICAL | ezcGraph::HORIZONTAL
        );
    }

    public function testRenderLineChartToOutput()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->renderer = new ezcGraphRenderer3d();

        ob_start();
        // Suppress header already sent warning
        @$chart->renderToOutput( 500, 200 );
        file_put_contents( $filename, ob_get_clean() );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegment()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithGleamAndShadow()
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

        $chart->data['sample']->highlight['Safari'] = true;
        $chart->data['sample']->color['Safari'] = '#000000';
        $chart->data['sample']->highlight['IE'] = true;

        $chart->data['sample']->symbol['IE'] = ezcGraph::CIRCLE;
        $chart->data['sample']->symbol['Opera'] = ezcGraph::BULLET;
        $chart->data['sample']->symbol['wget'] = ezcGraph::DIAMOND;

        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->pieChartShadowSize = 10;
        $chart->renderer->options->pieChartGleam = .5;
        $chart->renderer->options->dataBorder = false;
        $chart->renderer->options->pieChartHeight = 16;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->renderer->options->pieChartOffset = 180;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieChartBlue()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->pieChartShadowSize = 10;
        $chart->renderer->options->pieChartGleam = .5;
        $chart->renderer->options->pieChartGleamBorder = 3;
        $chart->renderer->options->dataBorder = false;
        $chart->renderer->options->pieChartHeight = 16;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
    
    public function testRenderFullShadow()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $graph = new ezcGraphPieChart();

        // Configure Graph
        $graph->legend->position = ezcGraph::BOTTOM;

        // Add data
        $graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
            'Available' => 72,
            'Used' => 28,
        ) );

        $graph->options->label = '%1$s (%3$.1f%%)';

        // Configure renderer options
        $graph->renderer = new ezcGraphRenderer3d();
        $graph->renderer->options->pieChartShadowSize = 10;
        $graph->renderer->options->pieChartGleam = .5;
        $graph->renderer->options->dataBorder = false;
        $graph->renderer->options->pieChartHeight = 16;
        $graph->renderer->options->legendSymbolGleam = .5;

        // Render image
        $graph->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieChartEz()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->palette = new ezcGraphPaletteEz();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->pieChartShadowSize = 10;
        $chart->renderer->options->pieChartGleam = .5;
        $chart->renderer->options->dataBorder = false;
        $chart->renderer->options->pieChartHeight = 16;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithGleamAndShadowGD()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) && 
             ( ezcBaseFeatures::hasFunction( 'imagefttext' ) || ezcBaseFeatures::hasFunction( 'imagettftext' ) ) )
        {
            $this->markTestSkipped( 'This test needs ext/gd with native ttf support or FreeType 2 support.' );
        }

        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );
        $chart->options->font->path = dirname( __FILE__ ) . '/data/font.ttf';

        $chart->data['sample']->highlight['Safari'] = true;
        $chart->data['sample']->color['Safari'] = '#000000';
        $chart->data['sample']->highlight['IE'] = true;

        $chart->data['sample']->symbol['IE'] = ezcGraph::CIRCLE;
        $chart->data['sample']->symbol['Opera'] = ezcGraph::BULLET;
        $chart->data['sample']->symbol['wget'] = ezcGraph::DIAMOND;

        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->pieChartShadowSize = 10;
        $chart->renderer->options->pieChartGleam = .5;
        $chart->renderer->options->dataBorder = false;
        $chart->renderer->options->pieChartHeight = 16;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->renderer->options->pieChartOffset = 180;

        $chart->driver = new ezcGraphGdDriver();
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithTitle()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->title = 'Pie chart title';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithModifiedSymbolColor()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartSymbolColor = '#000000BB';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentPolygonOrder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            'label 1' => 20,
            'label 2' => 20,
            'label 3' => 20,
            'label 4' => 20,
            'label 5' => 20,
            'label 6' => 20,
            'label 7' => 20,
            'label 8' => 20,
            'label 9' => 20,
            'label 10' => 20,
        ) );

        $chart->data['sample']->highlight = true;
        $chart->options->label = '%1$s';
        $chart->legend = false;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->moveOut = .3;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithoutSymbols()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->showSymbol = false;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithIncreasedMoveOut()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->moveOut = .2;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithoutDataBorder()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = 0;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithCustomHeight()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartHeight = 5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLabeledPieSegmentWithCustomRotation()
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

        $chart->data['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartRotation = .3;

        $chart->driver = new ezcGraphSvgDriver();
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

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 0']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 1']->symbol = ezcGraph::NO_SYMBOL;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPimpedBarChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Rectangle'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => -43, 'sample 3' => 65 ) );
        $chart->data['Rectangle']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Circle'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324 ) );
        $chart->data['Circle']->symbol = ezcGraph::CIRCLE;
        $chart->data['Bullet'] = new ezcGraphArrayDataSet( array( 'sample 1' => 124, 'sample 2' => -245, 'sample 3' => 361 ) );
        $chart->data['Bullet']->symbol = ezcGraph::BULLET;
        $chart->data['Diamond'] = new ezcGraphArrayDataSet( array( 'sample 1' => 387, 'sample 2' => -213, 'sample 3' => 24 ) );
        $chart->data['Diamond']->symbol = ezcGraph::DIAMOND;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->renderer->options->barChartGleam = .5;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->render( 700, 300, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartSymbols()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Rectangle'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Rectangle']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Circle'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Circle']->symbol = ezcGraph::CIRCLE;
        $chart->data['Bullet'] = new ezcGraphArrayDataSet( array( 'sample 1' => 124, 'sample 2' => 245, 'sample 3' => 361, 'sample 4' => 412, 'sample 5' => 480) );
        $chart->data['Bullet']->symbol = ezcGraph::BULLET;
        $chart->data['Diamond'] = new ezcGraphArrayDataSet( array( 'sample 1' => 387, 'sample 2' => 261, 'sample 3' => 24, 'sample 4' => 59, 'sample 5' => 112) );
        $chart->data['Diamond']->symbol = ezcGraph::DIAMOND;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 700, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderNegativeBarChartSymbols()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Rectangle'] = new ezcGraphArrayDataSet( array( 'sample -1' => -432, 'sample -2' => -43, 'sample -3' => -65, 'sample -4' => -97, 'sample -5' => -154) );
        $chart->data['Rectangle']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Circle'] = new ezcGraphArrayDataSet( array( 'sample -1' => -234, 'sample -2' => -21, 'sample -3' => -324, 'sample -4' => -120, 'sample -5' => -1) );
        $chart->data['Circle']->symbol = ezcGraph::CIRCLE;
        $chart->data['Bullet'] = new ezcGraphArrayDataSet( array( 'sample -1' => -124, 'sample -2' => -245, 'sample -3' => -361, 'sample -4' => -412, 'sample -5' => -480) );
        $chart->data['Bullet']->symbol = ezcGraph::BULLET;
        $chart->data['Diamond'] = new ezcGraphArrayDataSet( array( 'sample -1' => -387, 'sample -2' => -261, 'sample -3' => -24, 'sample -4' => -59, 'sample -5' => -112) );
        $chart->data['Diamond']->symbol = ezcGraph::DIAMOND;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 700, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithSmallDepth()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 0']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 1']->symbol = ezcGraph::NO_SYMBOL;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->depth = .01;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithSmallDepth()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 0']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 1']->symbol = ezcGraph::NO_SYMBOL;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->depth = .01;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithDepth()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 0']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 1']->symbol = ezcGraph::NO_SYMBOL;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->depth = .5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithDepth()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 0'] = new ezcGraphArrayDataSet( array( 'sample 1' => 432, 'sample 2' => 43, 'sample 3' => 65, 'sample 4' => 97, 'sample 5' => 154) );
        $chart->data['Line 0']->symbol = ezcGraph::NO_SYMBOL;
        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 1']->symbol = ezcGraph::NO_SYMBOL;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->depth = .5;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dLineChartSmallMaxFontSize()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->title->font->maxFontSize = 8;
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dLineChartBigMaxFontSize()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';
        $chart->title->maxHeight = .2;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->title->font->maxFontSize = 32;
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dFilledLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithMoreBarsThenMajorSteps()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->legend = false;

        $chart->xAxis = new ezcGraphChartElementNumericAxis();
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->data['dataset'] = new ezcGraphArrayDataSet( array( 12, 43, 324, 12, 43, 125, 120, 123 , 543,  12, 45, 76, 87 , 99, 834, 34, 453 ) );
        $chart->data['dataset']->color = '#3465A47F';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderBarChartWithUnregularStepSizes()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphBarChart();
        $chart->legend = false;

        $chart->data['dataset'] = new ezcGraphArrayDataSet( array( 12, 43, 324, 12, 43, 125, 120, 123 , 543,  12, 45, 76, 87 , 99 ) );
        $chart->data['dataset']->color = '#3465A47F';

        $chart->renderer = new ezcGraphRenderer3d();

        try
        {
            $chart->render( 500, 200, $filename );
        }
        catch ( ezcGraphUnregularStepsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnregularStepsException.' );
    }

    public function testRender3dFilledLineChartWithAxisIntersection()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -151, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => -5, 'sample 5' => -124) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dFilledLineChartWithoutDataBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = 0;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dFilledLineChartNonFilledGrid()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->fillGrid = 1;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRender3dFilledLineChartNonFilledAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->fillAxis = 1;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithDifferentAxisSpace()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );
        
        $chart->xAxis->axisSpace = .2;
        $chart->yAxis->axisSpace = .05;
        
        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithAxisLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->label = 'Samples';
        $chart->yAxis->label = 'Numbers';

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithAxisLabelsReversedAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->xAxis->label = 'Samples';
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->yAxis->label = 'Numbers';
        $chart->yAxis->position = ezcGraph::TOP;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithOffset()
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

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartOffset = 156;
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderLineChartWithHighlightedData()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart->data['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -21, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart->data['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->data['Line 1']->highlight = true;
        $chart->data['Line 2']->highlight['sample 5'] = true;

        $chart->options->highlightSize = 12;
        $chart->options->highlightFont->color = ezcGraphColor::fromHex( '#3465A4' );
        $chart->options->highlightFont->background = ezcGraphColor::fromHex( '#D3D7CF' );
        $chart->options->highlightFont->border = ezcGraphColor::fromHex( '#888A85' );
        
        $chart->xAxis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->barChartGleam = .5;
        $chart->renderer->options->legendSymbolGleam = .5;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testNoArrowHead()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->renderer = new ezcGraphRenderer3d();
        $graph->renderer->options->axisEndStyle = ezcGraph::NO_SYMBOL;
        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testCircleArrowHead()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';
        
        $graph = new ezcGraphLineChart();
        $graph->palette = new ezcGraphPaletteBlack();
        $graph->legend->position = ezcGraph::BOTTOM;

        $graph->data['sample'] = new ezcGraphArrayDataSet(
            array( 1, 4, 6, 8, 2 )
        );

        $graph->renderer = new ezcGraphRenderer3d();
        $graph->renderer->options->axisEndStyle = ezcGraph::CIRCLE;
        $graph->render( 560, 250, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderer3dOptionsPropertySeperateLines()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            true,
            $options->seperateLines,
            'Wrong default value for property seperateLines in class ezcGraphRenderer3dOptions'
        );

        $options->seperateLines = false;
        $this->assertSame(
            false,
            $options->seperateLines,
            'Setting property value did not work for property seperateLines in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->seperateLines = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyFillAxis()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            .8,
            $options->fillAxis,
            'Wrong default value for property fillAxis in class ezcGraphRenderer3dOptions'
        );

        $options->fillAxis = .2;
        $this->assertSame(
            .2,
            $options->fillAxis,
            'Setting property value did not work for property fillAxis in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->fillAxis = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyFillGrid()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            0,
            $options->fillGrid,
            'Wrong default value for property fillGrid in class ezcGraphRenderer3dOptions'
        );

        $options->fillGrid = .5;
        $this->assertSame(
            .5,
            $options->fillGrid,
            'Setting property value did not work for property fillGrid in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->fillGrid = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyDepth()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            .1,
            $options->depth,
            'Wrong default value for property depth in class ezcGraphRenderer3dOptions'
        );

        $options->depth = .05;
        $this->assertSame(
            .05,
            $options->depth,
            'Setting property value did not work for property depth in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->depth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyPieChartHeight()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            10.,
            $options->pieChartHeight,
            'Wrong default value for property pieChartHeight in class ezcGraphRenderer3dOptions'
        );

        $options->pieChartHeight = 20;
        $this->assertSame(
            20.,
            $options->pieChartHeight,
            'Setting property value did not work for property pieChartHeight in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->pieChartHeight = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyPieChartRotation()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            0.6,
            $options->pieChartRotation,
            'Wrong default value for property pieChartRotation in class ezcGraphRenderer3dOptions'
        );

        $options->pieChartRotation = .4;
        $this->assertSame(
            .4,
            $options->pieChartRotation,
            'Setting property value did not work for property pieChartRotation in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->pieChartRotation = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyPieChartShadowSize()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            0,
            $options->pieChartShadowSize,
            'Wrong default value for property pieChartShadowSize in class ezcGraphRenderer3dOptions'
        );

        $options->pieChartShadowSize = 5;
        $this->assertSame(
            5.,
            $options->pieChartShadowSize,
            'Setting property value did not work for property pieChartShadowSize in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->pieChartShadowSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyPieChartShadowTransparency()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            .3,
            $options->pieChartShadowTransparency,
            'Wrong default value for property pieChartShadowTransparency in class ezcGraphRenderer3dOptions'
        );

        $options->pieChartShadowTransparency = .5;
        $this->assertSame(
            .5,
            $options->pieChartShadowTransparency,
            'Setting property value did not work for property pieChartShadowTransparency in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->pieChartShadowTransparency = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyPieChartShadowColor()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertEquals(
            ezcGraphColor::fromHex( '#000000' ),
            $options->pieChartShadowColor,
            'Wrong default value for property pieChartShadowColor in class ezcGraphRenderer3dOptions'
        );

        $options->pieChartShadowColor = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->pieChartShadowColor,
            'Setting property value did not work for property pieChartShadowColor in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->pieChartShadowColor = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testRenderer3dOptionsPropertyBarDarkenSide()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            .2,
            $options->barDarkenSide,
            'Wrong default value for property barDarkenSide in class ezcGraphRenderer3dOptions'
        );

        $options->barDarkenSide = .4;
        $this->assertSame(
            .4,
            $options->barDarkenSide,
            'Setting property value did not work for property barDarkenSide in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->barDarkenSide = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyBarDarkenTop()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            .4,
            $options->barDarkenTop,
            'Wrong default value for property barDarkenTop in class ezcGraphRenderer3dOptions'
        );

        $options->barDarkenTop = .8;
        $this->assertSame(
            .8,
            $options->barDarkenTop,
            'Setting property value did not work for property barDarkenTop in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->barDarkenTop = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dOptionsPropertyBarChartGleam()
    {
        $options = new ezcGraphRenderer3dOptions();

        $this->assertSame(
            false,
            $options->barChartGleam,
            'Wrong default value for property barChartGleam in class ezcGraphRenderer3dOptions'
        );

        $options->barChartGleam = .3;
        $this->assertSame(
            .3,
            $options->barChartGleam,
            'Setting property value did not work for property barChartGleam in class ezcGraphRenderer3dOptions'
        );

        try
        {
            $options->barChartGleam = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRenderer3dPieChartMissingLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphPieChart();
        $chart->data['TestCase'] = new ezcGraphArrayDataSet( array( 'Big' => 2.9, 'Small 1' => 0.03, 'Small 2' => 0.04, 'Small 3' => 0.03, 'Last' => 1 ) );

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = false;
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>
