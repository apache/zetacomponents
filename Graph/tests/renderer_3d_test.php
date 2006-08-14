<?php
/**
 * ezcGraphRenderer3dTest 
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
class ezcGraphRenderer3dTest extends ezcImageTestCase
{

    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphRenderer3dTest" );
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

    public function testRenderBackgroundImage()
    {
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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
        $driver = $this->getMock( 'ezcGraphGdDriver', array(
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

    public function testRenderLabeledPieSegment()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
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
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->title = 'Pie chart title';

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentPolygonOrder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
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

        $chart['sample']->highlight = true;
        $chart->options->label = '%1$s';
        $chart->legend = false;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->moveOut = .3;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithoutSymbols()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->showSymbol = false;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithIncreasedMoveOut()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->moveOut = .2;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithoutDataBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = 0;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithCustomHeight()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartHeight = 5;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderLabeledPieSegmentWithCustomRotation()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart['sample']->highlight['Safari'] = true;

        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->pieChartRotation = .3;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderPieChartWithLotsOfLabels()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart['Skien']->highlight['Norwegian'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dLineChartSmallMaxFontSize()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->title->font->maxFontSize = 8;
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dLineChartBigMaxFontSize()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->title = 'Line chart title';
        $chart->title->maxHeight = .2;

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->title->font->maxFontSize = 32;
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dFilledLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dFilledLineChartWithAxisIntersection()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();
        $chart->options->fillLines = 200;

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => -151, 'sample 3' => 324, 'sample 4' => -120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => -5, 'sample 5' => -124) );

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dFilledLineChartWithoutDataBorder()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->dataBorder = 0;

        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dFilledLineChartNonFilledGrid()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->fillGrid = 1;

        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRender3dFilledLineChartNonFilledAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphLineChart();
        $chart->palette = new ezcGraphPaletteBlack();

        $chart['Line 1'] = new ezcGraphArrayDataSet( array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1) );
        $chart['Line 2'] = new ezcGraphArrayDataSet( array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613) );

        $chart->driver = new ezcGraphGdDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->renderer->options->fillAxis = 1;

        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderPieChartWithBackgroundBottomCenter()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/ez.png';
        $chart->background->position = ezcGraph::BOTTOM | ezcGraph::CENTER;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderPieChartWithHorizontalTextureBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart['sample'] = new ezcGraphArrayDataSet( array(
            'Mozilla' => 4375,
            'IE' => 345,
            'Opera' => 1204,
            'wget' => 231,
            'Safari' => 987,
        ) );

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/texture.png';
        $chart->background->repeat = ezcGraph::HORIZONTAL;
        $chart->background->position = ezcGraph::BOTTOM;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }
}

?>
