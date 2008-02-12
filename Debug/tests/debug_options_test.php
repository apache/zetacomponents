<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

/**
 * Test suite for the ezcDebugOptions class.
 *
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtor()
    {
        $opts = new ezcDebugOptions();

        $this->assertSame(
            false,
            $opts->stackTrace,
            'Default value for option $stackTrace incorrect.'
        );
        $this->assertSame(
            5,
            $opts->stackTraceDepth,
            'Default value for option $stackTraceDepth incorrect.'
        );
    }

    public function testSetSuccess()
    {
        $opts = new ezcDebugOptions();

        $opts->stackTrace      = true;
        $opts->stackTraceDepth = 100;

        $this->assertSetProperty(
            $opts,
            'stackTrace',
            array( true, false )
        );
        $this->assertSetProperty(
            $opts,
            'stackTraceDepth',
            array( 0, 1, 23 )
        );
    }

    public function testSetFailure()
    {
        $opts = new ezcDebugOptions();

        $this->assertSetPropertyFails(
            $opts,
            'stackTrace',
            array( null, 23, 'foobar', array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'stackTraceDepth',
            array( null, true, -23, 'foobar', array(), new stdClass() )
        );
    }
}
?>
