<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * This class implements an example dispatcher that can be configured through
 * ezcMvcDispatcherConfiguration.
 * 
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcConfigurableDispatcher implements ezcMvcDispatcher
{
    /**
     * Contains the configuration that determines which request parser, router,
     * view handler and response writer are used.
     *
     * @var ezcMvcDispatcherConfiguration
     */
    protected $configuration;

    /**
     * Creates a new ezcMvcConfigurableDispatcher
     *
     * @param ezcMvcDispatcherConfiguration $configuration
     */
    public function __construct( ezcMvcDispatcherConfiguration $configuration )
    {
        $this->configuration = $configuration;
    }

    /**
     * Creates the controller by using the routing information and request data.
     *
     * @param ezcMvcRoutingInformation $routingInformation
     * @param ezcMvcRequest            $request
     * @return ezcMvcController
     */
    protected function createController( ezcMvcRoutingInformation $routingInformation, ezcMvcRequest $request )
    {
        $controllerClass = $routingInformation->controllerClass;
        $controller = new $controllerClass( $routingInformation->action, $request );
        return $controller;
    }

    /**
     * Runs through the request, by using the configuration to obtain correct
     * handlers.
     */
    public function run()
    {
        // initialize infinite loop counter
        $redirects = 0;

        // create the request parser
        $requestParser = $this->configuration->createRequestParser();
        // create the request
        $request = $requestParser->createRequest();

        // start of the request loop
        do
        {
            // do the infinite loop check
            if ( $redirects >= 25 )
            {
                throw new ezcMvcInfiniteLoopException( $redirects );
            }
            $continue = false;

            // create the router from the configuration
            $router = $this->configuration->createRouter( $request );

            // router creates routing information
            try
            {
                $routingInformation = $router->getRoutingInformation();
            }
            catch ( ezcMvcRouteNotFoundException $e )
            {
                $request = $this->configuration->createFatalRedirectRequest( $request, new ezcMvcResult, $e );
                $continue = true;
                $redirects++;
                continue;
            }

            // run request filters
            $filterResult = $this->configuration->runRequestFilters( $routingInformation, $request );

            if ( $filterResult instanceof ezcMvcInternalRedirect )
            {
                $request = $filterResult->request;
                $continue = true;
                $redirects++;
                continue;
            }

            // create the controller
            $controller = $this->createController( $routingInformation, $request );

            // run the controller
            $result = $controller->createResult();

            if ( $result instanceof ezcMvcInternalRedirect )
            {
                $request = $result->request;
                $continue = true;
                $redirects++;
                continue;
            }
            if ( !$result instanceof ezcMvcResult )
            {
                throw new ezcMvcControllerException( "The action '{$routingInformation->action}' of controller '{$routingInformation->controllerClass}' did not return an ezcMvcResult object." );
            }

            $this->configuration->runResultFilters( $routingInformation, $request, $result );

            if ( $result->status !== 0 )
            {
                $response = new ezcMvcResponse;
                $response->status = $result->status;
            }
            else
            {
                // want the view manager to use my filters
                $viewHandler = $this->configuration->createView( $routingInformation, $request, $result );

                // create the response
                try
                {
                    $response = $viewHandler->createResponse();
                }
                catch ( Exception $e )
                {
                    $request = $this->configuration->createFatalRedirectRequest( $request, $result, $e );
                    $continue = true;
                    $redirects++;
                    continue;
                }
            }
            $this->configuration->runResponseFilters( $routingInformation, $request, $result, $response );

            // create the response writer
            $responseWriter = $this->configuration->createResponseWriter( $routingInformation, $request, $result, $response );
            // handle the response
            $responseWriter->handleResponse();
        }
        while( $continue );
    }
}
?>
