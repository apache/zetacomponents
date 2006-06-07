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
            $chart->X_axis instanceof ezcGraphChartElementLabeledAxis
            );
    }

    public function testAutomaticLabelingSingle()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 20, 70, 12, 130 );
        $chart->render( 500, 200 );

        $this->assertSame(
            array(
                '2000',
                '2001',
                '2002',
                '2003',
            ),
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultiple()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2002 => 1270, 1170, 1610, 1370 );
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
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testAutomaticLabelingMultipleMixed()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 2001 => 1300, 2004 => 1012, 2006 => 1450 );
        $chart->sample2 = array( 2001 => 1270, 1170, 1610, 1370, 1559 );
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
            $this->getNonPublicProperty( $chart->X_axis, 'labels' )
        );
    }

    public function testPositionLeft()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->X_axis->position = ezcGraph::LEFT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            67.5,
            $chart->X_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            67.5,
            $chart->X_axis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            172.5,
            $chart->X_axis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            382.5,
            $chart->X_axis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            67.5,
            $chart->X_axis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionRight()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->X_axis->position = ezcGraph::RIGHT;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            382.5,
            $chart->X_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            382.5,
            $chart->X_axis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            277.5,
            $chart->X_axis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            67.5,
            $chart->X_axis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            382.5,
            $chart->X_axis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionTop()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->X_axis->position = ezcGraph::TOP;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            87.75,
            $chart->X_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            87.75,
            $chart->X_axis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            164.25,
            $chart->X_axis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            317.25,
            $chart->X_axis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            87.75,
            $chart->X_axis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testPositionBottom()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->X_axis->position = ezcGraph::BOTTOM;
        $chart->render( 500, 200 );

        $testBoundings = new ezcGraphBoundings();
        $testBoundings->x0 = 50;
        $testBoundings->x1 = 400;
        $testBoundings->y0 = 75;
        $testBoundings->y1 = 330;

        $this->assertEquals(
            317.25,
            $chart->X_axis->getCoordinate( $testBoundings, false ),
            'Wrong initial axis position. '
        );

        $this->assertEquals(
            317.25,
            $chart->X_axis->getCoordinate( $testBoundings, '2000' ),
            'Wrong minimal value. '
        );

        $this->assertEquals(
            240.75,
            $chart->X_axis->getCoordinate( $testBoundings, 2001 ),
            'Wrong mid value. '
        );

        $this->assertEquals(
            87.75,
            $chart->X_axis->getCoordinate( $testBoundings, '2003' ),
            'Wrong maximum value. '
        );

        $this->assertEquals(
            317.25,
            $chart->X_axis->getCoordinate( $testBoundings, '1991' ),
            'Wrong return for unknown value. '
        );
    }

    public function testRenderLabeledAxisBase()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

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
                    new ezcGraphCoordinate( 490, 185 ),
                    new ezcGraphCoordinate( 490, 195 ),
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
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

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

    public function testRenderLabeledAxisLabels()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart->sample = array( 2000 => 1045, 1300, 1012, 1450 );
        $chart->sample2 = array( 2000 => 1270, 1170, 1610, 1370 );

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
}

?>
