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
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->title = 'Test title';
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            'Test title',
            $this->getNonPublicProperty( $pieChart, 'title' )
        );
    }

    public function testSetOptionsValidBackgroundImage()
    {
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->backgroundImage = $this->basePath . $this->testFiles['jpeg'];
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertProtectedPropertySame( $pieChart->options, 'backgroundImage', $this->basePath . $this->testFiles['jpeg'] );
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
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
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
        catch ( ezcGraphFileNotFoundException $e ) 
        {
            return true;
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphFileNotFoundException' );
    }

    public function testSetOptionsBackground()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->background = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $this->getNonPublicProperty( $pieChart->options, 'background' )
        );
    }

    public function testSetOptionsBorder()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->border = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals( 
            ezcGraphColor::fromHex( 'FF0000' ),
            $this->getNonPublicProperty( $pieChart->options, 'border' )
        );
    }

    public function testSetOptionsBorderWidth()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->borderWidth = 3;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertProtectedPropertySame( $pieChart->options, 'borderWidth', 3 );
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
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException' );
    }

    public function testSetRenderer()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $renderer = $pieChart->renderer = new ezcGraphRenderer2D();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

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
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphInvalidRendererException' );
    }

    public function testSetDriver()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $driver = $pieChart->driver = new ezcGraphGDDriver();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

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
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphInvalidDriverException' );
    }

    public function testRender()
    {
        $this->fail( '@TODO: Implement renderer tests.' );
    }
}
?>
