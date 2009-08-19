<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcMvcToolsRailsRouteTest extends ezcTestCase
{
    public function testMatchEmpty()
    {
        $request = new ezcMvcRequest;
        $request->uri = '';
        $route = new ezcMvcRailsRoute( '', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array(), $request->variables );
    }

    public function testNoMatchEmpty()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'notEmpty';
        $route = new ezcMvcRailsRoute( '', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( null, $routeInfo );
    }

    public function testMatchEmptyDefaultVars()
    {
        $request = new ezcMvcRequest;
        $request->uri = '';
        $route = new ezcMvcRailsRoute( '', 'testController', 'action', array( 'default1' => 'Reality is merely an illusion, albeit a very persistent one.' ) );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( 'action', $routeInfo->action );
        self::assertSame( array( 'default1' => 'Reality is merely an illusion, albeit a very persistent one.' ), $request->variables );
    }

    public function testsMatchNonEmptyDefaultVar()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'people/einstein';
        $route = new ezcMvcRailsRoute( 'people/:ignore', 'testController', 'action', array( 'name' => 'rethans' ) );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'name' => 'rethans', 'ignore' => 'einstein' ), $request->variables );
    }

    public function testsMatchNonEmptyOneVar()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'people/einstein';
        $route = new ezcMvcRailsRoute( 'people/:name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'name' => 'einstein' ), $request->variables );
    }

    public function testsMatchNonEmptyDefaultVarReused()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'people/einstein';
        $route = new ezcMvcRailsRoute( 'people/:name', 'testController', array( 'name' => 'rethans' ) );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'name' => 'einstein' ), $request->variables );
    }

    public function testsMatchNonEmptyTwoVars()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'people/hawking';
        $route = new ezcMvcRailsRoute( ':group/:name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'group' => 'people', 'name' => 'hawking' ), $request->variables );
    }

    public function testsMatchComplex()
    {
        $route = new ezcMvcRailsRoute( 'people/:slug', 'testController', 'action', array( 'nr' => '', 'name' => '' ) );
        $request = new ezcMvcRequest;

        $request->uri = 'people/hawking';
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertEquals( array( 'nr' => '', 'name' => '', 'slug' => 'hawking' ), $request->variables );

        $request->uri = 'people/42';
        $routeInfo = $route->matches( $request );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertEquals( array( 'nr' => '', 'name' => '', 'slug' => 42 ), $request->variables );

        $request->uri = 'people';
        $routeInfo = $route->matches( $request );
        self::assertEquals( null, $routeInfo );

        $request->uri = 'people/';
        $routeInfo = $route->matches( $request );
        self::assertEquals( null, $routeInfo );
    }

    public function testPrefix()
    {
        $route = new testRailsRoute( 'entry/:id', 'ignored' );
        $route->prefix( 'blog/' );
        self::assertEquals( 'blog/entry/:id', $route->getPattern() );
    }

    function testNamedRoutes()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'entry/get/89';
        $router = new testNamedRouter( $request );
        self::assertEquals( 'entry/get/42', $router->generateUrl( 'get', array( 'id' => 42 ) ) );
        self::assertEquals( 'entry/42/info', $router->generateUrl( 'info', array( 'id' => 42 ) ) );
        self::assertEquals( 'e/derick/yes', $router->generateUrl( 'multiple1', array( 'person' => 'derick', 'relation' => 'yes' ) ) );
        self::assertEquals( 'derick/e/yes', $router->generateUrl( 'multiple2', array( 'person' => 'derick', 'relation' => 'yes' ) ) );
        self::assertEquals( 'derick/yes/e', $router->generateUrl( 'multiple3', array( 'person' => 'derick', 'relation' => 'yes' ) ) );
    }

    function testNamedRoutesMissingArgument()
    {
        $request = new ezcMvcRequest;
        $request->uri = 'entry/get/89';
        $router = new testNamedRouter( $request );
        try
        {
            $router->generateUrl( 'info', array() );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcMissingRouteArgumentException $e )
        {
            self::assertEquals( "The argument 'id' was not specified while generating a URL out of the route with pattern 'entry/:id/info'.", $e->getMessage() );
        }
        try
        {
            $router->generateUrl( 'multiple1', array( 'person' => 'derick' ) );
        }
        catch ( ezcMvcMissingRouteArgumentException $e )
        {
            self::assertEquals( "The argument 'relation' was not specified while generating a URL out of the route with pattern 'e/:person/:relation'.", $e->getMessage() );
        }
    }

    public function testMatchWithDifferentUriMatch()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test.host';
        $request->uri = '/people/hawking';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( ':site.host/:group/:name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( ':site.host/:group/:name', $routeInfo->matchedRoute );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'site' => 'test', 'group' => 'people', 'name' => 'hawking' ), $request->variables );
    }

    // tests for issue #15313
    public function testMatchWithDotInUrl1()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test.host';
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( 'test.host/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'test.host/topic/list/:newsgroup_name', $routeInfo->matchedRoute );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'newsgroup_name' => 'foo.bar.ezc.is.cool' ), $request->variables );
    }

    public function testMatchWithDotInUrl2()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test.example.com';
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( 'test.:domain.com/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( 'test.:domain.com/topic/list/:newsgroup_name', $routeInfo->matchedRoute );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'domain' => 'example', 'newsgroup_name' => 'foo.bar.ezc.is.cool' ), $request->variables );
    }

    public function testMatchWithDotInUrl3()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->uri;

        $route = new testRailsRouteForFullUri( '/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( '/topic/list/:newsgroup_name', $routeInfo->matchedRoute );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'newsgroup_name' => 'foo.bar.ezc.is.cool' ), $request->variables );
    }

    public function testMatchWithDotInUrl3a()
    {
        $request = new ezcMvcRequest;
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';

        $route = new ezcMvcRailsRoute( '/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertSame( '/topic/list/:newsgroup_name', $routeInfo->matchedRoute );
        self::assertSame( 'testController', $routeInfo->controllerClass );
        self::assertSame( array( 'newsgroup_name' => 'foo.bar.ezc.is.cool' ), $request->variables );
    }

    public function testMatchWithDotInUrl4()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test/host';
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( 'test.host/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertEquals( null, $routeInfo );
    }

    public function testMatchWithDotInUrl5()
    {
        $request = new ezcMvcRequest;
        $request->host = 'test.host';
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( 'test/host/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertEquals( null, $routeInfo );
    }

    public function testMatchWithDotInUrl6()
    {
        $request = new ezcMvcRequest;
        $request->host = 'hostname';
        $request->uri = '/topic/list/foo.bar.ezc.is.cool';
        $request->requestId = $request->host . $request->uri;

        $route = new testRailsRouteForFullUri( '/topic/list/:newsgroup_name', 'testController' );
        $routeInfo = $route->matches( $request );
        self::assertEquals( null, $routeInfo );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsRailsRouteTest" );
    }
}
?>
