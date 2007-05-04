<?php
/**
 * File containing the ezcAuthenticationLdapFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Filter to authenticate against an LDAP directory.
 *
 * For now passwords can only be specified in plain text.
 *
 * This filter depends on the PHP ldap extension. If this extension is not
 * installed then the constructor will throw an ezcExtensionNotFoundException.
 *
 * Example:
 * <code>
 * $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
 * $ldap = new ezcAuthenticationLdapInfo( 'localhost', 'uid=%id%', 'dc=example,dc=com', 389 );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
 * // add more filters if needed
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array();
 *     $err["user"] = "";
 *     $err["password"] = "";
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         switch ( $key )
 *         {
 *             case 'ezcAuthenticationLdapFilter':
 *                 if ( $value === ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT )
 *                 {
 *                     $err["user"] = "<span class='error'>Username incorrect</span>";
 *                 }
 *                 if ( $value === ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT )
 *                 {
 *                     $err["password"] = "<span class='error'>Password incorrect</span>";
 *                 }
 *                 break;
 *         }
 *     }
 *     // use $err array (with a Template object for example) to display the login form
 *     // to the user with "Password incorrect" message next to the password field, etc...
 * }
 * else
 * {
 *     // authentication succeeded, so allow the user to see his content
 * }
 * </code>
 *
 * @property ezcAuthenticationLdapInfo $ldap
 *           Structure which holds the LDAP server hostname, entry format and base,
 *           and port.
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationLdapFilter extends ezcAuthenticationFilter
{
    /**
     * Username is not found in the database.
     */
    const STATUS_USERNAME_INCORRECT = 1;

    /**
     * Password is incorrect.
     */
    const STATUS_PASSWORD_INCORRECT = 2;

    /**
     * Use plain-text password and no encryption for the connection (default).
     */
    const PROTOCOL_PLAIN = 0;

    /**
     * Use plain-text password and TLS connection.
     */
    const PROTOCOL_TLS = 1;

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
     *         if the PHP ldap extension is not installed
     * @param ezcAuthenticationLdapInfo $ldap How to connect to LDAP
     * @param ezcAuthenticationLdapOptions $options Options for this class
     */
    public function __construct( ezcAuthenticationLdapInfo $ldap, array $options = array() )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'ldap' ) )
        {
            throw new ezcBaseExtensionNotFoundException( 'ldap', null, "PHP not configured --with-ldap." );
        }

        $this->ldap = $ldap;
        $this->options = ( $options === null ) ? new ezcAuthenticationLdapOptions() : $options;
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
            case 'ldap':
                if ( $value instanceof ezcAuthenticationLdapInfo )
                {
                    $this->properties[$name] = $value;
                }
                else
                {
                    throw new ezcBaseValueException( $name, $value, 'instance of ezcAuthenticationLdapInfo' );
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
            case 'ldap':
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
            case 'ldap':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @throws ezcAuthenticationLdapException
     *         if the connecting and binding to the LDAP server could not be performed
     * @param ezcAuthenticationPasswordCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $protocol = 'ldap://'; // 'ldaps://' will be implemented later (if ever, as TLS is better)

        // null, false or empty string passwords are not accepted, as on some servers
        // they could cause the LDAP binding to succeed
        if ( empty( $credentials->password ) )
        {
            return self::STATUS_PASSWORD_INCORRECT;
        }

        $connection = ldap_connect( $this->ldap->host, $this->ldap->port );
        if ( !$connection )
        {
            // OpenLDAP 2.x.x will not throw an exception because $connection is always a resource
            throw new ezcAuthenticationLdapException( "Could not connect to host '{$protocol}{$this->ldap->host}'." );
        }

        // without using version 3, TLS and other stuff won't work
        ldap_set_option( $connection, LDAP_OPT_PROTOCOL_VERSION, 3 );
        ldap_set_option( $connection, LDAP_OPT_REFERRALS, 0 );

        // try to use a TLS connection
        if ( $this->ldap->protocol === self::PROTOCOL_TLS )
        {
            if ( @ldap_start_tls( $connection ) )
            {
                // using TLS, so continue
            }
            else
            {
                throw new ezcAuthenticationLdapException( "Could not connect to host '{$protocol}{$this->ldap->host}:{$this->ldap->port}'.", ldap_errno( $connection ) );
            }
        }

        // bind anonymously to see if username exists in the directory
        if ( @ldap_bind( $connection ) )
        {
            $search = ldap_list( $connection, $this->ldap->base, str_replace( '%id%', $credentials->id, $this->ldap->format ) );
            if ( ldap_count_entries( $connection, $search ) === 0 )
            {
                ldap_close( $connection );
                return self::STATUS_USERNAME_INCORRECT;
            }
            // username exists, so check if we can bind with the provided password
            if ( @ldap_bind( $connection, str_replace( '%id%', $credentials->id, $this->ldap->format ) . ',' . $this->ldap->base, $credentials->password ) )
            {
                ldap_close( $connection );
                return self::STATUS_OK;
            }
        }

        // bind failed, so something must be wrong (connection error or password incorrect)
        $err = ldap_errno( $connection );
        ldap_close( $connection );
        switch ( $err )
        {
            case 0x51: // LDAP_SERVER_DOWN
            case 0x52: // LDAP_LOCAL_ERROR
            case 0x53: // LDAP_ENCODING_ERROR
            case 0x54: // LDAP_DECODING_ERROR
            case 0x55: // LDAP_TIMEOUT
            case 0x56: // LDAP_AUTH_UNKNOWN
            case 0x57: // LDAP_FILTER_ERROR
            case 0x58: // LDAP_USER_CANCELLED
            case 0x59: // LDAP_PARAM_ERROR
            case 0x5a: // LDAP_NO_MEMORY
                throw new ezcAuthenticationLdapException( "Could not connect to host '{$protocol}{$this->ldap->host}:{$this->ldap->port}'.", $err );
        }

        return self::STATUS_PASSWORD_INCORRECT;
    }
}
?>
