<?php
/**
 * ezcConsoleToolsStatusindicatorTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleStatusindicator class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsStatusindicatorTest extends ezcTestCase
{

    private $stati = array(
        array( 'UPLOAD', '/var/upload/test.php' ),
        array( 'UPLOAD', '/var/upload/testing.php' ),
        array( 'UPLOAD', '/var/upload/foo.php' ),
        array( 'UPLOAD', '/var/upload/bar.php' ),
        array( 'UPLOAD', '/var/upload/baz.png' ),
        array( 'UPLOAD', '/var/upload/image.jpg' ),
        array( 'UPLOAD', '/var/upload/bar.gif' ),
        array( 'UPLOAD', '/var/upload/ez-logo.jpg' ),
        array( 'UPLOAD', '/var/upload/ez-logo.png' ),
        array( 'UPLOAD', '/var/upload/ez-components.png' ),
    );

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsStatusindicatorTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testStatusindicator1()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleStatusindicator( $out, 10 );
        ob_start();
        for ( $i = 0; $i < 10; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/testStatusindicator1.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        //file_put_contents( dirname( __FILE__ ) . '/data/testStatusindicator1.dat', $res );
    }
    
    public function testStatusindicator2()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleStatusindicator( $out, 7 );
        ob_start();
        for ( $i = 0; $i < 7; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/testStatusindicator2.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/testStatusindicator2.dat', $res );
    }
    
    public function testStatusindicator3()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleStatusindicator( $out, 7, array( 'formatString' => '%2$10s %1$6.2f%% %3$s' ) );
        ob_start();
        for ( $i = 0; $i < 7; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/testStatusindicator3.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/testStatusindicator3.dat', $res );
    }
    
    public function testStatusindicator4()
    {
        $out = new ezcConsoleOutput();
        $out->formats->tag->color = 'red';
        $out->formats->percent->color = 'blue';
        $out->formats->percent->style = array( 'bold' );
        $out->formats->data->color = 'green';

        $status = new ezcConsoleStatusindicator( $out, 7, 
            array( 'formatString' => 
                $out->formatText( '%2$10s', 'tag' ) . ' ' . $out->formatText( '%1$6.2f%%', 'percent' ) . ' ' . $out->formatText( '%3$s', 'data' ) ) );
        ob_start();
        for ( $i = 0; $i < 7; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/testStatusindicator4.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/testStatusindicator4.dat', $res );
    }
}
?>
