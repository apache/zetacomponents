<?php
interface ezcMvcResponseWriter
{
    /**
     * Creates a new response writer object
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response );

    /**
     * Takes the raw protocol depending response body, and the protocol
     * abstract response headers and forges a response to the client
     */
    public function handleResponse();

    /**
     * Should be called after the handleResponse() method created
     * protocol-dependent headers from the raw headers in the response object,
     * but before it is rendered for final output.
     */
    protected function runResponseFilters();
}
?>
