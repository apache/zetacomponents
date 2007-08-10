<?php
/**
 * File containing the ezcTreeTransactionNotStartedException class
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when "commit()" or "rollback()" are called without
 * a matching "beginTransaction()" call.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeTransactionNotStartedException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeTransactionNotStartedException.
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct( "A transaction is not active." );
    }
}
?>
