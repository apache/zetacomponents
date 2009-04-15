<?php
class simpleConfiguration implements ezcMvcDispatcherConfiguration
{
    var $store = 43;
    var $route = null;
    var $view  = null;
    var $requestParser = null;
    var $internalRedirectRequestFilter = false;
    var $preRoutingFilter = false;

    function createRequestParser()
    {
        if ( $this->requestParser == 'FaultyRoutes' )
        {
            return new testRequestParserFaultyRoutes();
        }
        return new testRequestParser();
    }

    function createRouter( ezcMvcRequest $request )
    {
        switch ( $this->route )
        {
            case 'IRController':
                return new testIRControllerRouter( $request );
            case 'FaultyAction':
                return new testFaultyActionRouter( $request );
            case 'ExceptionInAction':
                return new testExceptionInActionRouter( $request );
            case 'FatalInfatal':
                return new testFatalInFatalRouter( $request );
            case 'EndlessIR':
                return new testEndlessIRRouter( $request );
            case 'EmptyResultController':
                return new testEmptyResultControllerRouter( $request );
            default:
                return new testRouter( $request );
        }
    }

    function createView( ezcMvcRoutingInformation $routingInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
        if ( $this->view == 'ExceptionView' && !isset( $result->variables['fatal'] ) )
        {
            return new testExceptionView( $request, $result );
        }
        return new testView( $request, $result );
    }

    function createResponseWriter( ezcMvcRoutingInformation $routingInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
        $rw = new testResponseWriter( $response );
        $rw->config = $this;
        return $rw;
    }

    function createFatalRedirectRequest( ezcMvcRequest $request, ezcMvcResult $result, Exception $response )
    {
        $req = new ezcMvcRequest;
        $req->uri = '/fatal';

        return $req;
    }

    function getResponse()
    {
        return $this->response;
    }

    public function runPreRoutingFilters( ezcMvcRequest $request )
    {
        if ( $this->preRoutingFilter === true )
        {
            $request->variables['newVar'] = 'yes, we did the pre-routing filter';
        }
    }

    public function runRequestFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request )
    {
        if ( $this->internalRedirectRequestFilter === true)
        {
            $ir = new ezcMvcInternalRedirect;
            $ir->request = new ezcMvcRequest;
            $this->internalRedirectRequestFilter = false;
            $ir->request->variables['request_filter'] = true;
            return $ir;
        }
        if ( $this->internalRedirectRequestFilter == 'exception' )
        {
            $ir = new ezcMvcInternalRedirect;
            return $ir;
        }
    }

    public function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
    }

    public function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
    }
}

class testRequestParser extends ezcMvcRequestParser
{
    function createRequest()
    {
        $req = new ezcMvcRequest;
        $req->uri = '/';

        return $req;
    }
}

class testRequestParserFaultyRoutes extends ezcMvcRequestParser
{
    function createRequest()
    {
        $req = new ezcMvcRequest;
        $req->uri = '/does not exist';

        return $req;
    }
}

class testRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testController', 'foo' ),
            new ezcMvcRegexpRoute( '@^/fatal$@', 'testFatalController', 'fatal' ),
        );
    }
}

class testBrokenControllerRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'stdClass', 'foo' ),
        );
    }
}

class testIRControllerRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testIRController', 'foo' ),
            new ezcMvcRegexpRoute( '@^/redir$@', 'testIRController', 'afterRedir' ),
        );
    }
}

class testEndlessIRRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testEndlessIRController', 'foo' ),
            new ezcMvcRegexpRoute( '@^/redir$@', 'testEndlessIRController', 'foo' ),
        );
    }
}

class testEmptyResultControllerRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testEmptyResultController', 'foo' ),
        );
    }
}

class testFaultyActionRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testController', 'no-return' ),
        );
    }
}

class testExceptionInActionRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testController', 'exception' ),
            new ezcMvcRegexpRoute( '@^/fatal$@', 'testFatalController', 'fatal' ),
        );
    }
}

class testFatalInFatalRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRegexpRoute( '@^/$@', 'testController', 'exception' ),
//            new ezcMvcRegexpRoute( '@^/fatal$@', 'testFatalController', 'fatal' ),
        );
    }
}

class testIRController extends ezcMvcController
{
    public function createResult()
    {
        if ( $this->action == 'foo' )
        {
            $req = new ezcMvcRequest();
            $req->uri = '/redir';
            $req->variables['redirVar'] = 4;

            return new ezcMvcInternalRedirect( $req );
        }
        $res = new ezcMvcResult;
        $res->variables['nonRedirVar'] = 4;
        $res->variables['ReqRedirVar'] = $this->redirVar;
        return $res;
    }
    public function getVars()
    {
        return $this->variables;
    }
}

class testFatalController extends ezcMvcController
{
    public function createResult()
    {
        $res = new ezcMvcResult;
        $res->variables['fatal'] = "Very fatal";
        return $res;
    }
    public function getVars()
    {
        return $this->variables;
    }
}

class testEndlessIRController extends ezcMvcController
{
    public function createResult()
    {
        $req = new ezcMvcRequest();
        $req->uri = '/redir';
        $req->variables['redirVar'] = 4;

        return new ezcMvcInternalRedirect( $req );
    }
    public function getVars()
    {
        return $this->variables;
    }
}

class testEmptyResultController extends ezcMvcController
{
    public function createResult()
    {
        return new ezcMvcResult();
    }
    public function getVars()
    {
        return $this->variables;
    }
}

class testView extends ezcMvcView
{
    public function createZones( $layout )
    {
        return array( new testViewHandler2( 'name', 'templateName' ) );
    }
}

class testExceptionView extends ezcMvcView
{
    public function createZones( $layout )
    {
        return array( new testExceptionViewHandler( 'name', 'templateName' ) );
    }
}

class testViewHandler2 implements ezcMvcViewHandler
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
        return "Name: " . $this->name . ", Vars: " . str_replace( "\n", "[CR]", var_export( $this->vars, true ) );
    }
}

class testExceptionViewHandler implements ezcMvcViewHandler
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
        throw new Exception( "foo" );
    }
}

class testResponseWriter extends ezcMvcResponseWriter
{
    var $response;
    var $config;

    function __construct( ezcMvcResponse $response )
    {
        $this->response = $response;
    }

    function handleResponse()
    {
        $this->config->store = "BODY: ". $this->response->body;
    }
}

class testWrongObjectsConfiguration implements ezcMvcDispatcherConfiguration
{
    public $fail = 'none';

    function createRequestParser()
    {
        return $this->fail == 'request-parser' ? new stdClass() : new testRequestParser();
    }

    function createRouter( ezcMvcRequest $request )
    {
        if ( $this->fail === 'fatal' )
        {
            return new testExceptionInActionRouter( $request );
        }
        if ( $this->fail === 'controller' )
        {
            return new testBrokenControllerRouter( $request );
        }
        return $this->fail == 'router' ? new stdClass() : new testRouter( $request );
    }

    function createView( ezcMvcRoutingInformation $routingInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
        return $this->fail == 'view' ? new stdClass() : new testView( $request, $result );
    }

    function createResponseWriter( ezcMvcRoutingInformation $routingInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
        $rw = $this->fail == 'response-writer' ? new stdClass() : new testResponseWriter( $response );
        $rw->config = $this;
        return $rw;
    }

    function createFatalRedirectRequest( ezcMvcRequest $request, ezcMvcResult $result, Exception $response )
    {
        return $this->fail == 'fatal' ? new stdClass() : new ezcMvcRequest();
    }

    function runPreRoutingFilters( ezcMvcRequest $request )
    {
    }

    function runRequestFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request )
    {
    }

    function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
    }

    function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
    }
}
?>
