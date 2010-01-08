<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/catchall.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsCatchAllRouteTest extends ezcTestCase
{
    public function testMatchEmpty()
    {
        $request = new ezcMvcRequest;
        $request->uri = '';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( null, $routeInfo );
    }

    public function testNoMatch1()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/foo';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( null, $routeInfo );
    }

    public function testMatch1()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/my/action';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( '/my/action', $routeInfo->matchedRoute );
        self::assertSame( 'myController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchChangedActionName()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/mytwee/action';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( '/mytwee/action', $routeInfo->matchedRoute );
        self::assertSame( 'mytweeController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchWithParam()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/my/action/value1';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( array( 'param1' => 'value1' ), $request->variables );
        self::assertSame( '/my/action/value1', $routeInfo->matchedRoute );
        self::assertSame( 'myController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchWithParams()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/my/action/value1/value2';
        $route = new ezcMvcCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( array( 'param1' => 'value1', 'param2' => 'value2' ), $request->variables );
        self::assertSame( '/my/action/value1/value2', $routeInfo->matchedRoute );
        self::assertSame( 'myController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchWithParamsCustomParamName()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/my/action/value1/value2';
        $route = new myCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( array( 'wibble' => 'value1', 'wobble' => 'value2' ), $request->variables );
        self::assertSame( '/my/action/value1/value2', $routeInfo->matchedRoute );
        self::assertSame( 'myController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchWithParamsCustomParamNameCustomActionName()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/mytwee/action/value1/value2';
        $route = new myCatchAllRoute();
        $routeInfo = $route->matches( $request );
        self::assertSame( array( 'wibble' => 'value1', 'wobble' => 'value2' ), $request->variables );
        self::assertSame( '/mytwee/action/value1/value2', $routeInfo->matchedRoute );
        self::assertSame( 'mytweeController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public function testMatchWithDifferentUriMatch()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test.host';
        $request->uri = '/mytwee/action/value1/value2';
        $request->requestId = $request->host . $request->uri;
        $route = new myCatchAllRouteForFullUri();
        $routeInfo = $route->matches( $request );
        self::assertSame( array( 'param1' => 'value1', 'param2' => 'value2' ), $request->variables );
        self::assertSame( 'test.host/mytwee/action/value1/value2', $routeInfo->matchedRoute );
        self::assertSame( 'mytweeController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsCatchAllRouteTest" );
    }
}
?>
