<?php
/**
 * A request filter is responsible for altering the request object.
 * 
 * @package MvcTools
 * @version //autogen//
 */
interface ezcMvcRequestFilter
{
    /**
     * Alters the request object.
     * 
     * @param ezcMvcRequest $request Request object to alter.
     * @return void
     */
    public function filterRequest( ezcMvcRequest $request );
}
?>
