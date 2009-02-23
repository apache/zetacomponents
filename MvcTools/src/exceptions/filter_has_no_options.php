<?php
/**
 * File containing the ezcMvcFilterHasNoOptionsException class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when filter options are set, but the filter doesn't
 * support options.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcFilterHasNoOptionsException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcFilterHasNoOptionsException
     *
     * @param string $filterClass
     */
    public function __construct( $filterClass )
    {
        parent::__construct( "The filter '$filterClass' does not support options." );
    }
}
?>
