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

        $this->assertProtectedPropertySame( $pieChart, 'title', 'Test title' );
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
    }

    public function testSetRenderer()
    {
        try
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->renderer = new ezcGraphRenderer2D();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }
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
            $pieChart->driver = new ezcGraphGDDriver();
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }
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
