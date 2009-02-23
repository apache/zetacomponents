<?php
/**
 * ezcGraphRenderer2dTest 
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
class ezcGraphRenderer2dLegacyTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $renderer;

    protected $driver;

	public static function suite()
	{
	    return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

        $this->renderer = new ezcGraphRenderer2d();

        $this->driver = $this->getMock( 'ezcGraphSvgDriver', array(
            'drawPolygon',
            'drawLine',
            'drawTextBox',
            'drawCircleSector',
            'drawCircularArc',
            'drawCircle',
            'drawImage',
        ) );
        $this->renderer->setDriver( $this->driver );

        $this->driver->options->width = 400;
        $this->driver->options->height = 200;
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testRenderVerticalAxis()
    {
        $chart = new ezcGraphLineChart();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 120., 220. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 120., 20. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 120., 20. ),
                    new ezcGraphCoordinate( 122.5, 25. ),
                    new ezcGraphCoordinate( 117.5, 25. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 20, 200 ),
            new ezcGraphCoordinate( 20, 0 ),
            $chart->yAxis
        );
    }
    
    public function testRenderVerticalAxisReverse()
    {
        $chart = new ezcGraphLineChart();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 120., 20. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 120., 220. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 120., 220. ),
                    new ezcGraphCoordinate( 117.5, 215. ),
                    new ezcGraphCoordinate( 122.5, 215. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 20, 0 ),
            new ezcGraphCoordinate( 20, 200 ),
            $chart->yAxis
        );
    }
    
    public function testRenderHorizontalAxis()
    {
        $chart = new ezcGraphLineChart();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 150., 120. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 450., 120. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 450., 120. ),
                    new ezcGraphCoordinate( 442., 124. ),
                    new ezcGraphCoordinate( 442., 116. ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 50, 100 ),
            new ezcGraphCoordinate( 350, 100 ),
            $chart->yAxis
        );
    }
    
    public function testRenderHorizontalAxisReverse()
    {
        $chart = new ezcGraphLineChart();

        $this->driver
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 450., 120. ), 1. ),
                $this->equalTo( new ezcGraphCoordinate( 150., 120. ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( 1 )
            );
        $this->driver
            ->expects( $this->at( 1 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 150., 120. ),
                    new ezcGraphCoordinate( 157., 116.5 ),
                    new ezcGraphCoordinate( 157., 123.5 ),
                ), 1. ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $this->renderer->drawAxis(
            new ezcGraphBoundings( 100, 20, 500, 220 ),
            new ezcGraphCoordinate( 350, 100 ),
            new ezcGraphCoordinate( 50, 100 ),
            $chart->yAxis
        );
    }
}
?>
