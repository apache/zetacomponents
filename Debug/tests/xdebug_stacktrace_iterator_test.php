<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require_once 'classes/debug_test_dump_extended_object.php';

/**
 * Test suite for the ezcDebugOptions class.
 *
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugXdebugStacktraceIteratorTest extends ezcTestCase
{
    private function getStackTrace( $foo, $bar = null )
    {
        return $this->getDeeperStackTrace( $foo, $bar );
    }

    private function getDeeperStackTrace( $foo, $bar )
    {
        return xdebug_get_function_stack();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setup()
    {
        if ( !extension_loaded( 'xdebug' ) )
        {
            $this->markTestSkipped( 'Only run when Xdebug is available.' );
        }
    }

    public function testIterateTrace()
    {
        $stackTrace = $this->getStackTrace( 'some string', array( true, 23, null ) );
        array_splice( $stackTrace, 0, -3 );

        $opts = new ezcDebugOptions();
        $itr = new ezcDebugXdebugStacktraceIterator(
            $stackTrace,
            0,
            $opts
        );

        $res = require 'data/xdebug_stacktrace_iterator_test__testSimpleTrace.php';
        foreach ( $itr as $key => $value )
        {
            // Remove 'file' keys to not store system dependant pathes.
            $this->assertTrue(
                isset( $value['file'] )
            );
            unset( $value['file'] );

            $this->assertEquals(
                $res[$key],
                $value,
                "Incorrect stack element $key."
            );
        }
    }

    public function testCountTrace()
    {
        $opts = new ezcDebugOptions();
        $itr = new ezcDebugXdebugStacktraceIterator(
            $this->getStackTrace( 'some string', array( true, 23, null ) ),
            0,
            $opts
        );
        
        $this->assertEquals(
            5,
            count( $itr )
        );
    }
    
    public function testArrayAccess()
    {
        $opts = new ezcDebugOptions();
        $itr = new ezcDebugXdebugStacktraceIterator(
            $this->getStackTrace( 'some string', array( true, 23, null ) ),
            0,
            $opts
        );

        $this->assertTrue(
            isset( $itr[0] )
        );

        $this->assertTrue(
            is_array( $itr[0] )
        );

        try
        {
            $itr[0] = true;
            $this->fail( 'Exception not throwen on not permitted array access.' );
        }
        catch ( ezcDebugOperationNotPermittedException $e ) {}

    }
}

?>
