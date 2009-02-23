<?php
/**
 * File containing the ezcAuthenticationOpenidWrapper class.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Class which exposes the protected methods from the OpenID filter.
 *
 * For testing purposes only.
 *
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationOpenidWrapper extends ezcAuthenticationOpenidFilter
{
    /**
     * Discovers the OpenID server information from the provided URL.
     *
     * First the Yadis discovery is tried. If it doesn't succeed, then the HTML
     * discovery is tried.
     *
     * The format of the returned array is (example):
     * <code>
     *   array( 'openid.server' => array( 0 => 'http://www.example-provider.com' ),
     *          'openid.delegate' => array( 0 => 'http://www.example-delegate.com' )
     *        );
     * </code>
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the URL could not be opened
     * @param string $url URL to connect to and discover the OpenID information
     * @return array(string=>array)
     */
    public function discover( $url )
    {
        return parent::discover( $url );
    }

    /**
     * Discovers the OpenID server information from the provided URL using Yadis.
     *
     * The format of the returned array is (example):
     * <code>
     *   array( 'openid.server' => array( 0 => 'http://www.example-provider.com' ),
     *          'openid.delegate' => array( 0 => 'http://www.example-delegate.com' )
     *        );
     * </code>
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the URL could not be opened
     * @param string $url URL to connect to and discover the OpenID information
     * @return array(string=>array)
     */
    public function discoverYadis( $url )
    {
        return parent::discoverYadis( $url );
    }

    /**
     * Discovers the OpenID server information from the provided URL by parsing
     * the HTML page source.
     *
     * The format of the returned array is (example):
     * <code>
     *   array( 'openid.server' => array( 0 => 'http://www.example-provider.com' ),
     *          'openid.delegate' => array( 0 => 'http://www.example-delegate.com' )
     *        );
     * </code>
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the URL could not be opened
     * @param string $url URL to connect to and discover the OpenID information
     * @return array(string=>array)
     */
    public function discoverHtml( $url )
    {
        return parent::discoverHtml( $url );
    }

    /**
     * Performs a redirection to $provider with the specified parameters $params.
     *
     * The format of the checkid_setup $params array is:
     * <code>
     * array(
     *        'openid.return_to' => urlencode( URL ),
     *        'openid.trust_root' => urlencode( URL ),
     *        'openid.identity' => urlencode( URL ),
     *        'openid.mode' => 'checkid_setup'
     *      );
     * </code>
     *
     * @throws ezcAuthenticationOpenidException
     *         if redirection could not be performed
     * @param string $provider The OpenID provider
     * @param array(string=>string) $params OpenID parameters for checkid_setup
     */
    public function redirectToOpenidProvider( $provider, array $params )
    {
        return parent::redirectToOpenidProvider( $provider, $params );
    }

    /**
     * Connects to $provider (checkid_immediate OpenID request) and returns an
     * URL (setup URL) which can be used by the application in a pop-up window.
     *
     * The format of the check_authentication $params array is:
     * <code>
     * array(
     *        'openid.return_to' => urlencode( URL ),
     *        'openid.trust_root' => urlencode( URL ),
     *        'openid.identity' => urlencode( URL ),
     *        'openid.mode' => 'checkid_immediate'
     *      );
     * </code>
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the OpenID provider could not be opened
     * @param string $provider The OpenID provider (discovered in HTML or Yadis)
     * @param array(string=>string) $params OpenID parameters for checkid_immediate mode
     * @param string $method The method to connect to the provider (default GET)
     * @return bool
     */
    public function checkImmediate( $provider, array $params, $method = 'GET' )
    {
        return parent::checkImmediate( $provider, $params, $method );
    }

    /**
     * Opens a connection with the OpenID provider and checks if $params are
     * correct.
     *
     * The format of the check_authentication $params array is:
     * <code>
     * array(
     *        'openid.assoc_handle' => urlencode( HANDLE ),
     *        'openid.signed' => urlencode( SIGNED ),
     *        'openid.sig' => urlencode( SIG ),
     *        'openid.mode' => 'check_authentication'
     *      );
     * </code>
     * where HANDLE, SIGNED and SIG are parameters returned from the provider in
     * the id_res step of OpenID authentication.
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the OpenID provider could not be opened
     * @param string $provider The OpenID provider (discovered in HTML or XRDF)
     * @param array(string=>string) $params OpenID parameters for check_authentication mode
     * @param string $method The method to connect to the provider (default GET)
     * @return bool
     */
    public function checkSignature( $provider, array $params, $method = 'GET' )
    {
        return parent::checkSignature( $provider, $params, $method );
    }

    /**
     * Checks if $params are correct by signing with the $association.
     *
     * The format of the $params array is:
     * <code>
     * array(
     *        'openid.assoc_handle' => urlencode( HANDLE ),
     *        'openid.signed' => urlencode( SIGNED ),
     *        'openid.sig' => urlencode( SIG ),
     *        'openid.mode' => 'check_authentication'
     *      );
     * </code>
     * where HANDLE, SIGNED and SIG are parameters returned from the provider in
     * the id_res step of OpenID authentication.
     *
     * @param ezcAuthenticationOpenidAssociation $association The OpenID association used for signing $params
     * @param array(string=>string) $params OpenID parameters for check_authentication mode
     * @return bool
     */
    public function checkSignatureSmart( ezcAuthenticationOpenidAssociation $association, array $params )
    {
        return parent::checkSignatureSmart( $association, $params );
    }

    /**
     * Attempts to establish a shared secret with the OpenID provider and
     * returns it (for "smart" mode).
     *
     * If the shared secret is still in its validity period, then it will be
     * returned instead of establishing a new one.
     *
     * If the shared secret could not be established the null will be returned,
     * and the OpenID connection will be in "dumb" mode.
     *
     * The format of the returned array is:
     *   array( 'assoc_handle' => assoc_handle_value,
     *          'mac_key' => mac_key_value
     *        )
     *
     * @param string $provider The OpenID provider (discovered in HTML or Yadis)
     * @param array(string=>string) $params OpenID parameters for associate mode
     * @param string $method The method to connect to the provider (default GET)
     * @return array(string=>mixed)||null
     */
    public function associate( $provider, array $params, $method = 'GET' )
    {
        return parent::associate( $provider, $params, $method );
    }

    /**
     * Generates a new nonce value with the specified length (default 6).
     *
     * @param int $length The length of the generated nonce, default 6
     * @return string
     */
    public function generateNonce( $length = 6 )
    {
        return parent::generateNonce( $length );
    }
}
?>
