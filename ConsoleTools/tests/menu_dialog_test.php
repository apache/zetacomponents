<?php
/**
 * ezcConsoleMenuDialogTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require generic test class for ezcConsoleDialog implementations.
 */
require_once dirname( __FILE__ ) . "/dialog_test.php";

/**
 * Test suite for ezcConsoleToolsMenuDialog class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleMenuDialogTest extends ezcConsoleDialogTest
{

	public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleMenuDialogTest" );
    }

    public function testGetAccessSuccess()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );
        
        $this->assertSame( $output, $dialog->output );
        $this->assertEquals( new ezcConsoleMenuDialogOptions(), $dialog->options );
    }

    public function testGetAccessFailure()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );
        
        $exceptionCaught = false;
        try
        {
            echo $dialog->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on access of nonexistent property foo." );
    }

    public function testSetAccessSuccess()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );

        $outputNew  = new ezcConsoleOutput();
        $optionsNew = new ezcConsoleMenuDialogOptions();

        $dialog->output  = $outputNew;
        $dialog->options = $optionsNew;

        $this->assertSame( $outputNew, $dialog->output );
        $this->assertSame( $optionsNew, $dialog->options );
    }
    
    public function testSetAccessFailure()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );
       
        $exceptionCaught = false;
        try
        {
            $dialog->output = "Foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for output." );
       
        $exceptionCaught = false;
        try
        {
            $dialog->options = "Foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for options." );
        
        $exceptionCaught = false;
        try
        {
            $dialog->foo = "bar";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on access of nonexistent property foo." );
        
        $this->assertSame( $output, $dialog->output );
        $this->assertEquals( new ezcConsoleMenuDialogOptions(), $dialog->options );
    }

    public function testIssetAccess()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );
        
        $this->assertTrue( isset( $dialog->options ), "Property options is not set." );
        $this->assertTrue( isset( $dialog->output ), "Property options is not set." );
        $this->assertFalse( isset( $dialog->foo ), "Property foo is set." );
    }

    public function testBasicMethods()
    {
        $output = new ezcConsoleOutput();
        $dialog = new ezcConsoleMenuDialog( $output );

        $this->assertFalse( $dialog->hasValidResult(), "Fresh dialog has valid result." );

        $exceptionCaught = false;
        try
        {
            $dialog->getResult();
        }
        catch ( ezcConsoleNoValidDialogResultException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Excption not thrown on getResult() without result." );

        $dialog->reset();

        $exceptionCaught = false;
        try
        {
            $dialog->getResult();
        }
        catch ( ezcConsoleNoValidDialogResultException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Excption not thrown on getResult() without result." );
    }

    public function testDialog1()
    {
        $this->runDialog( __METHOD__ );

        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "K\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "Z\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        // $this->saveDialogResult( __METHOD__, $res );
        $this->assertEquals( $this->res, $res );
    }

    public function testDialog2()
    {
        $this->runDialog( __METHOD__ );

        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "k\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "z\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        // $this->saveDialogResult( __METHOD__, $res );
        $this->assertEquals( $this->res, $res );
    }

    public function testDialog3()
    {
        $this->runDialog( __METHOD__ );

        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "A\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "K\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "B\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "T\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "Z\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        //$this->saveDialogResult( __METHOD__, $res );
        $this->assertEquals( $this->res, $res );
    }

    public function testDialog4()
    {
        $this->runDialog( __METHOD__ );

        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "A\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fputs( $this->pipes[0], "K\n" );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        fclose( $this->pipes[0] );
        $res[] = $this->readPipe( $this->pipes[1] );
        
        // $this->saveDialogResult( __METHOD__, $res );
        $this->assertEquals( $this->res, $res );
    }
}

?>
