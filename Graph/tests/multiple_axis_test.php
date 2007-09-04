<?php
/**
 * ezcGraphLineChartTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphMultipleAxisTest extends ezcTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphMultipleAxisTest" );
	}

    protected function setUp()
    {
        static $i = 0;

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testLineChartOptionsPropertyAdditionalAxis()
    {
        $options = new ezcGraphLineChartOptions();

        $this->assertEquals(
            new ezcGraphAxisContainer(),
            $options->additionalAxis,
            'Wrong default value for property additionalAxis in class ezcGraphLineChartOptions'
        );

        $options->additionalAxis = $new = new ezcGraphAxisContainer;
        $this->assertSame(
            $new,
            $options->additionalAxis,
            'Setting property value did not work for property additionalAxis in class ezcGraphLineChartOptions'
        );

        try
        {
            $options->additionalAxis = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testAxisContainerIterator()
    {
        $options = new ezcGraphLineChartOptions();

        $axis = array();

        $options->additionalAxis[] = $axis[] = new ezcGraphChartElementNumericAxis();
        $options->additionalAxis[] = $axis[] = new ezcGraphChartElementNumericAxis();
        $options->additionalAxis['foo'] = $axis['foo'] = new ezcGraphChartElementLabeledAxis();

        foreach ( $options->additionalAxis as $key => $value )
        {
            $this->assertTrue(
                array_key_exists( $key, $axis ),
                "Expecteded key '$key' in both arrays."
            );

            $this->assertSame(
                $axis[$key],
                $value,
                "Value should be the same for key '$key'."
            );
        }
    }

    public function testAddAdditionalAxisToChart()
    {
        $chart = new ezcGraphLineChart();

        $this->assertTrue(
            $chart->options->additionalAxis instanceof ezcGraphAxisContainer,
            'Line chart option additionalAxis should be of ezcGraphAxisContainer.'
        );

        $this->assertSame(
            count( $chart->options->additionalAxis ),
            0,
            'The initial count of additional axis should be zero.'
        );

        $chart->options->additionalAxis[] = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            count( $chart->options->additionalAxis ),
            1,
            'The count of additional axis should be one.'
        );

        $chart->options->additionalAxis[] = new ezcGraphChartElementLabeledAxis();

        $this->assertSame(
            count( $chart->options->additionalAxis ),
            2,
            'The count of additional axis should be two.'
        );

        try
        {
            $chart->options->additionalAxis[] = $chart;
        }
        catch( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
