<?php
/**
 * File containing the ezcMvcResponseFilter class
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * A response filter is responsible for altering the response object.
 *
 * @package MvcTools
 * @version //autogentag//
 */
interface ezcMvcResponseFilter
{
    /**
     * Alters the response object.
     *
     * @param ezcMvcResponse $response Response object to alter.
     */
    public function filterResponse( ezcMvcResponse $response );

    /**
     * Sets options on the filter object
     *
     * @throws ezcMvcFilterHasNoOptionsException if the filter does not support options.
     * @param array $options
     */
    public function setOptions( array $options );
}
?>
