<?php
/**
 * Interface defining controller classes.
 * 
 * Controllers process the client's request and returns variables usable by
 * the view-manager in an instance of an ezcMvcResult.
 * Controllers should not access request variables directly but should use the
 * passed ezcMvcRequest.
 * The process is done through the createResult() method, but is not limited
 * to use protected
 * nor private methods. The result of running a controller is an instance of
 * ezcMvcResult.
 *
 * @package MvcTools
 * @version //autogen//
 * @mainclass
 */
interface ezcMvcController
{
    /**
     * Creates a new controller object
     *
     * @param ezcMvcRequest $request
     * @param array() $variables
     */
    public function __construct( ezcMvcRequest $request, array $variables );

    /**
     * Runs the controller to process the query and return variables usable
     * to render the view. 
     * 
     * @return ezcMvcResult|ezcMvcInternalRedirect
     */
    public function createResult();

    /**
     * Should be called at the start of the createResult() method to run
     * the request filters.
     */
    protected function runRequestFilters();

    /**
     * Should be called at the end of the createResult() method to run
     * the result filters.
     */
    protected function runResultFilters();
}
?>
