<?php
/**
 * File containing the ezcSearchNetworkException class
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown when a network connection to a search backends gets
 * disconnected permaturely.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchNetworkException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchNetworkException
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        $message = "A network issue occurred: $message";
        parent::__construct( $message );
    }
}
?>
