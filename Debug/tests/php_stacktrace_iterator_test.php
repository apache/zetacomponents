<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

class DebugTestDumpObject
{
    private $private;

    protected $protected;

    public $public;

    public function __construct( $private, $protected, $public )
    {
        $this->private   = $private;
        $this->protected = $protected;
        $this->public    = $public;
    }
}

class DebugTestDumpObjectExtended extends DebugTestDumpObject
{
    private $extendedPrivate;

    protected $extendedProtected;

    public $extendedPublic;

    public function __construct( $private, $protected, $public, $extendedPrivate, $extendedProtected, $extendedPublic )
    {
        $this->extendedPrivate   = $extendedPrivate;
        $this->extendedProtected = $extendedProtected;
        $this->extendedPublic    = $extendedPublic;
        parent::__construct( $private, $protected, $public );
    }
}


/**
 * Test suite for the ezcDebugOptions class.
 *
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugPhpStacktraceIteratorTest extends ezcTestCase
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
            ezcDebugPhpStacktraceIterator::dumpVariable( $true )
        );
        $this->assertEquals(
            'FALSE',
            ezcDebugPhpStacktraceIterator::dumpVariable( $false )
        );
    }

    public function testDumpInteger()
    {
        $a = 0;
        $b = 23;
        $c = -42;
        
        $this->assertEquals(
            '0',
            ezcDebugPhpStacktraceIterator::dumpVariable( $a )
        );
        $this->assertEquals(
            '23',
            ezcDebugPhpStacktraceIterator::dumpVariable( $b )
        );
        $this->assertEquals(
            '-42',
            ezcDebugPhpStacktraceIterator::dumpVariable( $c )
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
            ezcDebugPhpStacktraceIterator::dumpVariable( $a )
        );
        $this->assertEquals(
            '23',
            ezcDebugPhpStacktraceIterator::dumpVariable( $b )
        );
        $this->assertEquals(
            '-42',
            ezcDebugPhpStacktraceIterator::dumpVariable( $c )
        );
        $this->assertEquals(
            '23.42',
            ezcDebugPhpStacktraceIterator::dumpVariable( $d )
        );
        $this->assertEquals(
            '-42.23',
            ezcDebugPhpStacktraceIterator::dumpVariable( $e )
        );
    }

    public function testDumpString()
    {
        $a = 'foo';
        $b = '';

        $this->assertEquals(
            "'foo'",
            ezcDebugPhpStacktraceIterator::dumpVariable( $a )
        );
        $this->assertEquals(
            "''",
            ezcDebugPhpStacktraceIterator::dumpVariable( $b )
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
            ezcDebugPhpStacktraceIterator::dumpVariable( $arr )
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
array (0 => 23, 'foo bar' => array (1 => '293', 2 => 234223, 'foo' => array (0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => array (), 8 => 23, 9 => 'foo', 10 => array (0 => 23, 1 => 42))), 1 => 42.23, 'a' => TRUE, 'd' => FALSE, 23 => 'test', 24 => 'foo bar baz')
EOT;
        $this->assertEquals(
            $res,
            ezcDebugPhpStacktraceIterator::dumpVariable( $arr )
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
            ezcDebugPhpStacktraceIterator::dumpVariable( $obj )
        );
    }

    public function testDumpExtendedObject()
    {
        $obj = new DebugTestDumpObjectExtended( 23, 42.23, 'foo bar baz', 42, true, false );

        $res = <<<EOT
class DebugTestDumpObjectExtended { private \$extendedPrivate = 42; protected \$extendedProtected = TRUE; public \$extendedPublic = FALSE; protected \$protected = 42.23; public \$public = 'foo bar baz' }
EOT;

        $this->assertEquals(
            $res,
            ezcDebugPhpStacktraceIterator::dumpVariable( $obj )
        );
    }

    public function testDumpExtendedObjectComplex()
    {
        $obj = new DebugTestDumpObjectExtended(
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
                    new DebugTestDumpObjectExtended( 1, 2, 3, 4, 5, 6 ),
                    array( true, false, 'string' ),
                    new DebugTestDumpObject( 'a', 2, 'c' )
                ),
            )
        );

        $res = <<<EOT
class DebugTestDumpObjectExtended { private \$extendedPrivate = array (0 => 1, 1 => 2, 2 => array (0 => class stdClass {  }, 1 => 'some text', 2 => class stdClass {  }, 3 => 23, 4 => array (0 => NULL, 1 => NULL, 2 => TRUE, 3 => FALSE, 4 => NULL, 5 => 23)), 3 => 3, 4 => 4); protected \$extendedProtected = TRUE; public \$extendedPublic = array (0 => class DebugTestDumpObject { private \$private = class DebugTestDumpObjectExtended { private \$extendedPrivate = 4; protected \$extendedProtected = 5; public \$extendedPublic = 6; protected \$protected = 2; public \$public = 3 }; protected \$protected = array (0 => TRUE, 1 => FALSE, 2 => 'string'); public \$public = class DebugTestDumpObject { private \$private = 'a'; protected \$protected = 2; public \$public = 'c' } }); protected \$protected = 42.23; public \$public = 'foo bar baz' }
EOT;

        $this->assertEquals(
            $res,
            ezcDebugPhpStacktraceIterator::dumpVariable( $obj )
        );
    }
    
    public function testDumpResource()
    {
        $res = fopen( __FILE__, 'r' );

        preg_match( '(Resource id #(?P<id>\d+))', (string) $res, $matches );

        $this->assertEquals(
            "resource({$matches['id']}) of type (stream)",
            ezcDebugPhpStacktraceIterator::dumpVariable( $res )
        );
    }
}
?>
