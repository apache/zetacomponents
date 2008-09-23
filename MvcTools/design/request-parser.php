<?php
/**
 * Interface defining the request parser classes.
 *
 * The request parser is the only layer that should directly access the request
 * variables, in order to instanciate an ezcMvcRequest. The instance of ezcMvcRequest
 * will be used by the router and the router manager, the controller, the view handler
 * and the view manager.
 * The created ezcMvcRequest should handle filtering the request variables, but allows
 * getting the raw value of a variable as well.
 * 
 * @package MvcTools
 * @version //autogen//
 * @mainclass
 */
interface ezcMvcRequestParser
{  
    /**
     * Parses the request and creates  request object.
     *
     * @return ezcMvcRequest
     */
    public function createRequest();
}
?>
