<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/configurable-dispatcher.php';

/**
 * Test the configurable dispatcher.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsConfigurableDispatcherTest extends ezcTestCase
{
    function test1()
    {
        $config = new simpleConfiguration();
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR])", $config->store );
    }

    function testInternalRedirect()
    {
        $config = new simpleConfiguration();
        $config->route = 'IRController';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'nonRedirVar' => 4,[CR]  'ReqRedirVar' => 4,[CR])", $config->store );
    }

    function testViewException()
    {
        $config = new simpleConfiguration();
        $config->view = 'ExceptionView';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'fatal' => 'Very fatal',[CR])", $config->store );
    }

    function testEndlessLoop()
    {
        $config = new simpleConfiguration();
        $config->route = 'EndlessIR';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        try
        {
            $dispatcher->run();
            self::fail( "Expected exception was not thrown." );
        }
        catch ( ezcMvcInfiniteLoopException $e )
        {
            self::assertEquals( "25 redirects have occurred, there is a possible infinite redirect loop.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
