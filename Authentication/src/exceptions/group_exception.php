<?php
/**
 * File containing the ezcAuthenticationGroupException class.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Thrown when an error comes up with grouped filters authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationGroupException extends ezcAuthenticationException
{
    /**
     * Constructs a new ezcAuthenticationGroupException with error message
     * $message.
     *
     * @param string $message Message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
