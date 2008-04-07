<?php
/**
 * File containing the ezcSearchCanNotConnectException class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when no connection can be made against a search backend.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchCanNotConnectException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchCanNotConnectException for type $type at location $location
     *
     * @param string $type
     * @param string $location
     * @return void
     */
    public function __construct( $type, $location )
    {
        $message = "Could not connect to '$type' at '$location'.";
        parent::__construct( $message );
    }
}
?>
