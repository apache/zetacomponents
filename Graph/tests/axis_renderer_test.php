<?php
/**
 * ezcGraphAxisRendererTest 
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
class ezcGraphAxisRendererTest extends ezcTestCase
{

    protected $renderer;

    protected $driver;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphAxisRendererTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        $this->renderer = new ezcGraphRenderer2D();

        $this->driver = $this->getMock( 'ezcGraphGdDriver', array(
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

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testDetermineCuttingPoint()
    {
        $aStart = new ezcGraphCoordinate( -1, -5 );
        $aDir = new ezcGraphCoordinate( 4, 3 );

        $bStart = new ezcGraphCoordinate( 1, 2 );
        $bDir = new ezcGraphCoordinate( 1, -2 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertEquals(
            $cuttingPosition,
            2.,
            'Cutting position should be <2>',
            .1
        );

        $cuttingPoint = new ezcGraphCoordinate(
            $bStart->x + $cuttingPosition * $bDir->x,
            $bStart->y + $cuttingPosition * $bDir->y
        );

        $this->assertEquals(
            $cuttingPoint,
            new ezcGraphCoordinate( 3., -2. ),
            'Wrong cutting point.',
            .1
        );
    }

    public function testDetermineCuttingPoint2()
    {
        $aStart = new ezcGraphCoordinate( 0, 2 );
        $aDir = new ezcGraphCoordinate( 3, 1 );

        $bStart = new ezcGraphCoordinate( 2, -1 );
        $bDir = new ezcGraphCoordinate( 1, 2 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertEquals(
            $cuttingPosition,
            2.2,
            'Cutting position should be <2.2>',
            .1
        );

        $cuttingPoint = new ezcGraphCoordinate(
            $bStart->x + $cuttingPosition * $bDir->x,
            $bStart->y + $cuttingPosition * $bDir->y
        );

        $this->assertEquals(
            $cuttingPoint,
            new ezcGraphCoordinate( 4.2, 3.4 ),
            'Wrong cutting point.',
            .1
        );
    }

    public function testNoCuttingPoint()
    {
        $aStart = new ezcGraphCoordinate( 0, 0 );
        $aDir = new ezcGraphCoordinate( 1, 0 );

        $bStart = new ezcGraphCoordinate( 0, 1 );
        $bDir = new ezcGraphCoordinate( 3, 0 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertSame(
            $cuttingPosition,
            false,
            'There should not be a cutting point.'
        );
    }

    public function testRenderAxisSteps()
    {
        $aStart = new ezcGraphCoordinate( 0, 0 );
        $aDir = new ezcGraphCoordinate( 1, 0 );

        $bStart = new ezcGraphCoordinate( 0, 1 );
        $bDir = new ezcGraphCoordinate( 3, 0 );

        $axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $cuttingPosition = $axisLabelRenderer->determineLineCuttingPoint( $aStart, $aDir, $bStart, $bDir );

        $this->assertSame(
            $cuttingPosition,
            false,
            'There should not be a cutting point.'
        );
    }
}
?>
