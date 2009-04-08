<?php
class testController extends ezcMvcController
{
    public $variables;
    public $action;
    public function __construct( $action, ezcMvcRequest $r )
    {
        $this->variables = $r->variables;
        $this->action = $action;
    }
    public function createResult()
    {
        if ( $this->action == 'no-return' )
        {
        }
        else if ( $this->action == 'exception' )
        {
            throw new Exception( "Oh la la" );
        }
        else
        {
            $res = new ezcMvcResult;
            $res->variables = $this->variables;
            return $res;
        }
    }
    public function getVars()
    {
        return $this->variables;
    }
}

class testActionController extends ezcMvcController
{
}

class testRegexpRoute extends ezcMvcRegexpRoute
{
    function getPattern()
    {
        return $this->pattern;
    }
}

class testRegexpRouteForFullUri extends ezcMvcRegexpRoute
{
    function getUriString( ezcMvcRequest $request )
    {
        return $request->requestId;
    }
}

class testRailsRoute extends ezcMvcRailsRoute
{
    function getPattern()
    {
        return $this->pattern;
    }
}

class testRailsRouteForFullUri extends ezcMvcRailsRoute
{
    function getUriString( ezcMvcRequest $request )
    {
        return $request->requestId;
    }
}

class testSimpleRouter extends ezcMvcRouter
{
    function createRoutes()
    {
        $routes = array();
        $routes[] = new testRegexpRoute( '@^entry/add$@', 'testController', 'sample', array( 'method' => 'add' ) );
        $routes[] = new testRegexpRoute( '@^entry/list$@', 'testController', 'sample', array( 'method' => 'list' ) );
        $routes[] = new testRegexpRoute( '@^entry/get/(?P<id>[0-9]+)$@', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes[] = new testRegexpRoute( '@^entry/(?P<id>[0-9]+)$@', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes[] = new testRegexpRoute( '@^test/no-action$@', 'testActionController', 'nonExistingMethod' );

        return $routes;
    }
}

class testNamedRouter extends ezcMvcRouter
{
    function createRoutes()
    {
        $routes = array();
        $routes['get'] = new testRailsRoute( 'entry/get/:id', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes[] = new testRailsRoute( 'entry/list', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes[] = new testRailsRoute( 'entry/:id', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['info'] = new testRailsRoute( 'entry/:id/info', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['multiple1'] = new testRailsRoute( 'e/:person/:relation', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['multiple2'] = new testRailsRoute( ':person/e/:relation', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['multiple3'] = new testRailsRoute( ':person/:relation/e', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['no-reverse'] = new testRegexpRoute( '@^entry/(?P<id>[0-9]+)$@', 'testController', 'sample', array( 'method' => 'show' ) );
        $routes['catchall'] = new ezcMvcCatchAllRoute( 'testController', 'sample', array( 'method' => 'show' ) );

        return $routes;
    }
}

class testPrefixRouter extends ezcMvcRouter
{
    function createRoutes()
    {
        $simple = new testSimpleRouter( $this->request );
        $routes = testSimpleRouter::prefix( '@^blog/@', $simple->createRoutes() );
        
        return $routes;
    }
}

class testNoRoutesRouter extends ezcMvcRouter
{
    function createRoutes()
    {
        $routes = array();
        return $routes;
    }
}

class testFaultyRouteRouter extends ezcMvcRouter
{
    function createRoutes()
    {
        return array( new StdClass() );
    }
}

class testNoZonesView extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        return $zones;
    }
}

class testFaultyView extends ezcMvcView
{
    function createZones( $layout )
    {
        return array( new StdClass() );
    }
}

class testOneView extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new testViewHandler( 'name', 'templateName' ); 
        return $zones;
    }
}

class testOnePhpView extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new ezcMvcPhpViewHandler( 'page_layout', dirname( __FILE__ ) . '/views/php/simple.php' ); 
        return $zones;
    }
}

class testTwoPhpViews extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new ezcMvcPhpViewHandler( 'nav', dirname( __FILE__ ) . '/views/php/nav.php' ); 
        $zones[] = new ezcMvcPhpViewHandler( 'page_layout', dirname( __FILE__ ) . '/views/php/simple_with_nav.php' ); 
        return $zones;
    }
}

class testNonExistingPhpView extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new ezcMvcPhpViewHandler( 'page_layout', dirname( __FILE__ ) . '/views/php/not_here.php' ); 
        return $zones;
    }
}

class testOneJsonView extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new ezcMvcJsonViewHandler( 'page_layout' ); 
        return $zones;
    }
}

class testTwoJsonViews extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new ezcMvcJsonViewHandler( 'nav' ); 
        $zones[] = new ezcMvcJsonViewHandler( 'page_layout' ); 
        return $zones;
    }
}

class testTwoViews extends ezcMvcView
{
    function createZones( $layout )
    {
        $zones = array();
        $zones[] = new testViewHandler( 'name1', 'templateName' ); 
        $zones[] = new testViewHandler( 'name2', 'templateName' ); 
        return $zones;
    }
}

class testViewHandler implements ezcMvcViewHandler
{
    public $vars = array();
    function __construct( $name, $templateName = null )
    {
        $this->name = $name;
        $this->templateName = $templateName;
    }

    function send( $name, $value )
    {
        $this->vars[$name] = $value;
    }

    function process( $last )
    {
        $this->result = new StdClass;
        $this->result->name = $this->name;
        $this->result->vars = $this->vars;
    }

    function getName()
    {
        return $this->name;
    }

    function getResult()
    {
        return $this->result;
    }
}

class wobblywook
{
}
?>
