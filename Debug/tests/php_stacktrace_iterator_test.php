<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcDebugPhpStacktraceIteratorTest extends ezcTestCase
{
    private function getStackTrace( $foo, $bar = null )
    {
        return $this->getDeeperStackTrace( $foo, $bar );
    }

    private function getDeeperStackTrace( $foo, $bar )
    {
        return debug_backtrace();
    }
    
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testIterateTrace()
    {
        $stackTrace = $this->getStackTrace( 'some string', array( true, 23, null ) );
        array_splice( $stackTrace, 3 );

        $opts = new ezcDebugOptions();
        $itr = new ezcDebugPhpStacktraceIterator(
            $stackTrace,
            0,
            $opts
        );
        
        $res = require 'data/php_stacktrace_iterator_test__testSimpleTrace.php';
        foreach ( $itr as $key => $value )
        {

// @todo: Weird PHP bug: There is no 'file' key in one of the stack elements.
//            $this->assertTrue(
//                isset( $value['file'] )
//            );

            // Remove 'file' keys to not store system dependant pathes.
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
        $itr = new ezcDebugPhpStacktraceIterator(
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
        $itr = new ezcDebugPhpStacktraceIterator(
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
