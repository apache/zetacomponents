<?php
/**
 * File containing the ezcDbSchemaException class
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if an invalid class is passed as schema reader to the manager.
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
class ezcDbSchemaInvalidSchemaException extends ezcDbSchemaException
{
    /**
     * Constructs an ezcDbSchemaInvalidSchemaException with an optional message.
     *
     * @param string $message
     */
    function __construct( $message = null )
    {
        $messagePart = $message !== null ? " ($message)" : "";
        parent::__construct( "The schema is invalid.$messagePart" );
    }
}
?>
