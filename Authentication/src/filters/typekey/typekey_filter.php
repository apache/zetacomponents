<?php
/**
 * File containing the ezcAuthenticationTypekeyFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Filter to authenticate against TypeKey.
 *
 * The filter deals with the validation of information returned by the TypeKey
 * server in response to a login command.
 *
 * In order to access a protected page, user logs in by using a request like:
 *   https://www.typekey.com/t/typekey/login?
 *     t=391jbj25WAQANzJrKvb5&_return=http://example.com/login.php
 * (link split on two rows for clarity),
 * where:
 *   t = TypeKey token generated for each TypeKey account.
 *       It is found at https://www.typekey.com/t/typekey/prefs.
 *       This value is also used as a session key, so it must be passed to the
 *       page performing the TypeKey authentication via the _return URL.
 *   _return = the URL where to return after user logs in with his TypeKey
 *             username and password.
 *             The URL can contain query arguments, such as the value t which
 *             can be used as a session key.
 *
 * The login link can also contain these 2 optional values:
 *   v = TypeKey version to use. Default is 1.
 *   need_email = the mail address which was used to register with TypeKey.
 *
 * So the TypeKey authentication filter will run in the _return page and will
 * verify the signature and the other information in the URL.
 *
 * The application link (eg. http://example.com) must be registered in the
 * TypeKey preferences page (https://www.typekey.com/t/typekey/prefs) in one
 * of the 5 lines from "Your Weblog Preferences", otherwise TypeKey will
 * not accept the login request.
 *
 * The link returned by TypeKey after user logs in with his TypeKey username
 * and password looks like this:
 *
 * http://example.com/typekey.php?
 *   ts=1177319974&email=5098f1e87a608675ded4d933f31899cae6b4f968&
 *   name=ezc&nick=ezctest&
 *   sig=I9Dop72+oahY82bpL7ymBoxdQ+k=:Vj/t7oZVL2zMSzwHzdOWop5NG/g=
 * (link split on four rows for clarity),
 * where:
 *   ts = timestamp (in seconds) of the TypeKey server time at login.
 *        The TypeKey filter compares this timestamp with the application
 *        server's timestamp to make sure the login is in a reasonable
 *        time window (specified by the validity option). Don't use a too small
 *        value for validity, because servers are not always synchronized.
 *   email = sha1 hash of "mailto:{$mail}", where $mail is the mail address
 *           used to register with TypeKey.
 *   nick = TypeKey nickname/display name.
 *   sig = signature which must be validated by the TypeKey filter.
 *
 * For more information on the login request and the TypeKey response link see
 * {@link http://www.sixapart.com/typekey/api}.
 *
 * Example:
 * <code>
 * <?php
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSessionFilter();
 * $session->start();
 * 
 * // $token is used as a key in the session to store the authenticated state between requests
 * $token = isset( $_GET['token'] ) ? $_GET['token'] : $session->load();
 * 
 * $credentials = new ezcAuthenticationIdCredentials( $token );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->session = $session;
 * 
 * $filter = new ezcAuthenticationTypekeyFilter();
 * $authentication->addFilter( $filter );
 * // add other filters if needed
 *
 * if ( !$authentication->run() )
 * {
 *     echo "<b>Not logged-in</b>. ";
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         switch ( $key )
 *         {
 *             case 'ezcAuthenticationTypekeyFilter':
 *                 if ( $value === ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_INCORRECT )
 *                 {
 *                     echo "Signature returned by TypeKey is incorrect.";
 *                 }
 *                 if ( $value === ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_EXPIRED )
 *                 {
 *                     echo "Did not login in a reasonable amount of time. The application server and the TypeKey server might be desynchronized.";
 *                 }
 *                 break;
 * 
 *             case 'ezcAuthenticationSessionFilter':
 *                 if ( $value === ezcAuthenticationSessionFilter::STATUS_EXPIRED )
 *                 {
 *                     echo "Session expired.";
 *                 }
 *                 if ( $value === ezcAuthenticationSessionFilter::STATUS_EMPTY )
 *                 {
 *                     echo "Session empty.";
 *                 }
 *                 break;
 *         }
 *     }
 * ?>
 * <!-- OnSubmit hack to append the value of t to the _return value, to pass
 *      the TypeKey token after the TypeKey request -->
 * <form method="GET" action="https://www.typekey.com/t/typekey/login" onsubmit="document.getElementById('_return').value += '?token=' + document.getElementById('t').value;">
 * TypeKey token: <input type="text" name="t" id="t" />
 * <input type="hidden" name="_return" id="_return" value="http://localhost/typekey.php" />
 * <input type="submit" />
 * </form>
 * <?
 * }
 * else
 * {
 *     // authentication succeeded, so allow the user to see his content
 *     echo "<b>Logged-in</b>";
 * }
 * ?>
 * </code>
 *
 * Another method, which doesn't use JavaScript, is using an intermediary page
 * which saves the token in the session, then calls the TypeKey login page:
 *
 * - original file is modified as follows:
 * <code>
 * <form method="GET" action="save_typekey.php">
 * TypeKey token: <input type="text" name="t" id="t" />
 * <input type="hidden" name="_return" id="_return" value="http://localhost/typekey.php" />
 * <input type="submit" />
 * </form>
 * </code>
 *
 * - intermediary page:
 * <code>
 * <?php
 * // no headers should be sent before calling $session->start()
 * $session = new ezcAuthenticationSessionFilter();
 * $session->start();
 *
 * // $token is used as a key in the session to store the authenticated state between requests
 * $token = isset( $_GET['t'] ) ? $_GET['t'] : $session->load();
 * if ( $token !== null )
 * {
 *     $session->save( $token );
 * }
 * $url = isset( $_GET['_return'] ) ? $_GET['_return'] : null;
 * $url .= "?token={$token}";
 * header( "Location: https://www.typekey.com/t/typekey/login?t={$token}&_return={$url}" );
 * ?>
 * </code>
 *
 * @property string $method
 *           Which PHP extension to use for big number operations (bcmath or gmp).
 *           Depending on which extension is installed, the value of this property
 *           will be filled in automatically, but the value can be overriden.
 *           before calling run().
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationTypekeyFilter extends ezcAuthenticationFilter
{
    /**
     * The request does not contain the needed information (like $_GET['sig']).
     */
    const STATUS_SIGNATURE_MISSING = 1;

    /**
     * Signature verification was incorect.
     */
    const STATUS_SIGNATURE_INCORRECT = 2;

    /**
     * Login is outside of the timeframe.
     */
    const STATUS_SIGNATURE_EXPIRED = 3;

    /**
     * The file containing the TypeKey public keys.
     */
    const PUBLIC_KEYS_URL = 'http://www.typekey.com/extras/regkeys.txt';

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Creates a new object of this class.
     *
     * @throws ezcBaseExtensionNotFoundException
     *         if neither of the PHP gmp and bcmath extensions are installed
     * @param ezcAuthenticationTypekeyOptions $options Options for this class
     */
    public function __construct( ezcAuthenticationTypekeyOptions $options = null )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
            {
                throw new ezcBaseExtensionNotFoundException( 'gmp | bcmath', null, "PHP not compiled with --enable-bcmath or --with-gmp." );
            }
            else
            {
                $this->method = array( $this, 'gmpCheck' );
            }
        }
        else
        {
            $this->method = array( $this, 'bcmathCheck' );
        }

        $this->options = ( $options === null ) ? new ezcAuthenticationTypekeyOptions() : $options;
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'method':
                if ( is_callable( $value ) )
                {
                    $this->properties[$name] = $value;
                }
                else
                {
                    throw new ezcBaseValueException( $name, $value, 'callback' );
                }
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'method':
                return $this->properties[$name];

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'method':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @throws ezcAuthenticationTypekeyException
     *         if the keys from the TypeKey public keys file could not be fetched
     * @param ezcAuthenticationIdCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        if ( isset( $_GET['name'] ) && isset( $_GET['email'] ) && isset( $_GET['nick'] ) && isset( $_GET['ts'] ) && isset( $_GET['sig'] ) )
        {
            // parse the response URL sent by the TypeKey server
            $id = isset( $_GET['name'] ) ? $_GET['name'] : null;
            $mail = isset( $_GET['email'] ) ? $_GET['email'] : null;
            $nick = isset( $_GET['nick'] ) ? $_GET['nick'] : null;
            $timestamp = isset( $_GET['ts'] ) ? $_GET['ts'] : null;
            $signature = isset( $_GET['sig'] ) ? $_GET['sig'] : null;
        }
        else
        {
            return self::STATUS_SIGNATURE_MISSING;
        }
        if ( $this->options->validity !== 0 &&
             time() - $timestamp >= $this->options->validity )
        {
            return self::STATUS_SIGNATURE_EXPIRED;
        }
        $keys = $this->fetchPublicKeys();
        $msg = "{$mail}::{$id}::{$nick}::{$timestamp}";
        $signature = rawurldecode( urlencode( $signature ) );
        list( $r, $s ) = explode( ':', $signature );
        if ( call_user_func( $this->method, $msg, $r, $s, $keys ) )
        {
            return self::STATUS_OK;
        }
        return self::STATUS_SIGNATURE_INCORRECT;
    }

    /**
     * Fetches the public keys from the TypeKey server.
     *
     * The format of the returned array is:
     *   array( 'p' => p_val, 'g' => g_val, 'q' => q_val, 'pub_key' => pub_key_val )
     *
     * @todo Implement caching to hold the fetched keys
     *
     * @throws ezcAuthenticationTypekeyException
     *         if the keys from the TypeKey public keys file could not be fetched
     * @return array(string=>string)
     */
    protected function fetchPublicKeys()
    {
        $data = @file_get_contents( self::PUBLIC_KEYS_URL );
        if ( $data === false )
        {
            throw new ezcAuthenticationTypekeyException( "Could not fetch public keys from " . self::PUBLIC_KEYS_URL . "." );
        }
        $lines = explode( ' ', trim( $data ) );
        foreach ( $lines as $line )
        {
            $val = explode( '=', $line );
            $keys[$val[0]] = $val[1];
        }
        return $keys;
    }

    /**
     * Checks the information returned by the TypeKey server using the PHP gmp
     * extension.
     *
     * @param string $msg Plain text signature which needs to be verified
     * @param string $r First part of the signature retrieved from TypeKey
     * @param string $s Second part of the signature retrieved from TypeKey
     * @param array(string=>string) $keys Public keys retrieved from TypeKey
     * @return bool
     */
    protected function gmpCheck( $msg, $r, $s, $keys )
    {
        $r = base64_decode( $r );
        $s = base64_decode( $s );
        foreach ( $keys as $key => $value )
        {
            $keys[$key] = gmp_init( $value );
        }
        $s1 = gmp_init( $this->gmpBinToDec( $r ) );
        $s2 = gmp_init( $this->gmpBinToDec( $s ) );
        $w = gmp_invert( $s2, $keys['q'] );
        $msg = gmp_init( '0x' . sha1( $msg ) );
        $u1 = gmp_mod( gmp_mul( $msg, $w ), $keys['q'] );
        $u2 = gmp_mod( gmp_mul( $s1, $w ), $keys['q'] );
        $v = gmp_mul( gmp_powm( $keys['g'], $u1, $keys['p'] ), gmp_powm( $keys['pub_key'], $u2, $keys['p'] ) );
        $v = gmp_mod( gmp_mod( $v, $keys['p'] ), $keys['q'] );
        return ( gmp_cmp( $v, $s1 ) === 0 );
    }

    /**
     * Converts a binary value to a decimal value using gmp functions.
     *
     * @param string $bin Binary value
     * @return string
     */
    protected function gmpBinToDec( $bin )
    {
        $dec = gmp_init( 0 );
        while ( strlen( $bin ) )
        {
            $i = ord( substr( $bin, 0, 1 ) );
            $dec = gmp_add( gmp_mul( $dec, 256 ), $i );
            $bin = substr( $bin, 1 );
        }
        return gmp_strval( $dec );
    }

    /**
     * Checks the information returned by the TypeKey server using the PHP bcmath
     * extension.
     *
     * @param string $msg Plain text signature which needs to be verified
     * @param string $r First part of the signature retrieved from TypeKey
     * @param string $s Second part of the signature retrieved from TypeKey
     * @param array(string=>string) $keys Public keys retrieved from TypeKey
     * @return bool
     */
    protected function bcmathCheck( $msg, $r, $s, $keys )
    {
        $r = base64_decode( $r );
        $s = base64_decode( $s );

        $s1 = $this->bcmathBinToDec( $r );
        $s2 = $this->bcmathBinToDec( $s );

        $w = $this->bcmathInvert( $s2, $keys['q'] );
        $msg = $this->bcmathHexToDec( sha1( $msg ) );

        $u1 = bcmod( bcmul( $msg, $w ), $keys['q'] );
        $u2 = bcmod( bcmul( $s1, $w ), $keys['q'] );

        $v = bcmul( bcmod( bcpowmod( $keys['g'], $u1, $keys['p'] ), $keys['p'] ), bcmod( bcpowmod( $keys['pub_key'], $u2, $keys['p'] ), $keys['p'] ) );
        $v = bcmod( bcmod( $v, $keys['p'] ), $keys['q'] );
        return ( bccomp( $v, $s1 ) === 0 );
    }

    /**
     * Converts a binary value to a decimal value using bcmath functions.
     *
     * @param string $bin Binary value
     * @return string
     */
    protected function bcmathBinToDec( $bin )
    {
        $dec = '0';
        while ( strlen( $bin ) )
        {
            $i = ord( substr( $bin, 0, 1 ) );
            $dec = bcadd( bcmul( $dec, 256 ), $i );
            $bin = substr( $bin, 1 );
        }
        return $dec;
    }

    /**
     * Converts an hexadecimal value to a decimal value using bcmath functions.
     *
     * @param string $hex Hexadecimal value
     * @return string
     */
    protected function bcmathHexToDec( $hex )
    {
        $dec = '0';
        while ( strlen( $hex ) )
        {
            $i = hexdec( substr( $hex, 0, 4 ) );
            $dec = bcadd( bcmul( $dec, 65536 ), $i );
            $hex = substr( $hex, 4 );
        }
        return $dec;
    }

    /**
     * Inverts two values using bcmath functions.
     *
     * @param string $x First value
     * @param string $y Second value
     * @return string
     */
    protected function bcmathInvert( $x, $y )
    {
        while ( bccomp( $x, 0 ) < 0 )
        { 
            $x = bcadd( $x, $y );
        }
        $r = $this->bcmathGcd( $x, $y );
        if ( (int)$r[2] === 1 )
        {
            $a = $r[0];
            while ( bccomp( $a, 0 ) < 0 )
            {
                $a = bcadd( $a, $y );
            }
            return $a;
        }
        else
        {
            return false;
        }
    }

    /**
     * Finds the greatest common denominator of two numbers using the extended
     * Euclidean algorithm and bcmath functions.
     *
     * The returned array is ( a0, b0, gcd( x, y ) ), where
     *     a0 * x + b0 * y = gcd( x, y )
     *
     * @param string $x First number
     * @param string $y Second number
     * @return array(string)
     */
    protected function bcmathGcd( $x, $y )
    {
        $a0 = 1;
        $a1 = 0;

        $b0 = 0;
        $b1 = 1;

        while ( $y > 0 )
        {
            $q = bcdiv( $x, $y, 0 );
            $r = bcmod( $x, $y );

            $x = $y;
            $y = $r;

            $a2 = bcsub( $a0, bcmul( $q, $a1 ) );
            $b2 = bcsub( $b0, bcmul( $q, $b1 ) );

            $a0 = $a1;
            $a1 = $a2;

            $b0 = $b1;
            $b1 = $b2;
        }
        return array( $a0, $b0, $x );
    }
}
?>
