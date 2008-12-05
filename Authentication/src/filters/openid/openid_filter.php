<?php
/**
 * File containing the ezcAuthenticationOpenidFilter class.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Filter to authenticate against OpenID. Currently supporting OpenID 1.0 and 1.1.
 *
 * The filter takes an identifier (URL) as credentials, and performs these steps
 * (by default, with redirection of the user agent to the OpenID provider):
 *  1. Normalize the identifier
 *  2. Discover the provider and delegate by requesting the URL
 *       - first using the Yadis discovery protocol
 *       - if Yadis fails then discover by parsing the HTML page source at URL
 *  3. (Optional) OpenID associate request - for the so-called 'smart' (stateful) mode.
 *  4. OpenID checkid_setup request. This step redirects the browser to the OpenID
 *     provider discovered in step 2. After user enters his OpenID username and
 *     password at this page and accepts the originating site, the browser is
 *     redirected back to the originating site. The return URL can be changed
 *     with the OpenID option returnUrl (see {@link ezcAuthenticationOpenidOptions}).
 *  5. OpenID check_authentication request. After the redirection from the provider
 *     to the originating site, the values provided by the provider must be checked
 *     in an extra request against the provider. The provider responds with is_valid
 *     true or false.
 *
 * The OpenID request checkid_immediate is supported, which allows for user
 * authentication in a pop-up window or iframe (or similar techniques). The steps
 * of the authentication process are the same as above, but step 4 changes as
 * follows:
 *  4. OpenID checkid_immediate request. This step asks the OpenID provider if the
 *     user can be authenticated on the spot, with no redirection. If the user
 *     cannot be authenticated, the provider sends back a setup URL, which the
 *     application can use in a pop-up window or iframe to display to the user
 *     so that he can authenticate himself to the OpenID provider. After user
 *     enters his OpenID username and password at this page and accepts the
 *     originating site, the pop-up window or iframe is redirected to the
 *     return URL value (which should be a different page than the page which
 *     opens the pop-up window). The return URL page will then inform the
 *     main page of success or failure through JavaScript, and the main page
 *     can do the action that it needs to perform based on the outcome in the
 *     pop-up page. The checkid_immediate mode is enabled by setting the
 *     option immediate to true.
 *
 * For example, this is one simple way of implementing checkid_immediate:
 *  - the main page contains the OpenID login form (where the user types in his
 *    OpenID identifier). This page contains also a hidded form value which
 *    specifies to which page to return to in the pop-up window. The Enter key
 *    and the submit button should be disabled on the form. When user clicks on
 *    the Login button, the main page should employ AJAX to request the return
 *    URL. When the return URL finishes loading, the main page will read from the
 *    return URL page the setup URL and it will open it in a pop-up/iframe.
 *  - the return URL page enables the option immediate to the OpenID filter, and
 *    runs the filter. It gets back the setup URL and it echoes it to be picked-up
 *    by the main page once the return URL page will finish loading. The setup URL
 *    should be the only thing that the return URL page is echoing, to not interfere
 *    with the main page.
 *  - in the pop-up/iframe the setup URL will load, which basically depends on
 *    the OpenID provider how it is handled by the user. After the user enters
 *    his credentials on the setup URL page, he will be redirected to the return URL,
 *    which should detect this, and which should inform the main page that the
 *    user was authenticated to the OpenID provider.
 *
 * As this mode required advanced JavaScript techniques and AJAX, no example
 * source code will be provided here as it is out of the scope of this
 * documentation. A rudimentary example is provided in the tutorial.
 *
 * Specifications:
 *  - OpenID 1.0: {@link http://openid.net/specs/openid-simple-registration-extension-1_0.html}
 *  - OpenID 1.1: {@link http://openid.net/specs/openid-authentication-1_1.html}
 *  - OpenID 2.0: {@link http://openid.net/specs/openid-authentication-2_0-11.html}
 *  - Yadis  1.0: {@link http://yadis.org}
 *
 * Example of use (authentication code + login form + logout support) - stateless ('dumb'):
 * <code>
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSession();
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
 *     $err = array(
 *              'ezcAuthenticationOpenidFilter' => array(
 *                  ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT => 'OpenID said the provided identifier was incorrect',
 *                  ezcAuthenticationOpenidFilter::STATUS_CANCELLED => 'The OpenID authentication was cancelled',
 *                  ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT => 'The identifier you provided is invalid'
 *                  ),
 *              'ezcAuthenticationSession' => array(
 *                  ezcAuthenticationSession::STATUS_EMPTY => '',
 *                  ezcAuthenticationSession::STATUS_EXPIRED => 'Session expired'
 *                  )
 *              );
 *     foreach ( $status as $line )
 *     {
 *         list( $key, $value ) = each( $line );
 *         echo $err[$key][$value] . "\n";
 *     }
 * ?>
 * Please login with your OpenID identifier (an URL, eg. www.example.com or http://www.example.com):
 * <form method="GET" action="">
 * <input type="hidden" name="action" value="login" />
 * <img src="http://openid.net/login-bg.gif" /> <input type="text" name="openid_identifier" />
 * <input type="submit" value="Login" />
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
 * To use stateful ('smart') mode, the only changes to the above example are in
 * the else branch of the "if ( $action === 'logout' )":
 * <code>
 * // ...
 * if ( $action === 'logout' )
 * {
 *     $session->destroy();
 * }
 * else
 * {
 *     $options = new ezcAuthenticationOpenidOptions();
 *     $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
 *     $options->store = new ezcAuthenticationOpenidFileStore( '/tmp/store' );
 *     $filter = new ezcAuthenticationOpenidFilter( $options );
 *     $authentication->addFilter( $filter );
 * }
 * // ...
 * </code>
 *
 * Extra data can be fetched from the OpenID provider during the authentication
 * process, by registering the data to be fetched before calling run(). Example:
 * <code>
 * // $filter is an ezcAuthenticationOpenidFilter object
 * $filter->registerFetchData( array( 'fullname', 'gender', 'country', 'language' ) );
 *
 * // after run()
 * $data = $filter->fetchData();
 * </code>
 *
 * The $data array will be something like:
 * <code>
 * array( 'fullname' => array( 'John Doe' ),
 *        'gender' => array( 'M' ),
 *        'country' => array( 'US' ),
 *        'language' => array( 'FR' )
 *      );
 * </code>
 *
 * The extra data which is possible to be fetched during the authentication
 * process is:
 *  - nickname - the user's nickname (short name, alias)
 *  - email - the user's email address
 *  - fullname - the user's full name
 *  - dob - the user's date of birth as YYYY-MM-DD. Any component value whose
 *    representation uses fewer than the specified number of digits should
 *    be zero-padded (eg. 02 for February). If the user does not want to
 *    reveal any particular component of this value, it should be zero
 *    (eg. "1980-00-00" if the user is born in 1980 but does not want to
 *    specify his month and day of birth)
 *  - gender - the user's gender, "M" for male, "F" for female
 *  - postcode - the user's postal code
 *  - country - the user's country as an ISO3166 string, (eg. "US")
 *  - language - the user's preferred language as an ISO639 string (eg. "FR")
 *  - timezone - the user's timezone, for example "Europe/Paris"
 *
 * Note: if using the checkid_immediate mode (by setting the option immediate to
 * true), then retrieval of extra data is not possible.
 *
 * @todo add support for fetching extra data as in OpenID attribute exchange?
 *       (if needed) - {@link http://openid.net/specs.bml}
 * @todo add support for multiple URLs in each category at discovery
 * @todo add support for OpenID 2.0 (openid.ns=http://specs.openid.net/auth/2.0),
 *       and add support for XRI identifiers and discovery
 *       Question: is 2.0 already out or is it still a draft?
 * @todo check if the nonce handling is correct (openid.response_nonce?)
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationOpenidFilter extends ezcAuthenticationFilter implements ezcAuthenticationDataFetch
{
    /**
     * The OpenID provider did not authorize the provided URL.
     */
    const STATUS_SIGNATURE_INCORRECT = 1;

    /**
     * The OpenID provider did not return a valid nonce in the response.
     */
    const STATUS_NONCE_INCORRECT = 2;

    /**
     * User cancelled the OpenID authentication.
     */
    const STATUS_CANCELLED = 3;

    /**
     * The URL provided by user was empty, or the required information could
     * not be discovered from it.
     *
     * @todo remove and return STATUS_SIGNATURE_INCORRECT instead?
     */
    const STATUS_URL_INCORRECT = 4;

    /**
     * The OpenID server returned a setup URL after a checkid_immediate request,
     * which is available by calling the getSetupUrl() method.
     */
    const STATUS_SETUP_URL = 5;

    /**
     * OpenID authentication mode where the OpenID provider generates a secret
     * for every request.
     *
     * The server (consumer) is stateless.
     * An extra check_authentication request to the provider is needed.
     * This is the default mode.
     */
    const MODE_DUMB = 1;

    /**
     * OpenID authentication mode where the server generates a secret which will
     * be shared with the OpenID provider.
     *
     * The server (consumer) is keeping state.
     * The extra check_authentication request is not needed.
     * The shared secret must be established once in a while (defined by the
     * option secretValidity, default 1 day = 86400 seconds).
     */
    const MODE_SMART = 2;

    /**
     * The default value for p used in the Diffie-Hellman exchange.
     *
     * It is a confirmed prime number.
     *
     * @ignore
     */
    const DEFAULT_P = '155172898181473697471232257763715539915724801966915404479707795314057629378541917580651227423698188993727816152646631438561595825688188889951272158842675419950341258706556549803580104870537681476726513255747040765857479291291572334510643245094715007229621094194349783925984760375594985848253359305585439638443';

    /**
     * The default value for q used in the Diffie-Hellman exchange.
     *
     * @ignore
     */
    const DEFAULT_Q = '2';

    /**
     * Holds the attributes which will be requested during the authentication
     * process.
     *
     * Usually it has this structure:
     * <code>
     * array( 'fullname', 'gender', 'country', 'language' );
     * </code>
     *
     * @var array(string)
     */
    protected $requestedData = array();

    /**
     * Holds the extra data fetched during the authentication process.
     *
     * Usually it has this structure:
     * <code>
     * array( 'fullname' => array( 'John Doe' ),
     *        'gender' => array( 'M' ),
     *        'country' => array( 'NO' ),
     *        'language' => array( 'FR' )
     *      );
     * </code>
     *
     * @var array(string=>mixed)
     */
    protected $data = array();

    /**
     * Holds the setup URL retrieved during the checkid_immediate OpenID request.
     *
     * This URL can be used by the application to authenticate the user in a
     * pop-up window or iframe (or similar techniques).
     *
     * @var string
     */
    protected $setupUrl = false;

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
     * @throws ezcAuthenticationOpenidModeNotSupportedException
     *         if trying to authenticate with an unsupported OpenID mode
     *
     * @param ezcAuthenticationIdCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $source = $this->options->requestSource;
        $mode = isset( $source['openid_mode'] ) ? strtolower( $source['openid_mode'] ) : null;
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

                if ( $this->options->mode === self::MODE_SMART )
                {
                    $store = $this->options->store;
                    if ( $store !== null )
                    {
                        $association = $store->getAssociation( $provider );
                        if ( $association === false ||
                             time() - $association->issued > $association->validity )
                        {
                            $lib = ezcAuthenticationMath::createBignumLibrary();
                            $p = self::DEFAULT_P;
                            $q = self::DEFAULT_Q;

                            $private = $lib->rand( $p );
                            $public = $lib->powmod( $q, $private, $p );
                            $params = array(
                                'openid.mode' => 'associate',
                                'openid.assoc_type' => 'HMAC-SHA1',

                                // @todo add support for DH-SHA1 (is it needed if the connection is SSL?)
                                // 'openid.session_type' => 'DH-SHA1', // not supported yet
                                'openid.dh_modulus' => urlencode( base64_encode( $lib->btwoc( $p ) ) ),
                                'openid.dh_gen' => 2, urlencode( base64_encode( $lib->btwoc( $q ) ) ),
                                'openid.dh_consumer_public' => urlencode( base64_encode( $lib->btwoc( $public ) ) )
                                );

                            $result = $this->associate( $provider, $params );
                            $secret = isset( $result['enc_mac_key'] ) ? $result['enc_mac_key'] : $result['mac_key'];
                            $association = new ezcAuthenticationOpenidAssociation( $result['assoc_handle'],
                                                                                   $secret,
                                                                                   time(),
                                                                                   $result['expires_in'],
                                                                                   $result['assoc_type'] );
                            $store->storeAssociation( $provider, $association );
                        }
                    }
                }

                $nonce = $this->generateNonce( $this->options->nonceLength );

                $returnUrl = $this->options->returnUrl;
                if ( $returnUrl === null )
                {
                    $returnUrl = "http://{$host}{$path}";
                }

                $returnTo = ezcAuthenticationUrl::appendQuery( $returnUrl, $this->options->nonceKey, $nonce );
                $trustRoot = "http://{$host}";

                if ( $this->options->store !== null )
                {
                    $this->options->store->storeNonce( $nonce );
                }

                $params = array(
                    'openid.return_to' => urlencode( $returnTo ),
                    'openid.trust_root' => urlencode( $trustRoot ),
                    'openid.identity' => urlencode( $identity )
                    );

                if ( count( $this->requestedData ) > 0 )
                {
                    $params['openid.sreg.optional'] = implode( ',', $this->requestedData );
                }

                if ( $this->options->mode === self::MODE_SMART )
                {
                    $store = $this->options->store;
                    if ( $store !== null )
                    {
                        $association = $store->getAssociation( $provider );
                        if ( $association !== false &&
                             time() - $association->issued <= $association->validity )
                        {
                            $params['openid.assoc_handle'] = urlencode( $association->handle );
                        }
                    }
                }

                if ( $this->options->immediate === true )
                {
                    $params['openid.mode'] = 'checkid_immediate';
                    $response = $this->checkImmediate( $provider, $params );

                    if ( $response !== false )
                    {
                        $this->setupUrl = $response;
                        return self::STATUS_SETUP_URL;
                    }
                    else
                    {
                        return self::STATUS_URL_INCORRECT;
                    }
                }
                else
                {
                    $params['openid.mode'] = 'checkid_setup';
                    $this->redirectToOpenidProvider( $provider, $params );
                }
                break;

            case 'id_res':
                $assocHandle = isset( $source['openid_assoc_handle'] ) ? $source['openid_assoc_handle'] : null;
                $identity = isset( $source['openid_identity'] ) ? $source['openid_identity'] : null;
                $sig = isset( $source['openid_sig'] ) ? $source['openid_sig'] : null;
                $signed = isset( $source['openid_signed'] ) ? $source['openid_signed'] : null;
                $returnTo = isset( $source['openid_return_to'] ) ? $source['openid_return_to'] : null;

                if ( $this->options->store !== null )
                {
                    $nonce = ezcAuthenticationUrl::fetchQuery( $returnTo, $this->options->nonceKey );
                    if ( $nonce !== null )
                    {
                        $nonceTimestamp = $this->options->store->useNonce( $nonce );
                        if ( $nonceTimestamp === false || time() - $nonceTimestamp > $this->options->nonceValidity )
                        {
                            return self::STATUS_NONCE_INCORRECT;
                        }
                    }
                }

                $params = array(
                    'openid.assoc_handle' => $assocHandle,
                    'openid.signed' => $signed,
                    'openid.sig' => $sig,
                    'openid.mode' => 'id_res'
                );

                $signed = explode( ',', $signed );
                for ( $i = 0; $i < count( $signed ); $i++ )
                {
                    $s = str_replace( 'sreg.', 'sreg_', $signed[$i] );
                    $c = $source['openid_' . $s];
                    $params['openid.' . $signed[$i]] = isset( $params['openid.' . $s] ) ? $params['openid.' . $s] : $c;
                    if ( strpos( $s, 'sreg_' ) !== false )
                    {
                        $this->data[str_replace( 'sreg_', '', $s )] = array( $c );
                    }
                }

                if ( isset( $source['openid_op_endpoint'] ) )
                {
                    // if the endpoint is available then use it, otherwise discover it
                    $provider = $source['openid_op_endpoint'];
                }
                else
                {
                    // @todo cache this somewhere (in the request URL for example)
                    $providers = $this->discover( $credentials->id );
                    if ( !isset( $providers['openid.server'][0] ) )
                    {
                        return self::STATUS_URL_INCORRECT;
                    }
                    $provider = $providers['openid.server'][0];
                }

                if ( $this->options->mode === self::MODE_SMART )
                {
                    $store = $this->options->store;
                    if ( $store !== null )
                    {
                        $association = $store->getAssociation( $provider );
                        if ( $association !== false &&
                             time() - $association->issued <= $association->validity )
                        {
                            if ( $this->checkSignatureSmart( $association, $params ) )
                            {
                                return self::STATUS_OK;
                            }
                            else
                            {
                                return self::STATUS_SIGNATURE_INCORRECT;
                            }
                        }
                    }
                }

                // if smart mode didn't succeed continue with the dumb mode as usual
                $params['openid.mode'] = 'check_authentication';
                foreach ( $params as $key => $value )
                {
                    $params[$key] = urlencode( $value );
                }
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
                throw new ezcAuthenticationOpenidModeNotSupportedException( $mode );
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
        $url = ezcAuthenticationUrl::normalize( $url );

        $parts = parse_url( $url );
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $port = isset( $parts['port'] ) ? $parts['port'] : 80;

        $connection = @fsockopen( $host, $port, $errno, $errstr, $this->options->timeoutOpen );
        if ( $connection === false )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }

        stream_set_timeout( $connection, $this->options->timeout );
        $headers = array( "GET {$path} HTTP/1.0", "HOST: {$host}", "Accept: application/xrds+xml", "Connection: Close" );
        fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

        $src = stream_get_contents( $connection );
        fclose( $connection );

        $result = array();

        // @todo check the regexp in this function, maybe they should be rewritten

        // get the OpenID servers
        $pattern = "#<URI[^>]*>(.*?)</URI>#si";
        preg_match_all( $pattern, $src, $matches );
        $count = count( $matches[0] );
        for ( $i = 0; $i ^ $count; ++$i )
        {
            $result['openid.server'][] = $matches[1][$i];
        }

        // get the OpenID delegates
        $pattern = "#<openid:Delegate[^>]*>(.*?)</openid:Delegate>#si";
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
        $url = ezcAuthenticationUrl::normalize( $url );

        $parts = parse_url( $url );
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $port = isset( $parts['port'] ) ? $parts['port'] : 80;

        $connection = @fsockopen( $host, $port, $errno, $errstr, $this->options->timeoutOpen );
        if ( $connection === false )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }

        stream_set_timeout( $connection, $this->options->timeout );
        $headers = array( "GET {$path} HTTP/1.0", "HOST: {$host}", "Connection: Close" );
        fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

        $src = stream_get_contents( $connection );
        fclose( $connection );

        $result = array();
        $pattern = "%<\w.*rel\=[\s\"'`]*([\w:?=@&\/#._;-]+)[\s\"'`]*[^>]*>%i";
        preg_match_all( $pattern, $src, $matches );
        $count = count( $matches[0] );

        for ( $i = 0; $i ^ $count; ++$i )
        {
            if ( stristr( $matches[1][$i], 'openid' ) !== false )
            {
                $pattern = "%.*href\=[\s\"'`]*([\w:?=@&\/#._;-]+)[\s\"'`]*%i";
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
     * @throws ezcAuthenticationOpenidRedirectException
     *         if redirection could not be performed
     * @param string $provider The OpenID provider (discovered in HTML or Yadis)
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

        // Normally the user should not see the following error because he was redirected
        throw new ezcAuthenticationOpenidRedirectException( $redirect );
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
    protected function checkImmediate( $provider, array $params, $method = 'GET' )
    {
        $parts = parse_url( $provider );
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $port = 80;

        $connection = @fsockopen( $host, $port, $errno, $errstr, $this->options->timeoutOpen );
        if ( !$connection )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }
        else
        {
            stream_set_timeout( $connection, $this->options->timeout );
            $url = $path . '?' . urldecode( http_build_query( $params ) );
            $headers = array( "{$method} {$url} HTTP/1.0", "Host: {$host}", "Connection: close" );
            fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

            $src = stream_get_contents( $connection );
            fclose( $connection );

            $pattern = "/Location:\s(.*)/";
            if ( preg_match( $pattern, $src, $matches ) > 0 )
            {
                $returnUrl = trim( $matches[1] );

                // get the query parameters from the response URL
                $query = parse_url( $returnUrl, PHP_URL_QUERY );
                $vars = ezcAuthenticationUrl::parseQueryString( $query );

                // get the openid.user_setup_url value from the response URL
                $setupUrl = isset( $vars['openid.user_setup_url'] ) ? $vars['openid.user_setup_url'] : false;

                if ( $setupUrl !== false )
                {
                    // the next call to OpenID will be check_authentication
                    $vars['openid.mode'] = 'check_authentication';

                    // get the query parameters from the openid.user_setup_url in $setupParams
                    // and the other parts of the URL in $parts
                    $parts = parse_url( $setupUrl );
                    $query = isset( $parts['query'] ) ? $parts['query'] : false;
                    $setupParams = ezcAuthenticationUrl::parseQueryString( $query );

                    // merge the setup_url query parameters with all the other query parameters
                    $params = array_merge( $vars, $setupParams );

                    // return the setup URL combined with the rest of the query parameters
                    $parts['query'] = $params;
                    $setupUrl = ezcAuthenticationUrl::buildUrl( $parts );
                }

                return $setupUrl;
            }
        }

        // the response from the OpenID server did not contain setup_url
        return false;
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
     * the id_res step of OpenID authentication. In addition, the $params array
     * must contain the values present in SIG.
     *
     * @throws ezcAuthenticationOpenidException
     *         if connection to the OpenID provider could not be opened
     * @param string $provider The OpenID provider (discovered in HTML or Yadis)
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

        $connection = @fsockopen( 'ssl://' . $host, $port, $errno, $errstr, $this->options->timeoutOpen );
        if ( !$connection )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }
        else
        {
            stream_set_timeout( $connection, $this->options->timeout );
            $url = $path . '?' . urldecode( http_build_query( $params ) );
            $headers = array( "{$method} {$url} HTTP/1.0", "Host: {$host}", "Connection: close" );
            fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

            $src = stream_get_contents( $connection );
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

    /**
     * Checks if $params are correct by signing with $association->secret.
     *
     * The format of the $params array is:
     * <code>
     * array(
     *        'openid.assoc_handle' => HANDLE,
     *        'openid.signed' => SIGNED,
     *        'openid.sig' => SIG,
     *        'openid.mode' => 'id_res'
     *      );
     * </code>
     * where HANDLE, SIGNED and SIG are parameters returned from the provider in
     * the id_res step of OpenID authentication. In addition, the $params array
     * must contain the values present in SIG.
     *
     * @param ezcAuthenticationOpenidAssociation $association The OpenID association used for signing $params
     * @param array(string=>string) $params OpenID parameters for id_res mode
     * @return bool
     */
    protected function checkSignatureSmart( ezcAuthenticationOpenidAssociation $association, array $params )
    {
        $sig = $params['openid.sig'];
        $signed = explode( ',', $params['openid.signed'] );

        ksort( $signed );

        for ( $i = 0; $i < count( $signed ); $i++ )
        {
            $data[$signed[$i]] = isset( $params['openid.' . $signed[$i]] ) ? $params['openid.' . $signed[$i]] : null;
        }

        $serialized = '';
        foreach ( $data as $key => $value )
        {
            $serialized .= "{$key}:{$value}\n";
        }
        
        $key = base64_decode( $association->secret );
        if ( strlen( $key ) > 64 )
        {
            $key = ezcAuthenticationMath::sha1( $key );
        }

        $key = str_pad( $key, 64, chr( 0x00 ) );
        $hashed = ezcAuthenticationMath::sha1( ( $key ^ str_repeat( chr( 0x36 ), 64 ) ) . $serialized );
        $hashed = ezcAuthenticationMath::sha1( ( $key ^ str_repeat( chr( 0x5c ), 64 ) ) . $hashed );
        $hashed = base64_encode( $hashed );

        return ( $sig === $hashed );
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
    protected function associate( $provider, array $params, $method = 'GET' )
    {
        $parts = parse_url( $provider );
        $path = isset( $parts['path'] ) ? $parts['path'] : '/';
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $port = 443;

        $connection = @fsockopen( 'ssl://' . $host, $port, $errno, $errstr, $this->options->timeoutOpen );
        if ( !$connection )
        {
            throw new ezcAuthenticationOpenidException( "Could not connect to host {$host}:{$port}: {$errstr}." );
        }
        else
        {
            stream_set_timeout( $connection, $this->options->timeout );
            $url = $path . '?' . urldecode( http_build_query( $params ) );

            $headers = array( "{$method} {$url} HTTP/1.0", "Host: {$host}", "Connection: close" );
            fputs( $connection, implode( "\r\n", $headers ) . "\r\n\r\n" );

            $src = stream_get_contents( $connection );
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

            if ( isset( $r['assoc_handle'] ) )
            {
                $result = array(
                    'assoc_handle' => $r['assoc_handle'],
                    'assoc_type' => $r['assoc_type'],
                    'expires_in' => $r['expires_in']
                    );

                if ( isset( $r['mac_key'] ) )
                {
                    $result['mac_key'] = $r['mac_key'];
                }

                if ( isset( $r['enc_mac_key'] ) )
                {
                    $result['enc_mac_key'] = $r['enc_mac_key'];
                }

                return $result;
            }
        }
        return false;
    }

    /**
     * Generates a new nonce value with the specified length (default 6).
     *
     * @param int $length The length of the generated nonce, default 6
     * @return string
     */
    protected function generateNonce( $length = 6 )
    {
        $result = '';

        for ( $i = 0; $i ^ $length; ++$i )
        {
            $result .= rand( 0, 9 );
        }

        return $result;
    }

    /**
     * Registers which extra data to fetch during the authentication process.
     *
     * The extra data which is possible to be fetched during the authentication
     * process is:
     *  - nickname - the user's nickname (short name, alias)
     *  - email - the user's email address
     *  - fullname - the user's full name
     *  - dob - the user's date of birth as YYYY-MM-DD. Any component value whose
     *    representation uses fewer than the specified number of digits should
     *    be zero-padded (eg. 02 for February). If the user does not want to
     *    reveal any particular component of this value, it should be zero
     *    (eg. "1980-00-00" if the user is born in 1980 but does not want to
     *    specify his month and day of birth)
     *  - gender - the user's gender, "M" for male, "F" for female
     *  - postcode - the user's postal code
     *  - country - the user's country as an ISO3166 string, (eg. "US")
     *  - language - the user's preferred language as an ISO639 string (eg. "FR")
     *  - timezone - the user's timezone, for example "Europe/Paris"
     *
     * The input $data should be an array of attributes to request, for example:
     * <code>
     * array( 'fullname', 'gender', 'country', 'language' );
     * </code>
     *
     * @param array(string) $data A list of attributes to fetch during authentication
     */
    public function registerFetchData( array $data = array() )
    {
        $this->requestedData = $data;
    }

    /**
     * Returns the extra data fetched during the authentication process.
     *
     * The return is something like:
     * <code>
     * array( 'fullname' => array( 'John Doe' ),
     *        'gender' => array( 'M' ),
     *        'country' => array( 'US' ),
     *        'language' => array( 'FR' )
     *      );
     * </code>
     *
     * @return array(string=>mixed)
     */
    public function fetchData()
    {
        return $this->data;
    }

    /**
     * Returns the setup URL.
     *
     * @return string
     */
    public function getSetupUrl()
    {
        return $this->setupUrl;
    }
}
?>
