<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Execution
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require 'test_classes/test_classes.php';

/**
 * @package Execution
 * @subpackage Tests
 */
class ezcExecutionInitDefinition extends ezcTestCase
{
    public function testCleanExitNotInitialized()
    {
        ezcExecution::reset();
        try
        {
            ezcExecution::cleanExit();
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionNotInitializedException $e )
        {
            $this->assertEquals( "The Execution mechanism was not initalized.", $e->getMessage() );
        }
    }

    public function testCallbackExists()
    {
        ezcExecution::reset();
        try
        {
            @ezcExecution::init( 'ezcExecutionDoesNotExist' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionInvalidCallbackException $e )
        {
            $this->assertEquals( "Class <ezcExecutionDoesNotExist> does not exist.", $e->getMessage() );
        }
    }

    public function testAlreadyInitialized()
    {
        ezcExecution::reset();
        try
        {
            ezcExecution::init( 'ExecutionTest2' );
            ezcExecution::init( 'ExecutionTest2' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionAlreadyInitializedException $e )
        {
            $this->assertEquals( "The Execution mechanism is already initalized.", $e->getMessage() );
        }
    }

    public function testReset()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
    }

    public function testInvalidCallbackClass()
    {
        ezcExecution::reset();
        try
        {
            ezcExecution::init( 'ExecutionTest1' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionWrongClassException $e )
        {
            $this->assertEquals( "The class <ExecutionTest1> does not implement the <ezcExecutionErrorHandler> interface.", $e->getMessage() );
        }
    }

    public function testCleanExitInitialized()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
        ezcExecution::cleanExit();
    }

    /**
     * Unfortunately this test is unable to work, because when the uncaught
     * exception would have been run, PHP aborts. So let's leave the test
     * commented out!
     *
    public function testUncaughtException()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ezcExecutionBasicErrorHandler' );
        throw new Exception();
        ezcExecution::reset();
    }
     */

    /**
     * This test would leave a warning when the unit test frameworks ends. As
     * there is no other way of testing this, please leave the test commented
     * out!
     *
    public function testUncleanExit()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ezcExecutionBasicErrorHandler' );
    }
     */

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcExecutionInitDefinition" );
    }
}
?>
