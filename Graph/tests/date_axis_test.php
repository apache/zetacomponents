<?php
/**
 * ezcGraphDateAxisTest 
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
class ezcGraphDateAxisTest extends ezcTestCase
{

    protected $chart;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphDateAxisTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        date_default_timezone_set( 'Europe/Berlin' );

        $this->chart = new ezcGraphLineChart();
        $this->chart->xAxis = new ezcGraphChartElementDateAxis();
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        unset( $this->chart );
    }

    public function testManualScaling()
    {
        $this->chart->xAxis->startDate = 0;
        $this->chart->xAxis->endDate = 100;
        $this->chart->xAxis->interval = 10;

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 10 => 12, 37 => 235, 43 => 17, 114 => 39 ) );

        $this->chart->render( 500, 200 );

        $this->assertEquals(
            0,
            $this->chart->xAxis->startDate,
            'Wrong starting date. '
        );

        $this->assertEquals(
            100,
            $this->chart->xAxis->endDate,
            'Wrong end date. '
        );

        $this->assertEquals(
            10,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testManualBoundingsForScaling()
    {
        $this->chart->xAxis->startDate = 0;
        $this->chart->xAxis->endDate = 100;

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 10 => 12, 37 => 235, 43 => 17, 114 => 39 ) );

        $this->chart->render( 500, 200 );

        $this->assertEquals(
            0,
            $this->chart->xAxis->startDate,
            'Wrong starting date. '
        );

        $this->assertEquals(
            100,
            $this->chart->xAxis->endDate,
            'Wrong end date. '
        );

        $this->assertEquals(
            10,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testManualIntervalForScaling()
    {
        $this->chart->xAxis->interval = 10;

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 10 => 12, 37 => 235, 43 => 17, 114 => 39 ) );

        $this->chart->render( 500, 200 );

        $this->assertEquals(
            10,
            $this->chart->xAxis->startDate,
            'Wrong starting date. '
        );

        $this->assertEquals(
            120,
            $this->chart->xAxis->endDate,
            'Wrong end date. '
        );

        $this->assertEquals(
            10,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testAutomagicScalingSingle1()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 10 => 12, 37 => 235, 43 => 17, 114 => 39 ) );
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            0,
            $this->chart->xAxis->startDate,
            'Wrong starting date. '
        );

        $this->assertEquals(
            120,
            $this->chart->xAxis->endDate,
            'Wrong end date. '
        );

        $this->assertEquals(
            30,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testAutomagicScalingSingle2()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 30010 => 12, 30037 => 235, 30043 => 17, 30114 => 39 ) );
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            30000,
            $this->chart->xAxis->startDate,
            'Wrong starting date. '
        );

        $this->assertEquals(
            30120,
            $this->chart->xAxis->endDate,
            'Wrong end date. '
        );

        $this->assertEquals(
            30,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testAutomagicScalingSingle3()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            mktime( 10, 13, 57, 5, 7, 2006 ) => 324,
            mktime( 10, 46, 13, 5, 7, 2006 ) => 324,
            mktime( 11, 15, 45, 5, 7, 2006 ) => 324,
            mktime( 12, 32, 01, 5, 7, 2006 ) => 324,
        ) );
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            'Sun, 07 May 2006 10:00:00 +0200',
            date( 'r', $this->chart->xAxis->startDate ),
            'Wrong starting date. '
        );

        $this->assertEquals(
            'Sun, 07 May 2006 13:00:00 +0200',
            date( 'r', $this->chart->xAxis->endDate ),
            'Wrong end date. '
        );

        $this->assertEquals(
            1800,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testAutomagicScalingSingle4()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            mktime( 10, 13, 57, 5, 7, 2006 ) => 324,
            mktime( 17, 46, 13, 5, 7, 2006 ) => 324,
            mktime( 11, 15, 45, 5, 8, 2006 ) => 324,
            mktime( 20, 32, 1, 5, 8, 2006 ) => 324,
            mktime( 8, 43, 19, 5, 9, 2006 ) => 324,
        ) );
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            'Sun, 07 May 2006 06:00:00 +0200',
            date( 'r', $this->chart->xAxis->startDate ),
            'Wrong starting date. '
        );

        $this->assertEquals(
            'Tue, 09 May 2006 12:00:00 +0200',
            date( 'r', $this->chart->xAxis->endDate ),
            'Wrong end date. '
        );

        $this->assertEquals(
            21600,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testAutomagicScalingSingle5()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            mktime( 1, 0, 0, 1, 1, 2001 ) => 324,
            mktime( 1, 0, 0, 1, 1, 2002 ) => 324,
            mktime( 1, 0, 0, 1, 1, 2003 ) => 324,
            mktime( 1, 0, 0, 1, 1, 2004 ) => 324,
        ) );
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            'Mon, 01 Jan 2001 01:00:00 +0100',
            date( 'r', $this->chart->xAxis->startDate ),
            'Wrong starting date. '
        );

        $this->assertEquals(
            'Thu, 01 Jan 2004 01:00:00 +0100',
            date( 'r', $this->chart->xAxis->endDate ),
            'Wrong end date. '
        );

        $this->assertEquals(
            31536000,
            $this->chart->xAxis->interval,
            'Wrong interval. '
        );
    }

    public function testPositionLeft()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            mktime( 10, 13, 57, 5, 7, 2006 ) => 324,
            mktime( 17, 46, 13, 5, 7, 2006 ) => 324,
            mktime( 11, 15, 45, 5, 8, 2006 ) => 324,
            mktime( 20, 32, 1, 5, 8, 2006 ) => 324,
            mktime( 8, 43, 19, 5, 9, 2006 ) => 324,
        ) );
        $this->chart->xAxis->position = ezcGraph::LEFT;
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            0.,
            $this->chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            0.,
            $this->chart->xAxis->getCoordinate( mktime( 6, 0, 0, 5, 7, 2006 ) ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .575,
            $this->chart->xAxis->getCoordinate( mktime( 13, 1, 34, 5, 8, 2006 ) ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            1.,
            $this->chart->xAxis->getCoordinate( mktime( 12, 0, 0, 5, 9, 2006 ) ),
            'Wrong maximum value. ',
            .05
        );
    }

    public function testPositionRight()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            mktime( 10, 13, 57, 5, 7, 2006 ) => 324,
            mktime( 17, 46, 13, 5, 7, 2006 ) => 324,
            mktime( 11, 15, 45, 5, 8, 2006 ) => 324,
            mktime( 20, 32, 1, 5, 8, 2006 ) => 324,
            mktime( 8, 43, 19, 5, 9, 2006 ) => 324,
        ) );
        $this->chart->xAxis->position = ezcGraph::RIGHT;
        $this->chart->render( 500, 200 );

        $this->assertEquals(
            1.,
            $this->chart->xAxis->getCoordinate( false ),
            'Wrong initial axis position. ',
            .05
        );

        $this->assertEquals(
            1.,
            $this->chart->xAxis->getCoordinate( mktime( 6, 0, 0, 5, 7, 2006 ) ),
            'Wrong minimal value. ',
            .05
        );

        $this->assertEquals(
            .425,
            $this->chart->xAxis->getCoordinate( mktime( 13, 1, 34, 5, 8, 2006 ) ),
            'Wrong mid value. ',
            .05
        );

        $this->assertEquals(
            0.,
            $this->chart->xAxis->getCoordinate( mktime( 12, 0, 0, 5, 9, 2006 ) ),
            'Wrong maximum value. ',
            .05
        );
    }
}

?>
