<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PhpGenerator
 * @subpackage Tests
 */

/**
 * @package PhpGenerator
 * @subpackage Tests
 */
class ezcPhpGeneratorTest extends ezcTestCase
{
    /**
     * Make sure the result file is removed after each run.
     */
    protected function tearDown()
    {
        if ( file_exists( dirname( __FILE__ ) . '/data/generator_test.php' ) )
        {
            unlink( dirname( __FILE__ ) . '/data/generator_test.php' );
        }
    }

    /**
     * Tests appendVariable with a normal assignment: =
     */
    public function testAppendAssignment()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 42 );
        $generator->appendCustomCode( 'return $test;' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 42, eval( $data ) );
    }

    /**
     * Tests appendVariable with a text append assignemnt: .=
     */
    public function testAppendAssignmentText()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 'Darth' );
        $generator->appendValueAssignment( 'test', ' Vader', ezcPhpGenerator::ASSIGN_APPEND_TEXT );
        $generator->appendCustomCode( 'return $test;' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 'Darth Vader', eval( $data ) );
    }

    /**
     * Tests appendVariable with an add assignemnt: +=
     */
    public function testAppendAssignmentAdd()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 41 );
        $generator->appendValueAssignment( 'test', 1, ezcPhpGenerator::ASSIGN_ADD );
        $generator->appendCustomCode( 'return $test;' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 42, eval( $data ) );
    }

    /**
     * Tests appendVariable with an add assignemnt: -=
     */
    public function testAppendAssignmentSubtract()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 43 );
        $generator->appendValueAssignment( 'test', 1, ezcPhpGenerator::ASSIGN_SUBTRACT );
        $generator->appendCustomCode( 'return $test;' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 42, eval( $data ) );
    }

    /**
     * Tests appendVariable with an add assignemnt: [] =
     */
    public function testAppendAssignmentArray()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', array( 1, 2 ) );
        $generator->appendValueAssignment( 'test', 3, ezcPhpGenerator::ASSIGN_ARRAY_APPEND );
        $generator->appendCustomCode( 'return $test;' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( array( 1, 2, 3 ), eval( $data ) );
    }

    /**
     * Tests unsetting a variable
     */
    public function testAppendUnset()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 42 );
        $generator->appendUnset( 'test' );
        $generator->appendCustomCode( 'return isset( $test );' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( false, eval( $data ) );
    }

    /**
     * Tests unsetting several values
     */
    public function testAppendUnsetList()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendValueAssignment( 'test', 42 );
        $generator->appendValueAssignment( 'test2', 99 );
        $generator->appendUnsetList( array( 'test', 'test2') );
        $generator->appendCustomCode( 'return (isset( $test ) || isset( $test2 ));' . $generator->lineBreak );
        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( false, eval( $data ) );
    }


    /**
     * Tests that the generator fails if conditions are not properly nested.
     */
    public function testWrongConditionNesting()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendIf( 'true' );
        $generator->appendCustomCode( 'return true;' . $generator->lineBreak );
        try
        {
            $generator->appendEndForeach();
        }
        catch ( ezcPhpGeneratorFlowException $e )
        {
            return;
        }
        $this->fail( "Expected exception" );
        unset($generator);
    }

    /**
     * Tests the if construction
     */
    public function testAppendIf()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendIf( 'true' );
        $generator->appendCustomCode( 'return true;' . $generator->lineBreak );
        $generator->appendEndIf();
        $generator->appendCustomCode( 'return false;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( true, eval( $data ) );
        unset( $generator );
    }

    /**
     * Tests the else construction with condition
     */
    public function testAppendConditoinedElse()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendIf( 'false' );
        $generator->appendCustomCode( 'return false;' );
        $generator->appendElse( 'true' );
        $generator->appendCustomCode( 'return true;' );
        $generator->appendEndIf();
        $generator->appendCustomCode( 'return false;' );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( true, eval( $data ) );
    }

    /**
     * Tests the else construction without a condition
     */
    public function testAppendUnconditoinedElse()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );
        $generator->appendIf( 'false' );
        $generator->appendCustomCode( 'return false;' . $generator->lineBreak );
        $generator->appendElse( );
        $generator->appendCustomCode( 'return true;' . $generator->lineBreak );
        $generator->appendEndIf();
        $generator->appendCustomCode( 'return false;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( true, eval( $data ) );
    }

    /**
     * Tests the if construction
     */
    public function testAppendForeach()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false, true );

        $generator->appendValueAssignment( 'items', array( 1, 2, 3 ) );
        $generator->appendValueAssignment( 'counter', 0 );
        $generator->appendForeach( '$items as $item' );
        $generator->appendVariableAssignment( 'counter', 'item', ezcPhpGenerator::ASSIGN_ADD );
        $generator->appendEndForeach();
        $generator->appendCustomCode( 'return $counter;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 6, eval( $data ) );
    }

    /**
     * Tests the while construction
     */
    public function testAppendWhile()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'counter', 0 );
        $generator->appendWhile( '$counter < 3' );
        $generator->appendValueAssignment( 'counter', 1, ezcPhpGenerator::ASSIGN_ADD );
        $generator->appendEndWhile();
        $generator->appendCustomCode( 'return $counter;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 3, eval( $data ) );
    }

    /**
     * Tests the do construction
     */
    public function testAppendDo()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'counter', 0 );
        $generator->appendDo();
        $generator->appendValueAssignment( 'counter', 1, ezcPhpGenerator::ASSIGN_ADD );
        $generator->appendEndDo( '$counter < 3' );
        $generator->appendCustomCode( 'return $counter;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 3, eval( $data ) );
    }


    /**
     * Make sure that the implementation cleans up after itself even in the case
     * of an abort.
     */
    public function testCleanupAfterError()
    {
        try
        {
            $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php' );
            $generator->appendEndIf();
        }
        catch ( ezcPhpGeneratorException $e )
        {
            // eat
        }
        $this->assertLeftOverFiles();
    }

    /**
     * Tests if appendInclude works with case insensitive
     */
    public function testAppendDefineCaseSensitive()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendDefine( 'GRETZKY', 99 );
        $generator->appendIf( "@defined( 'gretzky' )" );
        $generator->appendCustomCode( 'return 0;' );
        $generator->appendEndIf();
        $generator->appendCustomCode( 'return GRETZKY;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 99, eval( $data ) );
    }

    /**
     * Tests if appendInclude works when case sensitive
     */
    public function testAppendDefineCaseInsensitive()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendDefine( 'GRETZKY', 99, true );
        $generator->appendCustomCode( 'return gretzky;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 99, eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with no result type
     */
    public function testAppendFunctionCall()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88_lindros' );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendCustomCode( 'return ' );
        $generator->appendFunctionCall( 'strstr', $parameters );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( '88_lindros', eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result without a type.
     */
    public function testAppendFunctionCallWithResult()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88_lindros' );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters, new ezcPhpGeneratorReturnData( 'data' ) );
        $generator->appendCustomCode( 'return $data;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( '88_lindros', eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result with type NORMAL
     */
    public function testAppendFunctionCallWithResultNORMAL()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88_lindros' );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters,
                                        new ezcPhpGeneratorReturnData( 'data', ezcPhpGenerator::ASSIGN_NORMAL )  );
        $generator->appendCustomCode( 'return $data;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( '88_lindros', eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result with type APPEND_TEXT
     */
    public function testAppendFunctionCallWithResultAPPENDTEXT()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88' );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters,
                                        new ezcPhpGeneratorReturnData( 'data', ezcPhpGenerator::ASSIGN_APPEND_TEXT ) );
        $generator->appendCustomCode( 'return $data;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 'eric_8888', eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result with type ADD
     */
    public function testAppendFunctionCallWithResultADD()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88' );
        $generator->appendValueAssignment( 'result', -88 );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters,
                                        new ezcPhpGeneratorReturnData( 'result', ezcPhpGenerator::ASSIGN_ADD ) );
        $generator->appendCustomCode( 'return $result;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 0, eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result with type SUBRACT
     */
    public function testAppendFunctionCallWithResultSUBTRACT()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88' );
        $generator->appendValueAssignment( 'result', 88 );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters,
                                        new ezcPhpGeneratorReturnData( 'result', ezcPhpGenerator::ASSIGN_SUBTRACT ) );
        $generator->appendCustomCode( 'return $result;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( 0, eval( $data ) );
    }

    /**
     * Tests if appendFunctionCall works with a result with type ARRAYAPPEND
     */
    public function testAppendFunctionCallWithResultARRAYAPPEND()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendValueAssignment( 'data', 'eric_88' );
        $parameters[] = new ezcPhpGeneratorParameter( 'data', ezcPhpGeneratorParameter::VARIABLE );
        $parameters[] = new ezcPhpGeneratorParameter( '88', ezcPhpGeneratorParameter::VALUE );
        $generator->appendFunctionCall( 'strstr', $parameters,
                                        new ezcPhpGeneratorReturnData( 'result', ezcPhpGenerator::ASSIGN_ARRAY_APPEND ) );
        $generator->appendCustomCode( 'return $result;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( array( '88' ), eval( $data ) );
    }

    /**
     * Tests if appendMethodCall works. It uses the same codebase as appendFunctionCall
     * so we only test that it works at all.
     */
    public function testAppendMethodCall()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false );

        $generator->appendCustomCode( "class TestClass{\n public function hello() { return 'hello'; }}" );
        $generator->appendCustomCode( "\$object = new TestClass();" );
        $generator->appendMethodCall( 'object', 'hello', array(), new ezcPhpGeneratorReturnData( 'result' ) );
        $generator->appendCustomCode( 'return $result;' . $generator->lineBreak );

        $generator->finish();
        $data = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $this->assertEquals( "hello", eval( $data ) );
    }

    public function testNiceIndent()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false, true );
        $generator->lineBreak =  "\r\n";
        $generator->appendIf( 'true' );
        {
            $generator->appendForeach( '$counter as $count' );
            {
                $generator->appendWhile( 'false' );
                {
                    $generator->appendDo();
                    {
                        $generator->appendCustomCode( 'return true;' );
                    }
                    $generator->appendEndDo( 'false' );
                }
                $generator->appendEndWhile();
            }
            $generator->appendEndForeach();
        }
        $generator->appendElse( 'true' );
        $generator->appendCustomCode( 'return true;' );
        $generator->appendEndIf();
        $generator->finish();
        $genData = file_get_contents( dirname( __FILE__ ) . '/data/generator_test.php' );
        $storeData = file_get_contents( dirname( __FILE__ ) . '/data/indent_test.data' );
        $this->assertEquals( $storeData, $genData );
    }

    /**
     * Tests to write after a file is completed. An exception should be thrown.
     */
    public function testWriteAfterFinish()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false, true );
        $generator->finish();
        try
        {
            $generator->appendIf( 'true' );
        }
        catch ( ezcBaseFileIoException $e )
        {
            // eat, this is expected.
            return;
        }
        $this->fail( "Writer after call to finish() without getting an exception" );
    }

    /**
     * Tests to finish a file with improper nesting. An exception should be thrown.
     */
    public function testFinishWithImproperNesting()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/generator_test.php', false, true );
        $generator->appendIf( '$brush == true' );
        try
        {
            $generator->finish();
        }
        catch ( ezcPhpGeneratorException $e )
        {
            // eat, this is expected.
            return;
        }
        $this->fail( "Finished file with improper nesting without getting an exception." );
    }

    /**
     * Throws an error if there were temp files left.
     */
    public function assertLeftOverFiles()
    {
        // if this test fails, make sure the file is not left over by some other test first!
        if ( $this->countFiles( dirname( __FILE__ ) . '/data/', 'generator_test.php' ) != 0 )
        {
            $this->fail( "There were left over files in '". dirname( __FILE__ ) ."/data/' after the operation completed" );
        }
    }

    /**
     * Returns the number of files containing $match in their filename in $dir
     */
    public function countFiles( $dir, $match )
    {
        $count = 0;
        if ( is_dir( $dir ) )
        {
            if ( $dh = opendir( $dir ) )
            {
                while ( ( $file = readdir( $dh ) ) !== false )
                {
                    if ( strstr( $file, $match ) !== false ) ++$count;
                }
                closedir($dh);
            }
        }
        return $count;
    }

    /**
     * Tests writing to a dir that does not exist or without
     * write permissions.
     */
    public function testWriteToFaultyDir()
    {
        try
        {
            @$generator = new ezcPhpGenerator( "/no/such/path/or_file.php" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return;
        }
        $this->fail( "Writing to a dir that does not exist did not fail." );
    }

    // test for issue #15870: Incorrect error handling in
    // ezcPhpGenerator::finish() (with patch)
    public function testWriteToDir()
    {
        @mkdir( "/tmp/ezcPhpGenerator" );
        try
        {
            $generator = new ezcPhpGenerator( "/tmp/ezcPhpGenerator" );
            $generator->finish();

            rmdir( "/tmp/ezcPhpGenerator" );
            $this->fail( "Writing to a dir that does not exist did not fail." );
        }
        catch ( ezcPhpGeneratorException $e )
        {
            $this->assertEquals( "ezcPhpGenerator could not open the file '/tmp/ezcPhpGenerator' for writing.", $e->getMessage() );
        }
        rmdir( "/tmp/ezcPhpGenerator" );
    }

    // if this test fails and needs to be changed,
    // you need to change the class example in PhpGenerator
    public function testExample()
    {
        $generator = new ezcPhpGenerator( dirname( __FILE__ ) . '/data/fibo.php', true, true );
        $generator->appendCustomCode( 'function fibonacci( $number )' );
        $generator->appendCustomCode( "{" );

        $generator->appendValueAssignment( "lo", 0 );
        $generator->appendValueAssignment( "hi", 1 );
        $generator->appendValueAssignment( "i", 2 );

        $generator->appendWhile( '$i < $number' );
        $generator->appendCustomCode( '$hi = $lo + $hi;' );
        $generator->appendCustomCode( '$lo = $hi - $lo;' );
        $generator->appendCustomCode( '$i++;' );
        $generator->appendEndWhile();
        $generator->appendCustomCode( 'return $hi;' );
        $generator->appendCustomCode( "}" );
        $generator->finish();
        require( dirname( __FILE__ ) . '/data/fibo.php' );
        $this->assertEquals( 34, fibonacci( 10 ) );
        unlink( dirname( __FILE__ ) . '/data/fibo.php' );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcPhpGeneratorTest" );
    }
}
?>
