<?php
/**
 * ezcGraphBackgroundImageTest 
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
class ezcGraphBackgroundImageTest extends ezcTestCase
{

    protected $testFiles = array(
        'png'          => 'png.png',
    );

    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphBackgroundImageTest" );
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
        $this->removeTempDir();
    }

    public function testRenderStandard()
    {
        $chart = ezcGraph::create( 'line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->options->backgroundImage = $this->basePath . $this->testFiles['png'];
        $chart->options->background = '#000000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackgroundImage',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBackgroundImage' )
            ->with(
                $this->equalTo( $this->basePath . $this->testFiles['png'] ),
                $this->equalTo( new ezcGraphCoordinate( 162, 50 ) ),
                $this->equalTo( 177 ),
                $this->equalTo( 100 )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 500, 200 );
    }

    public function testRenderPieBottomRight()
    {
        $chart = ezcGraph::create( 'pie' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->options->backgroundImage = $this->basePath . $this->testFiles['png'];
        $chart->options->backgroundImage->position = ezcGraph::BOTTOM | ezcGraph::RIGHT;
        $chart->options->background = '#000000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackgroundImage',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBackgroundImage' )
            ->with(
                $this->equalTo( $this->basePath . $this->testFiles['png'] ),
                $this->equalTo( new ezcGraphCoordinate( 323, 100 ) ),
                $this->equalTo( 177 ),
                $this->equalTo( 100 )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 500, 200 );
    }

    public function testRenderTop()
    {
        $chart = ezcGraph::create( 'line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->options->backgroundImage = $this->basePath . $this->testFiles['png'];
        $chart->options->backgroundImage->position = ezcGraph::TOP;
        $chart->options->background = '#000000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackgroundImage',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBackgroundImage' )
            ->with(
                $this->equalTo( $this->basePath . $this->testFiles['png'] ),
                $this->equalTo( new ezcGraphCoordinate( 162, 0 ) ),
                $this->equalTo( 177 ),
                $this->equalTo( 100 )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 500, 200 );
    }

    public function testRenderLeft()
    {
        $chart = ezcGraph::create( 'line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
        $chart->options->backgroundImage = $this->basePath . $this->testFiles['png'];
        $chart->options->backgroundImage->position = ezcGraph::LEFT;
        $chart->options->background = '#000000FF';

        $mockedRenderer = $this->getMock( 'ezcGraphRenderer2D', array(
            'drawBackgroundImage',
        ) );

        $mockedRenderer
            ->expects( $this->at( 0 ) )
            ->method( 'drawBackgroundImage' )
            ->with(
                $this->equalTo( $this->basePath . $this->testFiles['png'] ),
                $this->equalTo( new ezcGraphCoordinate( 0, 50 ) ),
                $this->equalTo( 177 ),
                $this->equalTo( 100 )
            );

        $chart->renderer = $mockedRenderer;
        $chart->render( 500, 200 );
    }

    public function testRenderWithTransparentBackground()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.png';

        $chart = ezcGraph::create( 'line' );
        $chart->sampleData = array( 'sample 1' => 234, 'sample 2' => 21, 'sample 3' => 324, 'sample 4' => 120, 'sample 5' => 1);
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
