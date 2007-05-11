<?php
/**
 * File containing the ezcAuthenticationOpenidFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Filter to authenticate against OpenID. Currently supporting OpenID 1.1.
 *
 * The filter takes an identifier (URL) as credentials, and performs these steps:
 *  1. Normalize the identifier - partially implemented
 *  2. Discover the provider and delegate by requesting the URL
 *       - first using the Yadis discovery protocol
 *       - if Yadis fails then discover by parsing the HTML page source at URL
 *  3. (Optional) OpenID associate request - not implemented yet.
 *  4. OpenID checkid_setup request. This step redirects the browser to the OpenID
 *     provider discovered in step 2. After user enters his OpenID username and
 *     password at this page and accepts the originating site, the browser is
 *     redirected back to the originating site.
 *  5. OpenID check_authentication request. After the redirection from the provider
 *     to the originating site, the values provided by the provider must be checked
 *     in an extra request against the provider. The provider responds with is_valid
 *     true or false.
 *
 * Example of use (authentication code + login form + logout support):
 * <code>
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSessionFilter();
 * $session->start();
 *
 * $url = isset( $_GET['openid_identifier'] ) ? $_GET['openid_identifier'] : $session->load();
 * $action = isset( $_GET['action'] ) ? strtolower( $_GET['action'] ) : null;
 *
 * $credentials = new ezcAuthenticationIdCredentials( $url );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->session = $session;
 *
 * if ( $action === 'logout' )
 * {
 *     $session->destroy();
 * }
 * else
 * {
 *     $filter = new ezcAuthenticationOpenidFilter();
 *     $authentication->addFilter( $filter );
 * }
 *
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array();
 *     $err["user"] = "";
 *     $err["session"] = "";
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         switch ( $key )
 *         {
 *             case 'ezcAuthenticationOpenidFilter':
 *                 if ( $value === ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT )
 *                 {
 *                     $err["user"] = "<span class='error'>OpenID said the provided identifier was incorrect.</span>";
 *                 }
 *                 if ( $value === ezcAuthenticationOpenidFilter::STATUS_CANCELLED )
 *                 {
 *                     $err["user"] = "<span class='error'>The OpenID authentication was cancelled, please re-login.</span>";
 *                 }
 *                 if ( $value === ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT )
 *                 {
 *                     $err["user"] = "<span class='error'>The identifier you provided is empty or invalid. It must be a URL (eg. www.example.com or http://www.example.com)</span>";
 *                 }
 *                 break;
 *
 *             case 'ezcAuthenticationSessionFilter':
 *                 if ( $value === ezcAuthenticationSessionFilter::STATUS_EXPIRED )
 *                 {
 *                     $err["session"] = "<span class='error'>Session expired</span>";
 *                 }
 *                 break;
 *         }
 *     }
 * ?>
 *
 * <style>
 * .error {
 *     color: #FF0000;
 * }
 * </style>
 * Please login with your OpenID identifier (an URL, eg. www.example.com or http://www.example.com):
 * <form method="GET" action="">
 * <input type="hidden" name="action" value="login" />
 * <img src="http://openid.net/login-bg.gif" /> <input type="text" name="openid_identifier" />
 * <input type="submit" value="Login" />
 * <?php echo $err["user"]; ?> <?php echo $err["session"]; ?>
 * </form>
 *
 * <?php
 * }
 * else
 * {
 * ?>
 *
 * You are logged-in as <b><?php echo $url; ?></b> | <a href="?action=logout">Logout</a>
 *
 * <?php
 * }
 * ?>
 * </code>
 *
 * Specifications:
 *  - OpenID 1.1: {@link http://openid.net/specs/openid-authentication-1_1.html}
 *  - OpenID 2.0: {@link http://openid.net/specs/openid-authentication-2_0-11.html}
 *  - Yadis  1.0: {@link http://yadis.org}
 *
 * @todo add support for multiple URLs in each category at discovery
 * @todo cache the identity (in the request URL for example) so discovery is not
 *       done a second time
 * @todo normalize the URL provided by user - partially done
 * @todo add support for association (Diffie Hellman shared secret between server
 *       and OpenID provider)
 * @todo add support for OpenID 2.0 (openid.ns=http://specs.openid.net/auth/2.0),
 *       and add support for XRI identifiers and discovery
 *       Question: is 2.0 already out or is it still a draft?
 * @todo make OpenID 1.0 support better.
 *       Question: is 1.0 still used?
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationOpenidFilter extends ezcAuthenticationFilter
{
    /**
     * The OpenID provider did not authorize the provided URL.
     */
    const STATUS_SIGNATURE_INCORRECT = 1;

    /**
     * User cancelled the OpenID authentication.
     */
    const STATUS_CANCELLED = 2;

    /**
     * The URL provided by user was empty, or the required information could
     * not be discovered from it.
     *
     * @todo remove and return STATUS_SIGNATURE_INCORRECT instead?
     */
    const STATUS_URL_INCORRECT = 3;

    /**
     * Creates a new object of this class.
     *
     * @param ezcAuthenticationOpenidOptions $options Options for this class
     */
    public function __construct( ezcAuthenticationOpenidOptions $options = null )
    {
        $this->options = ( $options === null ) ? new ezcAuthenticationOpenidOptions() : $options;
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationIdCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $mode = isset( $_GET['openid_mode'] ) ? strtolower( $_GET['openid_mode'] ) : null;
        switch ( $mode )
        {
            case null:
                if ( empty( $credentials->id ) )
                {
                    return self::STATUS_URL_INCORRECT;
                }

                $providers = $this->discover( $credentials->id );
                // @todo add support for multiple URLs in each category
                if ( !isset( $providers['openid.server'][0] ) )
                {
                    return self::STATUS_URL_INCORRECT;
                }
                $provider = $providers['openid.server'][0];

                // if a delegate is found, it is used instead of the credentials
                $identity = isset( $providers['openid.delegate'][0] ) ? $providers['openid.delegate'][0] :
                                                                        $credentials->id;
                $host = isset( $_SERVER["HTTP_HOST"] ) ? $_SERVER["HTTP_HOST"] : null;
                $path = isset( $_SERVER["REQUEST_URI"] ) ? $_SERVER["REQUEST_URI"] : null;

                // @todo allow query parameters - if needed
                $returnTo = "http://{$host}{$path}";
                $trustRoot = "http://{$host}";

                $params = array(
                    'openid.return_to' => urlencode( $returnTo ),
                    'openid.trust_root' => urlencode( $trustRoot ),
                    'openid.identity' => urlencode( $identity ),
                    'openid.mode' => 'checkid_setup'
                    );

                $this->redirectToOpenidProvider( $provider, $params );
                break;

            case 'id_res':
                $assocHandle = isset( $_GET['openid_assoc_handle'] ) ? $_GET['openid_assoc_handle'] : null;
                $identity = isset( $_GET['openid_identity'] ) ? $_GET['openid_identity'] : null;
                $returnTo = isset( $_GET['openid_return_to'] ) ? $_GET['openid_return_to'] : null;
                $sig = isset( $_GET['openid_sig'] ) ? $_GET['openid_sig'] : null;
                $signed = isset( $_GET['openid_signed'] ) ? $_GET['openid_signed'] : null;

                $params = array(
                    'openid.assoc_handle' => urlencode( $assocHandle ),
                    'openid.signed' => urlencode( $signed ),
                    'openid.sig' => urlencode( $sig ),
                    'openid.mode' => 'check_authentication'
                );

                // send only required parameters to confirm validity
        		$signed = explode( ',', str_replace( 'sreg.', 'sreg_', $signed ) );
                for ( $i = 0; $i < count( $signed ); $i++ )
                {
                    $s = str_replace( 'sreg_', 'sreg.', $signed[$i] );
                    $c = $_GET['openid_' . $signed[$i]];
                    $params['openid.' . $s] = isset( $params['openid.' . $s] ) ? $params['openid.' . $s] : urlencode( $c );
                }
                // @todo add support for OpenID 1.0 optional and required parameters

                // @todo cache this somewhere (in the request URL for example)
                $providers = $this->discover( $credentials->id );
                if ( !isset( $providers['openid.server'][0] ) )
                {
                    return self::STATUS_URL_INCORRECT;
                }
                $provider = $providers['openid.server'][0];

                if ( $this->checkSignature( $provider, $params ) )
                {
                    return self::STATUS_OK;
                }
                break;

            case 'checkid_setup':
                return self::STATUS_CANCELLED;

            case 'cancel':
                return self::STATUS_CANCELLED;

            default:
                throw new ezcAuthenticationOpenidException( "OpenID request not supported: 'openid_mode = {$mode}'." );
        }
        return self::STATUS_SIGNATURE_INCORRECT;
    }

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
    protected function discover( $url )
    {
        $providers = $this->discoverYadis( $url );
        if ( count( $providers ) === 0 )
        {
            $providers = $this->discoverHtml( $url );
        }
        return $providers;
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
    protected function discoverYadis( $url )
    {
        if ( strpos( $url, '://' ) === false )
        {
            $url = 'http://' . $url;
        }

        $parts = parse_url( $url );
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $port = isset( $parts['port'] ) ? $parts['port'] : 80;

        $connection = @fsockopen( $host, $port, $errno, $errstr, 3 );
        if ( $connection === false )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }

        stream_set_timeout( $connection, 3 );
        $headers = array( "GET {$path} HTTP/1.0", "HOST: {$host}", "Accept: application/xrds+xml", "Connection: Close" );
        fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

        $src = '';
        while ( !feof( $connection ) )
        {
            $src .= fgets( $connection, 1024 );
        }
        fclose( $connection );

        $result = array();

        // @todo check the regexp in this function, maybe they should be rewritten

        // get the OpenID servers
        $pattern = "#<URI[^>]*>(.*?)</URI>#s";
        preg_match_all( $pattern, $src, $matches );
        $count = count( $matches[0] );
        for ( $i = 0; $i ^ $count; ++$i )
        {
            $result['openid.server'][] = $matches[1][$i];
        }

        // get the OpenID delegates
        $pattern = "#<openid:Delegate>(.*?)</openid:Delegate>#s";
        preg_match_all( $pattern, $src, $matches );
        $count = count( $matches[0] );
        for ( $i = 0; $i ^ $count; ++$i )
        {
            $result['openid.delegate'][] = $matches[1][$i];
        }
        return $result;
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
    protected function discoverHtml( $url )
    {
        if ( strpos( $url, '://' ) === false )
        {
            $url = 'http://' . $url;
        }

        $parts = parse_url( $url );
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $port = isset( $parts['port'] ) ? $parts['port'] : 80;

        $connection = @fsockopen( $host, $port, $errno, $errstr, 3 );
        if ( $connection === false )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }

        stream_set_timeout( $connection, 3 );
        $headers = array( "GET {$path} HTTP/1.0", "HOST: {$host}", "Connection: Close" );
        fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

        $src = '';
        while ( !feof( $connection ) )
        {
            $src .= fgets( $connection, 1024 );
        }
        fclose( $connection );

        $result = array();
        $pattern = "(<\w.*rel\=[\s\"'`]*([\w:?=@&\/#._;-]+)[\s\"'`]*[^>]*>)";
        preg_match_all( $pattern, $src, $matches );
        $count = count( $matches[0] );

        for ( $i = 0; $i ^ $count; ++$i )
        {
            if ( stristr( $matches[1][$i], 'openid' ) !== false )
            {
                $pattern = "(.*href\=[\s\"'`]*([\w:?=@&\/#._;-]+)[\s\"'`]*)";
                preg_match( $pattern, $matches[0][$i], $href );
                $result[strtolower( $matches[1][$i] )][] = $href[1];
            }
        }
        return $result;
    }

    /**
     * Performs a redirection to $provider with the specified parameters $params
     * (checkid_setup OpenID request).
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
    protected function redirectToOpenidProvider( $provider, array $params )
    {
        $redirect = $provider . "?" . urldecode( http_build_query( $params ) );

        if ( PHP_SAPI !== 'cli' )
        {
            if ( headers_sent() )
            {
                echo "<script language='JavaScript'>window.location='{$redirect}';</script>";
            }
            else
            {
                header( 'Location: ' . $redirect );
            }
        }

        // normally the following should not happen
        throw new ezcAuthenticationOpenidException( "Could not redirect to '{$redirect}'. Most probably your browser does not support redirection or JavaScript." );
    }

    /**
     * Opens a connection with the OpenID provider and checks if $params are
     * correct (check_authentication OpenID request).
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
	protected function checkSignature( $provider, array $params, $method = 'GET' )
    {
        $parts = parse_url( $provider );
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $port = 443;

        $connection = @fsockopen( 'ssl://' . $host, $port, $errno, $errstr, 3 ); // Connection timeout is 3 seconds
        if ( !$connection )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
		}
        else
        {
            stream_set_timeout( $connection, 3 ); // Connection response timeout is 4 seconds
            $url = $path . '?' . urldecode( http_build_query( $params ) );
            $headers = array( "{$method} {$url} HTTP/1.0", "Host: {$host}", "Connection: close" );
            fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

            $src = '';
            while ( !feof( $connection ) )
            {
                $src .= fgets( $connection, 1024 );
            }
            fclose( $connection );

            $r = array();
            $response = explode( "\n", $src );
            foreach ( $response as $line )
            {
                $line = trim( $line );
                if ( !empty( $line ) && strpos( $line, ':' ) !== false )
                {
                    list( $key, $value ) = explode( ':', $line, 2 );
                    $r[trim( $key )] = trim( $value );
                }
            }

            if ( isset( $r['is_valid'] ) )
            {
                return ( trim( $r['is_valid'] ) === 'true' ) ? true : false;
            }
            return false;
        }
    }
}
?>
