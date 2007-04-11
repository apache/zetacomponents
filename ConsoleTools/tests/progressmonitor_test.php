<?php
/**
 * ezcConsoleToolsProgressMonitorTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleProgressMonitor class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsProgressMonitorTest extends ezcTestCase
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
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsProgressMonitorTest" );
	}

    public function testProgressMonitor1()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleProgressMonitor( $out, 10 );
        ob_start();
        for ( $i = 0; $i < 10; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor1.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        //file_put_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor1.dat', $res );
    }
    
    public function testProgressMonitor2()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleProgressMonitor( $out, 7 );
        ob_start();
        for ( $i = 0; $i < 7; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor2.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor2.dat', $res );
    }
    
    public function testProgressMonitor3()
    {
        $out = new ezcConsoleOutput();
        $status = new ezcConsoleProgressMonitor( $out, 7, array( 'formatString' => '%2$10s %1$6.2f%% %3$s' ) );
        ob_start();
        for ( $i = 0; $i < 7; $i++ )
        {
            $status->addEntry( $this->stati[$i][0], $this->stati[$i][1] );
        }
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor3.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor3.dat', $res );
    }
    
    public function testProgressMonitor4()
    {
        $out = new ezcConsoleOutput();
        $out->formats->tag->color = 'red';
        $out->formats->percent->color = 'blue';
        $out->formats->percent->style = array( 'bold' );
        $out->formats->data->color = 'green';

        $status = new ezcConsoleProgressMonitor( $out, 7, 
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
            file_get_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor4.dat' ),
            $res,
            "Formated statusbar not generated correctly."
        );
        // To prepare test files use this:
        // file_put_contents( dirname( __FILE__ ) . '/data/' . ( ezcBaseFeatures::os() === "Windows" ? "windows/" : "posix/" ) . 'testProgressMonitor4.dat', $res );
    }
}
?>
