<?php
/**
 * ezcGraphDataSetAverageTest 
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
class ezcGraphDataSetAverageTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphDataSetAverageTest" );
	}

    protected function setUp()
    {
        static $i = 0;
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

    public function testCreateDatasetFromDataset()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 1, 0 => 0, 1 => 1 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 2;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromSingleElementDataset()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( 1 => 1 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            '1',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromSingleElementDatasetRender()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();

        $chart->data['src'] = new ezcGraphArrayDataSet( array( 1 => 1 ) );
        $chart->data['avg'] = new ezcGraphDataSetAveragePolynom( $chart->data['src'] );

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testCreateDatasetFromDataset2()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 2;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2 + 1',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset3_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        date_default_timezone_set( 'MET' );
        $arrayDataSet = new ezcGraphArrayDataSet( array(
            strtotime( 'Jun 2006' ) => 1300000,
            strtotime( 'May 2006' ) => 1200000,
            strtotime( 'Apr 2006' ) => 1100000,
            strtotime( 'Mar 2006' ) => 1100000,
            strtotime( 'Feb 2006' ) => 1000000,
            strtotime( 'Jan 2006' ) =>  965000,
        ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 2 );

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            '8.2e-10 x^2 - 1.85 x + 1.0e+9',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset3()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        date_default_timezone_set( 'MET' );
        $arrayDataSet = new ezcGraphArrayDataSet( array(
            strtotime( 'Jun 2006' ) => 1300000,
            strtotime( 'May 2006' ) => 1200000,
            strtotime( 'Apr 2006' ) => 1100000,
            strtotime( 'Mar 2006' ) => 1100000,
            strtotime( 'Feb 2006' ) => 1000000,
            strtotime( 'Jan 2006' ) =>  965000,
        ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 2 );

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            '8.21e-10 x^2 - 1.85 x + 1.04e+9',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset4()
    {
        $points = array();
        for ( $x = -1; $x <= 5; ++$x )
        {
            $points[$x] = pow( $x - 2, 3 ) - .21 * pow( $x - 2, 2 ) + .2 * ( $x - 2 ) - 2.45;
        }

        $arrayDataSet = new ezcGraphArrayDataSet( $points );
        
        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 3 );
        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^3 - 6.21 x^2 + 13.0 x - 11.7',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset5_52()
    {
        if ( version_compare( phpversion(), '5.2.0', '>' ) )
        {
            $this->markTestSkipped( "This test is only for PHP prior 5.2.1. See PHP bug #40482." );
        }

        $points = array();
        for ( $x = -3; $x <= 3; ++$x )
        {
            $points[$x] = pow( $x, 3 ) - .21 * pow( $x, 2 ) + .2 * $x - 2.45;
        }

        $arrayDataSet = new ezcGraphArrayDataSet( $points );
        
        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 3 );
        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^3 - 2.1e-1 x^2 + 2.0e-1 x - 2.45',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset5()
    {
        if ( version_compare( phpversion(), '5.2.1', '<' ) )
        {
            $this->markTestSkipped( "This test is only for PHP after 5.2.1. See PHP bug #40482." );
        }

        $points = array();
        for ( $x = -3; $x <= 3; ++$x )
        {
            $points[$x] = pow( $x, 3 ) - .21 * pow( $x, 2 ) + .2 * $x - 2.45;
        }

        $arrayDataSet = new ezcGraphArrayDataSet( $points );
        
        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 3 );
        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^3 - 2.10e-1 x^2 + 2.00e-1 x - 2.45',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDatasetLowOrder()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 1;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            '2.00 x + 2.67',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDatasetHighOrder()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2 + 1',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDatasetHighOrderConstructorParameter()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet, 3 );
        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2 + 1',
            $polynom->__toString()
        );
    }

    public function testIterateOverAverageDataset()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;

        $this->assertEquals(
            2.,
            $averageDataSet[-1],
            'Polynom should evaluate to 2.',
            .01
        );

        $this->assertEquals(
            2.,
            $averageDataSet[1],
            'Polynom should evaluate to 2.',
            .01
        );

        $this->assertEquals(
            5.,
            $averageDataSet[2],
            'Polynom should evaluate to 5.',
            .01
        );

        $this->assertEquals(
            10.,
            $averageDataSet[3],
            'Polynom should evaluate to 10.',
            .01
        );
    }

    public function testIterateOverAverageDataset2()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;

        $stepSize = 4 / 100;
        $start = -1 - $stepSize;

        foreach ( $averageDataSet as $key => $value )
        {
            $this->assertEquals( (string) ( $start += $stepSize ), $key, 'Wrong step.', .01 );
        }
    }

    public function testIterateOverAverageDataset3()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;
        $averageDataSet->resolution = 10;

        $stepSize = 4 / 10;
        $start = -1 - $stepSize;

        foreach ( $averageDataSet as $key => $value )
        {
            $this->assertEquals( (string) ( $start += $stepSize ), $key, 'Wrong step.', .01 );
        }
    }

    public function testRenderCompleteLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['Statistical data'] = new ezcGraphArrayDataSet( array(
            '1' => 1,
            '2.5' => -2.3,
            '3.1' => 1.4,
            '4' => 5,
            '5.3' => 1.2,
            '7' => 6.5,
        ) );
        $chart->data['Statistical data']->symbol = ezcGraph::BULLET;

        $chart->data['polynom order 0'] = new ezcGraphDataSetAveragePolynom( $chart->data['Statistical data'], 0 );
        $chart->data['polynom order 1'] = new ezcGraphDataSetAveragePolynom( $chart->data['Statistical data'], 1 );
        $chart->data['polynom order 3'] = new ezcGraphDataSetAveragePolynom( $chart->data['Statistical data'], 3 );
        $chart->data['polynom order 5'] = new ezcGraphDataSetAveragePolynom( $chart->data['Statistical data'], 5 );
        
        $chart->xAxis = new ezcGraphChartElementNumericAxis();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderCompleteLineChart2()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        date_default_timezone_set( 'MET' );
        $chart->data['Statistical data'] = new ezcGraphArrayDataSet( array(
            'Jun 2006' => 1300000,
            'May 2006' => 1200000,
            'Apr 2006' => 1100000,
            'Mar 2006' => 1100000,
            'Feb 2006' => 1000000,
            'Jan 2006' =>  965000,
        ) );
        $chart->data['Statistical data']->symbol = ezcGraph::BULLET;

        $chart->data['polynom order 2'] = new ezcGraphDataSetAveragePolynom( $chart->data['Statistical data'], 2 );
        
        $chart->xAxis = new ezcGraphChartElementNumericAxis();

        try
        {
            $chart->render( 500, 200, $filename );
        }
        catch ( ezcGraphDatasetAverageInvalidKeysException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphDatasetAverageInvalidKeysException.' );
    }

    public function testAverageDataSetIsset()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;
        $averageDataSet->resolution = 10;

        $this->assertSame( 
            isset( $averageDataSet[0] ),
            true,
            'Polygon not properly initialized.'
        );
    }

    public function testDataSetAveragePolynomPropertyPolynomOrder()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );
        $dataset = new ezcGraphDataSetAveragePolynom( $arrayDataSet );

        $this->assertSame(
            3,
            $dataset->polynomOrder,
            'Wrong default value for property polynomOrder in class ezcGraphDataSetAveragePolynom'
        );

        $dataset->polynomOrder = 5;
        $this->assertSame(
            5,
            $dataset->polynomOrder,
            'Setting property value did not work for property polynomOrder in class ezcGraphDataSetAveragePolynom'
        );

        try
        {
            $dataset->polynomOrder = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDataSetAveragePolynomPropertyResolution()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );
        $dataset = new ezcGraphDataSetAveragePolynom( $arrayDataSet );

        $this->assertSame(
            100,
            $dataset->resolution,
            'Wrong default value for property resolution in class ezcGraphDataSetAveragePolynom'
        );

        $dataset->resolution = 5;
        $this->assertSame(
            5,
            $dataset->resolution,
            'Setting property value did not work for property resolution in class ezcGraphDataSetAveragePolynom'
        );

        try
        {
            $dataset->resolution = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
