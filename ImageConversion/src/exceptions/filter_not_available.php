<?php
/**
 * File containing the ezcImageFilterNotAvailableException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if the given filter is not available.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageFilterNotAvailableException extends ezcImageException
{
    /**
     * Creates a new ezcImageFilterNotAvailableException.
     * 
     * @param string $filterName The affected filter.
     * @return void
     */
    function __construct( $filterName )
    {
        parent::__construct( "Filter '{$filterName}' does not exist." );
    }
}

?>
