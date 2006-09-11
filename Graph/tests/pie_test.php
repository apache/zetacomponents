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
		return new ezcTestSuite( "ezcGraphPieChartTest" );
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
        $this->removeTempDir();
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
                $this->equalTo( ezcGraphColor::fromHex( '#F57900' ) ),
                $this->equalTo( 310., 1. ),
                $this->equalTo( 360., 1. ),
                $this->equalTo( 'Safari: 987 (13.8%)' ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 400, 200 );
    }

    public function testRenderPieChartWithLotsOfLabels()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) && 
             ( ezcBaseFeatures::hasFunction( 'imagefttext' ) || ezcBaseFeatures::hasFunction( 'imagettftext' ) ) )
        {
            $this->markTestSkipped( 'This test needs ext/gd with native ttf support or FreeType 2 support.' );
        }

        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->data['Skien']->highlight['Norwegian'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }

    public function testRenderPortraitPieChartWithLotsOfLabels()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) && 
             ( ezcBaseFeatures::hasFunction( 'imagefttext' ) || ezcBaseFeatures::hasFunction( 'imagettftext' ) ) )
        {
            $this->markTestSkipped( 'This test needs ext/gd with native ttf support or FreeType 2 support.' );
        }

        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = new ezcGraphPieChart();
        $chart->data['Skien'] = new ezcGraphArrayDataSet( array( 'Norwegian' => 10, 'Dutch' => 3, 'German' => 2, 'French' => 2, 'Hindi' => 1, 'Taiwanese' => 1, 'Brazilian' => 1, 'Venezuelan' => 1, 'Japanese' => 1, 'Czech' => 1, 'Hungarian' => 1, 'Romanian' => 1 ) );

        $chart->data['Skien']->highlight['Norwegian'] = true;

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font->path = $this->basePath . 'font.ttf';
        $chart->render( 500, 500, $filename );

        $this->assertImageSimilar(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.png',
            'Image does not look as expected.',
            2000
        );
    }
}
?>
