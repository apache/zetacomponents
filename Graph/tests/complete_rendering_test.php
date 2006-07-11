<?php
/**
 * ezcGraphCompleteRenderingTest 
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
class ezcGraphCompleteRenderingTest extends ezcTestCase
{

    protected $testFiles = array(
        'png'          => 'png.png',
    );

    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphCompleteRenderingTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( 'ezcGraphGdDriverTest' . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
        // $this->removeTempDir();
    }

    public function testRenderLineChart()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'line' );
        $chart->palette = 'black';

        $chart['Line 1'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart['Line 2'] = array( 'sample 1' => 543, 'sample 2' => 234, 'sample 3' => 298, 'sample 4' => 5, 'sample 5' => 613);

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertEquals(
            '1d586728bba88ddd9a6c18d42449a948',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }

    public function testRenderWithTransparentBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'line' );
        $chart['sampleData'] = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->palette = 'Black';
        $chart->options->backgroundImage = $this->basePath . $this->testFiles['png'];
        $chart->options->background = '#2E343655';

        $chart->driver = new ezcGraphGdDriver();
        $chart->options->font = $this->basePath . 'font.ttf';
        $chart->render( 500, 200, $filename );

        $this->assertTrue(
            file_exists( $filename ),
            'No image was generated.'
        );

        $this->assertEquals(
            '1d586728bba88ddd9a6c18d42449a948',
            md5_file( $filename ),
            'Incorrect image rendered.'
        );
    }
}
?>
