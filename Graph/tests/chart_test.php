<?php
/**
 * ezcGraphChartTest 
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
		return new ezcTestSuite( "ezcGraphChartTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testSetTitle()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $pieChart->title = 'Test title';

        $this->assertSame(
            'Test title',
            $pieChart->title->title
        );

        $this->assertTrue(
            $pieChart->title instanceof ezcGraphChartElementText
        );
    }

    public function testSetOptionsValidBackgroundImage()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $pieChart->options->backgroundImage = $this->basePath . $this->testFiles['jpeg'];

        $background = $this->getNonPublicProperty( $pieChart->options, 'backgroundImage' );
        $this->assertTrue(
            $background instanceof ezcGraphChartElementBackgroundImage,
            'Background is not an ezcGraphChartElementBackgroundImage.'
        );

        $this->assertSame( $this->basePath . $this->testFiles['jpeg'], $this->getNonPublicProperty( $background, 'source' ) );
    }

    public function testSetOptionsInvalidBackgroundImage()
    {
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->backgroundImage = $this->basePath . $this->testFiles['invalid'];
        } 
        catch ( ezcGraphInvalidImageFileException $e ) 
        {
            return true;
        } 

        $this->fail( 'Expected ezcGraphInvalidImageFileException' );
    }

    public function testSetOptionsNonexistantBackgroundImage()
    {
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->backgroundImage = $this->basePath . $this->testFiles['nonexistant'];
        } 
        catch ( ezcBaseFileNotFoundException $e ) 
        {
            return true;
        } 

        $this->fail( 'Expected ezcBaseFileNotFoundException' );
    }

    public function testSetOptionsBackground()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $pieChart->options->background = '#FF0000';

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $this->getNonPublicProperty( $pieChart->options, 'background' )
        );
    }

    public function testSetOptionsBorder()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $pieChart->options->border = '#FF0000';

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $this->getNonPublicProperty( $pieChart->options, 'border' )
        );
    }

    public function testSetOptionsBorderWidth()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $pieChart->options->borderWidth = 3;

        $this->assertSame( 3, $this->getNonPublicProperty( $pieChart->options, 'borderWidth' ) );
    }

    public function testSetOptionsUnknown()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
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
        $pieChart = ezcGraph::create( 'Pie' );
        $renderer = $pieChart->renderer = new ezcGraphRenderer2D();

        $this->assertSame(
            $renderer,
            $this->getNonPublicProperty( $pieChart, 'renderer' )
        );
    }

    public function testSetInvalidRenderer()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->renderer = 'invalid';
        }
        catch ( ezcGraphInvalidRendererException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidRendererException' );
    }

    public function testSetDriver()
    {
        $pieChart = ezcGraph::create( 'Pie' );
        $driver = $pieChart->driver = new ezcGraphGdDriver();

        $this->assertSame(
            $driver,
            $this->getNonPublicProperty( $pieChart, 'driver' )
        );
    }

    public function testSetInvalidDriver()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->driver = 'invalid';
        }
        catch ( ezcGraphInvalidDriverException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidDriverException' );
    }
}
?>
