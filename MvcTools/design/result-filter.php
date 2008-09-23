<?php
/**
 * A result filter is responsible for altering the result object.
 * 
 * @package MvcTools
 * @version //autogen//
 */
interface ezcMvcResultFilter
{
    /**
     * Alters the result object.
     * 
     * @param ezcMvcResult $result Result object to alter.
     * @return void
     */
    public function filterResult( ezcMvcResult $result );
}
?>
