<?php
/**
 * ezcChartTest 
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
class ezcChartTest extends ezcTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

    protected $basePath;

	public static function suite()
	{
		return new ezcTestSuite( "ezcChartTest" );
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

    public function testSetOptionsInvalidBackgroundImage()
    {
        try 
        {
            $pieChart = ezcGraph::create( 'Pie' );
            $pieChart->options->backgroundImage = $this->basePath . $this->testFiles['nonexisting'];
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

    public function test
}
?>
