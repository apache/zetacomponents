<?php
/**
 * Configure a dispatcher with an instance of an implementation of this
 * interface.
 *
 * You can use any dispatcher with the same configuration class.
 */
interface ezcMvcDispatcherConfiguration
{
    /**
     * Creates the request parser able to produce a revelant request object
     * for this session.
     *
     * @return ezcMvcRequestParser
     */
    public function createRequestParser();

    /**
     * Create the router able to instanciate a revelant controller for this
     * request.
     * 
     * @return ezcMvcRouter
     */
    public function createRouter( ezcMvcRequest $request );

    /**
     * Creates the view handler that is able to process the result.
     *
     * @return ezcMvcViewHandler
     */
    public function createView( ezcMvcRequest $request, ezcMvcResult $result );

    /**
     * Creates a response writer that uses the response and sends its
     * output.
     *
     * @return ezcMvcResponseWriter
     */
    public function createResponseWriter( ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response );

    /**
     * Create the default internal redirect object in case something goes
     * wrong in the views.
     *
     * @return ezcMvcInternalRedirect
     */
    public function createFatalRedirectRequest( Exception $e );
}
?>
