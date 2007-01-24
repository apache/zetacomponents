<?php
/**
 * ezcGraphChartTest 
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
class ezcGraphChartTest extends ezcTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

    protected $basePath;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphChartTest" );
	}

    protected function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    public function testSetTitle()
    {
        $pieChart = new ezcGraphPieChart();
        $pieChart->title = 'Test title';

        $this->assertSame(
            'Test title',
            $pieChart->title->title
        );

        $this->assertTrue(
            $pieChart->title instanceof ezcGraphChartElementText
        );
    }

    public function testSetOptionsUnknown()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->options->unknown = 'unknown';
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException' );
    }

    public function testSetRenderer()
    {
        $pieChart = new ezcGraphPieChart();
        $renderer = $pieChart->renderer = new ezcGraphRenderer2d();

        $this->assertSame(
            $renderer,
            $this->getAttribute( $pieChart, 'renderer' )
        );
    }

    public function testSetInvalidRenderer()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->renderer = 'invalid';
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidRendererException' );
    }

    public function testSetDriver()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) && 
             ( ezcBaseFeatures::hasFunction( 'imagefttext' ) || ezcBaseFeatures::hasFunction( 'imagettftext' ) ) )
        {
            $this->markTestSkipped( 'This test needs ext/gd with native ttf support or FreeType 2 support.' );
        }

        $pieChart = new ezcGraphPieChart();
        $driver = $pieChart->driver = new ezcGraphGdDriver();

        $this->assertSame(
            $driver,
            $this->getAttribute( $pieChart, 'driver' )
        );
    }

    public function testSetInvalidDriver()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->driver = 'invalid';
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDriverException' );
    }

    public function testPieChartWithoutData()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->render( 400, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }
    }

    public function testBarChartWithoutData()
    {
        try
        {
            $pieChart = new ezcGraphPieChart();
            $pieChart->render( 400, 200 );
        }
        catch ( ezcGraphNoDataException $e )
        {
            return true;
        }
    }
}
?>
