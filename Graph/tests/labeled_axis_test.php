<?php
/**
 * ezcGraphLabeledAxisTest 
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
class ezcGraphLabeledAxisTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphLabeledAxisTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testFactoryLabeledAxis()
    {
        $chart = ezcGraph::create( 'Line' );

        $this->assertTrue(
            $chart->xAxis instanceof ezcGraphChartElementLabeledAxis
            );
    }

    public function testAutomaticLabelingSingle()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 20, 70, 12, 130 );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
            ),
            $this->getNonPublicProperty( $chart->xAxis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultiple()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2002 => 1270, 1170, 1610, 1370 );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
            ),
            $this->getNonPublicProperty( $chart->xAxis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultipleMixed()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 2001 => 1300, 2004 => 1012, 2006 => 1450 );
        $chart['sample2'] = array( 2001 => 1270, 1170, 1610, 1370, 1559 );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
                '2004',
                '2005',
                '2006',
            ),
            $this->getNonPublicProperty( $chart->xAxis, 'labels' )
        );
    }

    public function testPositionLeft()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->xAxis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            67.5,
            $chart->xAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->xAxis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            172.5,
            $chart->xAxis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->xAxis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            67.5,
            $chart->xAxis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionRight()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->xAxis->position = ezcGraph::RIGHT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            382.5,
            $chart->xAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            382.5,
            $chart->xAxis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            277.5,
            $chart->xAxis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            67.5,
            $chart->xAxis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            382.5,
            $chart->xAxis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionTop()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->xAxis->position = ezcGraph::TOP;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            87.75,
            $chart->xAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            87.75,
            $chart->xAxis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            164.25,
            $chart->xAxis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            317.25,
            $chart->xAxis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            87.75,
            $chart->xAxis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->xAxis->position = ezcGraph::BOTTOM;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            317.25,
            $chart->xAxis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            317.25,
            $chart->xAxis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            240.75,
            $chart->xAxis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            87.75,
            $chart->xAxis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            317.25,
            $chart->xAxis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testRenderLabeledAxisBase()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 100, 190 ) ),
                $this->equalTo( new ezcGraphCoordinate( 500, 190 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLabeledAxisArrowHead()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawPolygon',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawPolygon' )
            ->with(
                $this->equalTo( array(
                    new ezcGraphCoordinate( 500, 190 ),
                    new ezcGraphCoordinate( 492, 186 ),
                    new ezcGraphCoordinate( 492, 194 ),
                ) ),
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( true )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLabeledAxisMajor()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 194 ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 186 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 240, 194 ) ),
                $this->equalTo( new ezcGraphCoordinate( 240, 186 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 361, 194 ) ),
                $this->equalTo( new ezcGraphCoordinate( 361, 186 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#2E3436' ) ),
                $this->equalTo( new ezcGraphCoordinate( 481, 194 ) ),
                $this->equalTo( new ezcGraphCoordinate( 481, 186 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisMajorGrid()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->xAxis->grid = '#BBBBBB';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawLine',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 0 ) ),
                $this->equalTo( new ezcGraphCoordinate( 120, 200 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 240, 0 ) ),
                $this->equalTo( new ezcGraphCoordinate( 240, 200 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 361, 0 ) ),
                $this->equalTo( new ezcGraphCoordinate( 361, 200 ) ),
                $this->equalTo( false )
            );
        $mockedRenderer
            ->expects( $this->at( 7 ) )
            ->method( 'drawLine' )
            ->with(
                $this->equalTo( ezcGraphColor::fromHex( '#BBBBBB' ) ),
                $this->equalTo( new ezcGraphCoordinate( 481, 0 ) ),
                $this->equalTo( new ezcGraphCoordinate( 481, 200 ) ),
                $this->equalTo( false )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLabeledAxisLabels()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 122, 192 ) ),
                $this->equalTo( '2000' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 212, 192 ) ),
                $this->equalTo( '2001' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 303, 192 ) ),
                $this->equalTo( '2002' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 393, 192 ) ),
                $this->equalTo( '2003' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::TOP )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderNumericAxisCustomLabels()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['sample'] = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart['sample2'] = array( 2000 => 1270, 1170, 1610, 1370 );
        $chart->xAxis->formatString = 'test';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 122, 192 ) ),
                $this->equalTo( 'test' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 3 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 212, 192 ) ),
                $this->equalTo( 'test' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 4 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 303, 192 ) ),
                $this->equalTo( 'test' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 5 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 393, 192 ) ),
                $this->equalTo( 'test' ),
                $this->equalTo( 88 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::TOP )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testRenderLabeledAxisWithManyPoints()
    {
        $data = array();
        for ( $i = -100; $i <= 500; ++$i )
        {
            $data[$i] = 25 * sin( $i / 50 );
        }
        $chart = ezcGraph::create( 'Line' );
        $chart['sinus'] = $data;

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawTextBox',
        ) );

        // X-Axis
        $mockedRenderer
            ->expects( $this->at( 1 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 122, 102 ) ),
                $this->equalTo( '-100' ),
                $this->equalTo( 31 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::LEFT | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 2 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 155, 102 ) ),
                $this->equalTo( '-40' ),
                $this->equalTo( 31 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::CENTER | ezcGraph::TOP )
            );
        $mockedRenderer
            ->expects( $this->at( 11 ) )
            ->method( 'drawTextBox' )
            ->with(
                $this->equalTo( new ezcGraphCoordinate( 450, 102 ) ),
                $this->equalTo( '500' ),
                $this->equalTo( 31 ),
                $this->equalTo( 8 ),
                $this->equalTo( ezcGraph::RIGHT | ezcGraph::TOP )
            );

        $chart->renderer = $mockedRenderer;

        $chart->render( 500, 200 );
    }

    public function testSetNumericAxis()
    {
        $chart = ezcGraph::create( 'line' );
        $chart->xAxis = new ezcGraphChartElementLabeledAxis();
        $chart->yAxis = new ezcGraphChartElementLabeledAxis();

        $this->assertTrue(
            $chart->xAxis instanceof ezcGraphChartElementLabeledAxis,
            'X axis should be labeled.'
        );

        $this->assertTrue(
            $chart->yAxis instanceof ezcGraphChartElementLabeledAxis,
            'Y axis should be labeled.'
        );
    }
}

?>
