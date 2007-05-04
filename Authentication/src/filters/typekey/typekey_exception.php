<?php
/**
 * File containing the ezcAuthenticationTypekeyException class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Thrown when an exceptional state occurs in the TypeKey authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationTypekeyException extends ezcAuthenticationException
{
    /**
     * Constructs a new ezcAuthenticationTypekeyException with error message
     * $message and error code $code.
     *
     * @param string $message Message to throw
     * @param int $code Error code
     */
    public function __construct( $message, $code = false )
    {
        if ( $code === false )
        {
            parent::__construct( $message );
        }
        else
        {
            parent::__construct( $message . " ({$code})" );
        }
    }
}
?>
