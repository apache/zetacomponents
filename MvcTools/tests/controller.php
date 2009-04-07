<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/controller.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsControllerTest extends ezcTestCase
{
    public function testEmptyAction()
    {
        try
        {
            $f = new testControllerController( null, new ezcMvcRequest() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcControllerException $e )
        {
            self::assertEquals( "The 'testControllerController' controller requires an action.", $e->getMessage() );
        }
    }

    public function testSetAction()
    {
        $f = new testControllerController( 'testAction', new ezcMvcRequest() );
        self::assertEquals( "testAction", $this->readAttribute( $f, 'action' ) );
    }

    public function testSetVariables()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );

        self::assertEquals( 42, $f->var1 );
        self::assertEquals( 'bansai!', $f->var42 );
    }

    public function testRoutingInformation()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );
        $f->router = new testSimpleRouter( $r );

        self::assertEquals( new testSimpleRouter( $r ), $f->router );
    }

    public function testCreateActionMethod()
    {
        $f = new testControllerController( 'test', new ezcMvcRequest() );
        self::assertEquals( 'doTest', $f->testCreateActionMethod() );

        $f = new testControllerController( 'test_action', new ezcMvcRequest() );
        self::assertEquals( 'doTestAction', $f->testCreateActionMethod() );

        $f = new testControllerController( 'testAction', new ezcMvcRequest() );
        self::assertEquals( 'doTestAction', $f->testCreateActionMethod() );

        $f = new testControllerController( 'test_with_more_than_OneWord', new ezcMvcRequest() );
        self::assertEquals( 'doTestWithMoreThanOneWord', $f->testCreateActionMethod() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsControllerTest" );
    }
}
?>
