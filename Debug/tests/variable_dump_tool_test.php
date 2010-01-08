<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcDebugVariableDumpToolTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testDumpBoolean()
    {
        $true  = true;
        $false = false;

        $this->assertEquals(
            'TRUE',
            ezcDebugVariableDumpTool::dumpVariable( $true, 512, 128, 3 )
        );
        $this->assertEquals(
            'FALSE',
            ezcDebugVariableDumpTool::dumpVariable( $false, 512, 128, 3 )
        );
    }

    public function testDumpInteger()
    {
        $a = 0;
        $b = 23;
        $c = -42;
        
        $this->assertEquals(
            '0',
            ezcDebugVariableDumpTool::dumpVariable( $a, 512, 128, 3 )
        );
        $this->assertEquals(
            '23',
            ezcDebugVariableDumpTool::dumpVariable( $b, 512, 128, 3 )
        );
        $this->assertEquals(
            '-42',
            ezcDebugVariableDumpTool::dumpVariable( $c, 512, 128, 3 )
        );
    }

    public function testDumpDouble()
    {
        $a = 0.0;
        $b = 23.0;
        $c = -42.0;
        $d = 23.42;
        $e = -42.23;
        
        $this->assertEquals(
            '0',
            ezcDebugVariableDumpTool::dumpVariable( $a, 512, 128, 3 )
        );
        $this->assertEquals(
            '23',
            ezcDebugVariableDumpTool::dumpVariable( $b, 512, 128, 3 )
        );
        $this->assertEquals(
            '-42',
            ezcDebugVariableDumpTool::dumpVariable( $c, 512, 128, 3 )
        );
        $this->assertEquals(
            '23.42',
            ezcDebugVariableDumpTool::dumpVariable( $d, 512, 128, 3 )
        );
        $this->assertEquals(
            '-42.23',
            ezcDebugVariableDumpTool::dumpVariable( $e, 512, 128, 3 )
        );
    }

    public function testDumpString()
    {
        $a = 'foo';
        $b = '';

        $this->assertEquals(
            "'foo'",
            ezcDebugVariableDumpTool::dumpVariable( $a, 512, 128, 3 )
        );
        $this->assertEquals(
            "''",
            ezcDebugVariableDumpTool::dumpVariable( $b, 512, 128, 3 )
        );
    }

    public function testDumpSimpleArray()
    {
        $arr = array(
            23, 42.23, true, false, 'test', 'foo bar baz'
        );

        $res = <<<EOT
array (0 => 23, 1 => 42.23, 2 => TRUE, 3 => FALSE, 4 => 'test', 5 => 'foo bar baz')
EOT;
        $this->assertEquals(
            $res,
            ezcDebugVariableDumpTool::dumpVariable( $arr, 512, 128, 3 )
        );
    }

    public function testDumpComplexArray()
    {
        $arr = array(
            23,
            'foo bar' => array(
                1 => '293',
                234223,
                'foo' => array(
                    1, 2, 3, 4, 5, array(), 8 => 23, 'foo', array( 23, 42 )
                ),
            ),
            42.23,
            'a' => true,
            'd' => false,
            23 => 'test',
            'foo bar baz',
        );

        $res = <<<EOT
array (0 => 23, 'foo bar' => array (1 => '293', 2 => 234223, 'foo' => array (0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => array (...), 8 => 23, 9 => 'foo', 10 => array (...))), 1 => 42.23, 'a' => TRUE, 'd' => FALSE, 23 => 'test', 24 => 'foo bar baz')
EOT;
        $this->assertEquals(
            $res,
            ezcDebugVariableDumpTool::dumpVariable( $arr, 512, 128, 3 )
        );
    }

    public function testDumpSimpleObject()
    {
        $obj = new DebugTestDumpObject( 23, 42.23, 'foo bar baz' );

        $res = <<<EOT
class DebugTestDumpObject { private \$private = 23; protected \$protected = 42.23; public \$public = 'foo bar baz' }
EOT;

        $this->assertEquals(
            $res,
            ezcDebugVariableDumpTool::dumpVariable( $obj, 512, 128, 3 )
        );
    }

    public function testDumpExtendedObject()
    {
        $obj = new DebugTestDumpExtendedObject( 23, 42.23, 'foo bar baz', 42, true, false );

        $res = <<<EOT
class DebugTestDumpExtendedObject { private \$extendedPrivate = 42; protected \$extendedProtected = TRUE; public \$extendedPublic = FALSE; protected \$protected = 42.23; public \$public = 'foo bar baz' }
EOT;

        $this->assertEquals(
            $res,
            ezcDebugVariableDumpTool::dumpVariable( $obj, 512, 128, 3 )
        );
    }

    public function testDumpExtendedObjectComplex()
    {
        $obj = new DebugTestDumpExtendedObject(
            array(),
            42.23,
            'foo bar baz',
            array(
                1,
                2,
                array(
                    new stdClass(),
                    'some text',
                    new stdClass(),
                    23,
                    array( null, null, true, false, null, 23 )
                ),
                3,
                4,
            ),
            true,
            array(
                new DebugTestDumpObject(
                    new DebugTestDumpExtendedObject( 1, 2, 3, 4, 5, 6 ),
                    array( true, false, 'string' ),
                    new DebugTestDumpObject( 'a', 2, 'c' )
                ),
            )
        );

        $res = <<<EOT
class DebugTestDumpExtendedObject { private \$extendedPrivate = array (0 => 1, 1 => 2, 2 => array (0 => class stdClass {  }, 1 => 'some text', 2 => class stdClass {  }, 3 => 23, 4 => array (0 => NULL, 1 => NULL, 2 => TRUE, 3 => FALSE, 4 => NULL, 5 => 23)), 3 => 3, 4 => 4); protected \$extendedProtected = TRUE; public \$extendedPublic = array (0 => class DebugTestDumpObject { private \$private = class DebugTestDumpExtendedObject { private \$extendedPrivate = 4; protected \$extendedProtected = 5; public \$extendedPublic = 6; protected \$protected = 2; public \$public = 3 }; protected \$protected = array (0 => TRUE, 1 => FALSE, 2 => 'string'); public \$public = class DebugTestDumpObject { private \$private = 'a'; protected \$protected = 2; public \$public = 'c' } }); protected \$protected = 42.23; public \$public = 'foo bar baz' }
EOT;

        $this->assertEquals(
            $res,
            ezcDebugVariableDumpTool::dumpVariable( $obj, 512, 128, 4 )
        );
    }
    
    public function testDumpResource()
    {
        $res = fopen( __FILE__, 'r' );

        preg_match( '(Resource id #(?P<id>\d+))', (string) $res, $matches );

        $this->assertEquals(
            "resource({$matches['id']}) of type (stream)",
            ezcDebugVariableDumpTool::dumpVariable( $res, 512, 128, 3 )
        );
    }
}
?>
