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

    function testExternalRedirect()
    {
        $config = new simpleConfiguration();
        $config->route = 'IRController';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'nonRedirVar' => 4,[CR]  'ReqRedirVar' => 4,[CR])", $config->store );
    }

    function testRoutingException()
    {
        $config = new simpleConfiguration();
        $config->requestParser = 'FaultyRoutes';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'fatal' => 'Very fatal',[CR])", $config->store );
    }

    function testInvalidResultObject()
    {
        $config = new simpleConfiguration();
        $config->route = 'FaultyAction';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        try
        {
            $dispatcher->run();
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcControllerException $e )
        {
            self::assertEquals( "The action 'no-return' of controller 'testController' did not return an ezcMvcResult object.", $e->getMessage() );
        }
    }

    function testInternalRedirectRequestFilter()
    {
        $config = new simpleConfiguration();
        $config->internalRedirectRequestFilter = true;
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'fatal' => 'Very fatal',[CR])", $config->store );
    }

    function testInternalRedirectRequestFilterException()
    {
        $config = new simpleConfiguration();
        $config->internalRedirectRequestFilter = 'exception';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        try
        {
            $dispatcher->run();
        }
        catch ( PHPUnit_Framework_Error $e )
        {
            self::assertRegExp( "/^Argument 1 passed to simpleConfiguration::createRouter\(\) must be an instance of ezcMvcRequest, null given, called in/", $e->getMessage() );
        }
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

    function testControllerActionException()
    {
        $config = new simpleConfiguration();
        $config->route = 'ExceptionInAction';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'fatal' => 'Very fatal',[CR])", $config->store );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
