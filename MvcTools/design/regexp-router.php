<?php
abstract class ezcMvcRouter
{
    protected $routes = array();

    public function __construct( ezcMvcRequest $request )
    {
        $this->request = $request;
    }

    abstract public function createRoutes();

    public function createController()
    {
        $routes = $this->createRoutes();

        foreach( $routes as $route )
        {
            if ( !$route instanceof ezcMvcRoute )
            {
                throw new ezcBaseValueException( 'route', $route, 'value', 'instanceof ezcMvcRoute' );
            }

            $controller = $route->matches( $request );
            if ( $controller instanceof ezcMvcController )
            {
                return $controller;
            }
        }

        throw new ezcMvcRouteNotFoundException( $request->requestId );
    }

    static public function prefix( $prefix, $routes )
    {
        foreach( $routes as $route )
        {
            $route->prefix( $prefix );
        }

        return $routes;
    }
}

interface ezcMvcRoute
{
    /**
     * Returns the controller instance or null.
     * 
     * @param ezcMvcRequest $request Request to test.
     * @return ezcMvcController
     */
    public function matches( ezcMvcRequest $request );

    /**
     * Adds a prefix to the route.
     * 
     * @param mixed $prefix Prefix to add, for example: '/blog'
     * @return void
     */
    public function prefix( $prefix );
}

class ezcMvcRegexpRoute implements ezcMvcRoute
{
    public function __construct( $pattern, $controllerClass, array $defaultValues = array() )
    {
        $this->pattern = $pattern;
        $this->controllerClass = $controllerClass;
        $this->defaultValues = $defaultValues;
    }

    public function matches( ezcMvcRequest $request )
    {
        if ( $this->pregMatch( $request, $matches ) )
        {
            foreach( $matches as $key => $match )
            {
                if( is_numeric( $key ) )
                {
                    unset( $matches[$key] );
                }
            }

            $variables = array_merge( $this->defaultValues, $matches );

            $controllerClass = $this->controllerClass;
            return new $controllerClass( $request, $variables );
        }
    }

    /**
     * Parses the pattern and adds the prefix.
     * 
     * @param mixed $prefix Prefix to add.
     * @return void
     */
    public function prefix( $prefix )
    {
        // i'll write the tests first ;)
    }

    protected function pregMatch( $request, &$matches )
    {
        return preg_match( $this->pattern, $request->uri, $matches );
    }
}

class ezcMvcRequestIdRegexpRoute extends ezcMvcRegexpRoute
{
    protected function pregMatch( $request, &$matches )
    {
        return preg_match( $this->pattern, $request->requestId, $matches );
    }

    public function prefix( $prefix )
    {
        // ...
    }
}

// User implementation
class myGlobalRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        $routes[] = new ezcMvcRegexpRouteStruct( 
            '@^/styles/(?P<slug>.+)/$@',
            'yourStyleController', array( 'defaultValue1' => 42 ) 
        );
        // Add routes from an application
        $appRouterOne = new myApplicationDecoupledRouterOne;
        $routes += $appRouterOne->createRoutes();



        // Add routes from an application, prefixed with the blog/ prefix.
        $appRouter = new myApplicationDecoupledRouterDefault;
        $routes += ezcMvcRouter::prefix( 'blog/', $appRouter->createRoutes() );

        return $routes;
    }
}

// Decoupled the urls of another application (You can have several application
// per project right? that's re-usable)
class myApplicationDecoupledRouter extends ezcMvcRegexpRouter
{
    public function createRoutes()
    {
        // Return routes that are application specific
    }
}
?>
