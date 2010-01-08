<?php
/**
 * ezcGraphNumericDataSetTest 
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
class ezcGraphNumericDataSetTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphNumericDataSetTest" );
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

    public function testNumericDataSetPropertyResolution()
    {
        $dataset = new ezcGraphNumericDataSet();

        $this->assertSame(
            100,
            $dataset->resolution,
            'Wrong default value for property resolution in class ezcGraphNumericDataSet'
        );

        $dataset->resolution = 5;
        $this->assertSame(
            5,
            $dataset->resolution,
            'Setting property value did not work for property resolution in class ezcGraphNumericDataSet'
        );

        $this->assertSame(
            6,
            count( $dataset ),
            'Setting property value did not work for property resolution in class ezcGraphNumericDataSet'
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

    public function testNumericDataSetPropertyStart()
    {
        $dataset = new ezcGraphNumericDataSet();

        $this->assertSame(
            null,
            $dataset->start,
            'Wrong default value for property start in class ezcGraphNumericDataSet'
        );

        $dataset->start = -32.4;
        $this->assertSame(
            -32.4,
            $dataset->start,
            'Setting property value did not work for property start in class ezcGraphNumericDataSet'
        );

        try
        {
            $dataset->start = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testNumericDataSetPropertyEnd()
    {
        $dataset = new ezcGraphNumericDataSet();

        $this->assertSame(
            null,
            $dataset->end,
            'Wrong default value for property end in class ezcGraphNumericDataSet'
        );

        $dataset->end = -32.4;
        $this->assertSame(
            -32.4,
            $dataset->end,
            'Setting property value did not work for property end in class ezcGraphNumericDataSet'
        );

        try
        {
            $dataset->end = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testNumericDataSetPropertyCallback()
    {
        $dataset = new ezcGraphNumericDataSet();

        $this->assertSame(
            null,
            $dataset->callback,
            'Wrong default value for property callback in class ezcGraphNumericDataSet'
        );

        $dataset->callback = 'sin';
        $this->assertSame(
            'sin',
            $dataset->callback,
            'Setting property value did not work for property callback in class ezcGraphNumericDataSet'
        );

        // Use random default enabled public static method
        $dataset->callback = array( 'Reflection', 'export' );
        $this->assertSame(
            array( 'Reflection', 'export' ),
            $dataset->callback,
            'Setting property value did not work for property callback in class ezcGraphNumericDataSet'
        );

        // Use random default enabled public method
        $reflection = new ReflectionClass( 'Exception' );
        $dataset->callback = array( $reflection, 'isInternal' );
        $this->assertSame(
            array( $reflection, 'isInternal' ),
            $dataset->callback,
            'Setting property value did not work for property callback in class ezcGraphNumericDataSet'
        );

        try
        {
            $dataset->callback = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testIterateOverAverageDataset()
    {
        $numericDataSet = new ezcGraphNumericDataSet( -1, 1, 'sin' );

        $stepSize = 2 / 100;
        $start = -1 - $stepSize;

        foreach ( $numericDataSet as $key => $value )
        {
            $expectedKey = $start += $stepSize;
            $expectedValue = sin( $expectedKey );

            $this->assertEquals( $expectedKey, $key, 'Wrong key value.', .01 );
            $this->assertEquals( $expectedValue, $value, 'Wrong value.', .01 );
        }
    }

    public function testIterateOverAverageDataset2()
    {
        $numericDataSet = new ezcGraphNumericDataSet( 
            -90, 
            90, 
            create_function( 
                '$x',
                'return 10 * sin( deg2rad( $x ) );'
            )
        );
        $numericDataSet->resolution = 180;

        $stepSize = 1;
        $start = -91;

        foreach ( $numericDataSet as $key => $value )
        {
            $expectedKey = $start += $stepSize;
            $expectedValue = sin( deg2rad( $expectedKey ) ) * 10;

            $this->assertEquals( $expectedKey, $key, 'Wrong key value.', .01 );
            $this->assertEquals( $expectedValue, $value, 'Wrong value.', .01 );
        }
    }

    public function testRenderCompleteLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphLineChart();
        $chart->data['Sinus'] = new ezcGraphNumericDataSet( 
            -180, 
            180, 
            create_function( 
                '$x',
                'return 10 * sin( deg2rad( $x ) );'
            )
        );
        $chart->data['Cosinus'] = new ezcGraphNumericDataSet( 
            -180, 
            180, 
            create_function( 
                '$x',
                'return 5 * cos( deg2rad( $x ) );'
            )
        );
        $chart->xAxis = new ezcGraphChartElementNumericAxis();

        $chart->render( 500, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}

?>
