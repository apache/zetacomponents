<?php
/**
 * File containing the ezcPersistentObjectException class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * General exception class for the PersistentObject package.
 *
 * All exceptions in the persistent object package are derived from this exception.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectException extends ezcBaseException
{

    /**
     * Constructs a new ezcPersistentObjectException with error message $message and error code $code.
     *
     * @param string $message
     * @param int $code
     * @return void
     */
    public function __construct( $message, $reason = null )
    {
        $message = $reason !== null ? "$message ($reason)" : $message;
        parent::__construct( $message );
    }
}
?>
