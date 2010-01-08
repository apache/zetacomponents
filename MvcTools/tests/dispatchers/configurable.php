<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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

    function testPreRoutingFilter()
    {
        $config = new simpleConfiguration();
        $config->preRoutingFilter = true;
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR]  'newVar' => 'yes, we did the pre-routing filter',[CR])", $config->store );
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
            self::assertRegExp( "/^Argument 1 passed to simpleConfiguration::runPreRoutingFilters\(\) must be an instance of ezcMvcRequest, null given, called in/", $e->getMessage() );
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

    function testFatalInFatal()
    {
        $config = new simpleConfiguration();
        $config->route = 'FatalInfatal';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        try
        {
            $dispatcher->run();
            self::fail( "Expected exception was not thrown." );
        }
        catch ( ezcMvcFatalErrorLoopException $e )
        {
            self::assertEquals( 'The request "", "/fatal" () results in an infinite fatal error loop.', $e->getMessage() );
        }
    }

    // test for issue #13939
    public function testNoReturnedVariables()
    {
        $config = new simpleConfiguration();
        $config->controller = 'EmptyResultController';
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
        self::assertEquals( "BODY: Name: name, Vars: array ([CR])", $config->store );
    }

    public function testAllIsWell()
    {
        $config = new testWrongObjectsConfiguration();
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        $dispatcher->run();
    }

    public function commonWrongTest( $type )
    {
        $config = new testWrongObjectsConfiguration();
        $config->fail = $type;
        $dispatcher = new ezcMvcConfigurableDispatcher( $config );
        try
        {
            $dispatcher->run();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcInvalidConfiguration $e )
        {
            return $e->getMessage();
        }
    }

    public function testWrongRequestParserClass()
    {
        $e = self::commonWrongTest( 'request-parser' );
        self::assertEquals( "The configuration returned an invalid object for 'requestParser', instance of ezcMvcRequestParser expected, but instance of class stdClass found.", $e );
    }

    public function testWrongRouterClass()
    {
        $e = self::commonWrongTest( 'router' );
        self::assertEquals( "The configuration returned an invalid object for 'router', instance of ezcMvcRouter expected, but instance of class stdClass found.", $e );
    }

    public function testWrongViewClass()
    {
        $e = self::commonWrongTest( 'view' );
        self::assertEquals( "The configuration returned an invalid object for 'view', instance of ezcMvcView expected, but instance of class stdClass found.", $e );
    }

    public function testWrongControllerClass()
    {
        $e = self::commonWrongTest( 'controller' );
        self::assertEquals( "The configuration returned an invalid object for 'controller', instance of ezcMvcController expected, but instance of class stdClass found.", $e );
    }

    public function testWrongResponseWriter()
    {
        $e = self::commonWrongTest( 'response-writer' );
        self::assertEquals( "The configuration returned an invalid object for 'responseWriter', instance of ezcMvcResponseWriter expected, but instance of class stdClass found.", $e );
    }

    public function testWrongFatalRedirectClass()
    {
        $e = self::commonWrongTest( 'fatal' );
        self::assertEquals( "The configuration returned an invalid object for 'request', instance of ezcMvcRequest expected, but instance of class stdClass found.", $e );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
