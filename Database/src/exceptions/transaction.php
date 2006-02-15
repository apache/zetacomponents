<?php
/**
 * File containing the ezcDbException class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class provides exception for misc errors that may occur in the component,
 * such as errors parsing database parameters and connecting to the database.
 *
 * @package Database
 */
class ezcDbTransactionException extends ezcDbException
{
    /**
     * Constructs a new exception.
     *
     * $name specifies the name of the name of the handler to use.
     * $known is a list of the known database handlers.
     */
    public function __construct( $msg )
    {
        $message = 'There was a transaction error caused by unmatched beginTransaction()/commit() calls: {$msg}';
        parent::__construct( $message );
    }
}
?>
