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
class ezcGraphRenderer3dTest extends ezcTestCase
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
        if ( version_compare( phpversion(), '5.1.3', '<' ) )
        {
            $this->markTestSkipped( "These tests required atleast PHP 5.1.3" );
        }
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
        if( !$this->hasFailed() )
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

    public function testRenderLabeledPieSegmentWithGleamAndShadowGD()
    {
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

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png'
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

    public function testRenderPieChartWithBackgroundBottomCenter()
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

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/ez.png';
        $chart->background->position = ezcGraph::BOTTOM | ezcGraph::CENTER;

        $chart->driver = new ezcGraphSvgDriver();
        $chart->renderer = new ezcGraphRenderer3d();
        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderPieChartWithHorizontalTextureBackground()
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

        $chart->background->color = '#FFFFFFDD';
        $chart->background->image = dirname( __FILE__ ) . '/data/texture.png';
        $chart->background->repeat = ezcGraph::HORIZONTAL;
        $chart->background->position = ezcGraph::BOTTOM;

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
}

?>
