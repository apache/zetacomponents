<?php
/**
 * File containing the ezcQueryException class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for exceptions related to the SQL abstraction.
 *
 * @package Database
 * @version //autogentag//
 */
class ezcQueryException extends ezcBaseException
{

    /**
     * Constructs an ezcQueryException with the highlevel error
     * message $message and the errorcode $code.
     *
     * @param string $message
     * @param string $additionalInfo
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
