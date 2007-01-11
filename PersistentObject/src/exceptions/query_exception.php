<?php
/**
 * File containing the ezcPersistentObjectException class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a query failed internally in Persistent Object.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentQueryException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentQueryException with additional information in $msg.
     *
     * @param string $class
     * @return void
     */
    public function __construct( $msg )
    {
        parent::__construct( "A query failed internally in Persistent Object: {$msg}" );
    }
}
?>
