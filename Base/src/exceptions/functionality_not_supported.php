<?php
/**
 * File containing the ezcBaseFunctionalityNotSupportedException class.
 *
 * @package Base
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcBaseFunctionalityNotSupportedException is thrown when a requested
 * PHP function was not found.
 *
 * @package Base
 * @version //autogen//
 */
class ezcBaseFunctionalityNotSupportedException extends ezcBaseException
{
    /**
     * Constructs a new ezcBaseFunctionalityNotSupportedException.
     *
     * @param string $message The message to throw
     * @param string $reason The reason for the exception
     */
    function __construct( $message, $reason )
    {
        parent::__construct( "{$message} is not supported. Reason: {$reason}." );
    }
}
?>
