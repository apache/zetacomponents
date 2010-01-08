<?php
/**
 * ezcGraphDateAxisTest 
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
class ezcGraphDateAxisTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

    protected $chart;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphDateAxisTest" );
	}

    protected function setUp()
    {
        date_default_timezone_set( 'Europe/Berlin' );

        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        $this->chart = new ezcGraphLineChart();
        $this->chart->xAxis = new ezcGraphChartElementDateAxis();
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }

        unset( $this->chart );
    }

    public function testManualScaling()
    {
        $this->chart->xAxis->startDate = 0;
        $this->chart->xAxis->endDate = 100;
        $this->chart->xAxis->interval = 10;

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 10 => 12, 37 => 235, 43 => 17, 114 => 39 ) );

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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
        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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

    public function testStrToTimeLabelConvertion()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            '1.1.2001' => 324,
            '1.1.2002' => 324,
            '1.1.2003' => 324,
            '1.1.2004' => 324,
        ) );

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

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

    public function testRenderedLabels()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            '1.1.2001' => 324,
            '1.1.2002' => 324,
            '1.1.2003' => 324,
            '1.1.2004' => 324,
        ) );

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $this->chart->xAxis->getSteps();

        $expectedLabels = array(
            '2001', '2002', '2003', '2004'
        );

        foreach ( $steps as $nr => $step )
        {
            $this->assertSame(
                $step->label,
                $expectedLabels[$nr],
                'Label not as expected'
            );
        }
    }

    public function testRenderedLabelsWithLabelFormattingCallback()
    {
        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            '1.1.2001' => 324,
            '1.1.2002' => 324,
            '1.1.2003' => 324,
            '1.1.2004' => 324,
        ) );
        $this->chart->xAxis->labelCallback = create_function(
            '$label',
            'return "*$label*";'
        );

        try
        {
            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphFontRenderingException $e )
        {
            // Ignore
        }

        $steps = $this->chart->xAxis->getSteps();

        $expectedLabels = array(
            '*2001*', '*2002*', '*2003*', '*2004*'
        );

        foreach ( $steps as $nr => $step )
        {
            $this->assertSame(
                $step->label,
                $expectedLabels[$nr],
                'Label not as expected'
            );
        }
    }

    public function testStrToTimeLabelConvertionRendering()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            '1.1.2001' => 12,
            '1.1.2002' => 324,
            '1.1.2003' => 238,
            '1.1.2004' => 123,
        ) );
        $chart->data['some data']->symbol = ezcGraph::DIAMOND;

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testFloatDataSetKeys()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            '231.1' => 12,
            '651.2' => 324,
            '3241.3' => 238,
            '3292.4' => 123,
        ) );
        $this->chart->data['some data']->symbol = ezcGraph::DIAMOND;

        $this->chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testMonthInterval1()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            strtotime( '2006-10-16' ) => 7.78507871321,
            strtotime( '2006-10-30' ) => 7.52224503765,
            strtotime( '2006-11-20' ) => 7.29226557153,
            strtotime( '2006-11-28' ) => 7.06228610541,
            strtotime( '2006-12-05' ) => 6.66803559206,
            strtotime( '2006-12-11' ) => 6.37234770705,
            strtotime( '2006-12-28' ) => 6.04517453799,
        ) );
        $this->chart->data['some data']->symbol = ezcGraph::DIAMOND;
        $this->chart->xAxis->startDate = strtotime( '2006-10-01' );

        $this->chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testMonthInterval2()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            strtotime( '2006-10-16' ) => 7.78507871321,
            strtotime( '2006-10-30' ) => 7.52224503765,
            strtotime( '2006-11-20' ) => 7.29226557153,
            strtotime( '2006-11-28' ) => 7.06228610541,
            strtotime( '2006-12-05' ) => 6.66803559206,
            strtotime( '2006-12-11' ) => 6.37234770705,
            strtotime( '2006-12-28' ) => 6.04517453799,
        ) );
        $this->chart->xAxis->startDate = strtotime( '2006-10-04' );
        $this->chart->data['some data']->symbol = ezcGraph::DIAMOND;

        $this->chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testMonthInterval3()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            strtotime( '2006-10-16' ) => 7.78507871321,
            strtotime( '2006-10-30' ) => 7.52224503765,
            strtotime( '2006-11-20' ) => 7.29226557153,
            strtotime( '2006-11-28' ) => 7.06228610541,
            strtotime( '2006-12-05' ) => 6.66803559206,
            strtotime( '2006-12-11' ) => 6.37234770705,
            strtotime( '2006-12-28' ) => 6.04517453799,
        ) );
        $this->chart->xAxis->endDate = strtotime( '2006-12-30' );
        $this->chart->data['some data']->symbol = ezcGraph::DIAMOND;

        $this->chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testMonthInterval4()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
            strtotime( '2006-10-16' ) => 7.78507871321,
            strtotime( '2006-10-30' ) => 7.52224503765,
            strtotime( '2006-11-20' ) => 7.29226557153,
            strtotime( '2006-11-28' ) => 7.06228610541,
            strtotime( '2006-12-05' ) => 6.66803559206,
            strtotime( '2006-12-11' ) => 6.37234770705,
            strtotime( '2006-12-28' ) => 6.04517453799,
        ) );
        $this->chart->xAxis->startDate = strtotime( '2006-10-03' );
        $this->chart->xAxis->endDate = strtotime( '2007-01-01' );
        $this->chart->data['some data']->symbol = ezcGraph::DIAMOND;

        $this->chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDateParsingException()
    {
        try
        {
            $this->chart->data['some data'] = new ezcGraphArrayDataSet( array( 
                'invalid time' => 7.78507871321,
            ) );

            $this->chart->render( 500, 200 );
        }
        catch ( ezcGraphErrorParsingDateException $e )
        {
            return;
        }

        $this->fail( 'Expected ezcGraphErrorParsingDateException.' );
    }
}

?>
