<?php
class ezcMvcProductionDispatcher implements ezcMvcDispatcher
{
    public function __construct( ezcMvcDispatcherConfiguration $configuration )
    {
        $this->configuration = $configuration;
    }

    public function run()
    {
        // create the request parser
        $requestParser = $this->configuration->createRequestParser();
        // create the request
        $request = $requestParser->createRequest();

        // start of the request goto-label
    startRequest:

        // create the router from the configuration
        $router = $this->configuration->createRouter( $request );

        // router creates the controller
        // run your request/result filters in the controller!
        $controller = $router->createController();

        // run the controller
        $result = $controller->createResult();

        if ( $result instanceof ezcMvcInternalRedirect )
        {
            $request = $result->request;
            goto startRequest;
        }

        // want the view manager to use my filters
        $viewHandler = $this->configuration->createView( $request, $result );

        /**
         * At this point, we could use $viewHandler->handle() to finish the job
         */
        // create the response
        $response = $viewHandler->createResponse();

        if ( $response instanceof Exception )
        {
            $request = $this->configuration->createFatalRedirectRequest( $response );
            goto startRequest;
        }

        // create the response writer
        $responseWriter = $this->configuration->createResponseWriter( $request, $result, $response );
        // handle the response
        $responseWriter->handleResponse();
    }
}
?>
