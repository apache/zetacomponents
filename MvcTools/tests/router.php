<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/testclasses.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsRouterTest extends ezcTestCase
{
    public function testSimple()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'entry/list';
        $router = new testSimpleRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'list' ), $controller->getVars() );

        $request = new ezcMvcRequest;
        $request->uri = 'entry/get/89';
        $router = new testSimpleRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'show', 'id' => 89 ), $controller->getVars() );

        $request = new ezcMvcRequest;
        $request->uri = 'entry/89';
        $router = new testSimpleRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'show', 'id' => 89 ), $controller->getVars() );
    }

    public function testInvalidAction()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'test/no-action';
        $router = new testSimpleRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        try
        {
            $controller->createResult();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcActionNotFoundException $e )
        {
            self::assertEquals( "The action 'nonExistingMethod' does not exist.", $e->getMessage() );
        }
    }

    public function testNoRoutes()
    {
        $request = new ezcMvcRequest;

        $router = new testNoRoutesRouter( $request );
        try
        {
            $routeInfo = $router->getRoutingInformation();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcNoRoutesException $e )
        {
            self::assertEquals( "No routes are defined in the router.", $e->getMessage() );
        }
    }

    public function testNoRouteMatched()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'nomatch';

        $router = new testSimpleRouter( $request );
        try
        {
            $routeInfo = $router->getRoutingInformation();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcRouteNotFoundException $e )
        {
            self::assertEquals( "No route was found that matched request ID 'nomatch'.", $e->getMessage() );
        }
    }

    public function testNoRouteMatchedRequestId()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'nomatch';
        $request->requestId = 'localhost/nomatch';

        $router = new testSimpleRouter( $request );
        try
        {
            $routeInfo = $router->getRoutingInformation();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcRouteNotFoundException $e )
        {
            self::assertEquals( "No route was found that matched request ID 'localhost/nomatch'.", $e->getMessage() );
        }
    }

    public function testFaultyRoute()
    {
        $request = new ezcMvcRequest;

        $router = new testFaultyRouteRouter( $request );
        try
        {
            $routeInfo = $router->getRoutingInformation();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'O:8:\"stdClass\":0:{}' that you were trying to assign to setting 'route' is invalid. Allowed values are: instance of ezcMvcRoute.", $e->getMessage() );
        }
    }

    public function testPrefixRoutes()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'blog/entry/list';
        $router = new testPrefixRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'list' ), $controller->getVars() );

        $request = new ezcMvcRequest;
        $request->uri = 'blog/entry/get/89';
        $router = new testPrefixRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'show', 'id' => 89 ), $controller->getVars() );

        $request = new ezcMvcRequest;
        $request->uri = 'blog/entry/89';
        $router = new testPrefixRouter( $request );
        $routeInfo = $router->getRoutingInformation();
        $controllerClass = $routeInfo->controllerClass;
        $controller = new $controllerClass( $routeInfo->action, $request );
        self::assertEquals( array( 'method' => 'show', 'id' => 89 ), $controller->getVars() );
        self::assertEquals( 'sample', $controller->action );
    }

    function testNoNamedRoute()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'entry/get/89';
        $router = new testNamedRouter( $request );
        try
        {
            $foo = $router->generateUrl( 'list' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcNamedRouteNotFoundException $e )
        {
            self::assertEquals( "No route was found with the name 'list'.", $e->getMessage() );
        }
    }

    function testNamedRouteThatDoesNotSupportReversedRoutes()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'entry/get/89';
        $router = new testNamedRouter( $request );
        try
        {
            $foo = $router->generateUrl( 'no-reverse' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcNamedRouteNotReversableException $e )
        {
            self::assertEquals( "The route with name 'no-reverse' is of the 'testRegexpRoute' class, which does not support reversed route generation.", $e->getMessage() );
        }
        try
        {
            $foo = $router->generateUrl( 'catchall' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcNamedRouteNotReversableException $e )
        {
            self::assertEquals( "The route with name 'catchall' is of the 'ezcMvcCatchAllRoute' class, which does not support reversed route generation.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsRouterTest" );
    }
}
?>
