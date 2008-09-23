<?php
/**
 * A response filter is responsible for altering the response object.
 * 
 * @package MvcTools
 * @version //autogen//
 */
interface ezcMvcResponseFilter
{
    /**
     * Alters the response object.
     * 
     * @param ezcMvcResponse $response Response object to alter.
     * @return void
     */
    public function filterResponse( ezcMvcResponse $response );
}
?>
