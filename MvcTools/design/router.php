<?php
/**
 * Interface defining router classes.
 *
 * A router creates an instance of the controller to use for the current request.
 * It should use the passed instance of ezcMvcRequest to select the controller.
 * 
 * @package MvcTools
 * @version //autogen//
 * @mainclass
 */
interface ezcMvcRouter
{ 
    /**
     * Creates a new router object
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request );

    /**
     * Returns the controller for this request.
     *
     * @return ezcMvcController
     */
    public function createController( ezcMvcRequest $request );
}  
?>
