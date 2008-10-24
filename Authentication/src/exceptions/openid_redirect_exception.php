<?php
/**
 * File containing the ezcAuthenticationOpenidRedirectException class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Thrown when the client could not be redirected in the OpenID authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationOpenidRedirectException extends ezcAuthenticationOpenidException
{
    /**
     * Constructs a new ezcAuthenticationOpenidRedirectException concerning $url.
     *
     * @param string $url The URL where the client could not be redirected
     */
    public function __construct( $url )
    {
        parent::__construct( "Could not redirect to '{$url}'. Most probably your browser does not support redirection or JavaScript." );
    }
}
?>
