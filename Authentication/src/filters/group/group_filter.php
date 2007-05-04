<?php
/**
 * File containing the ezcAuthenticationGroupFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Group authentication filters together, where only one filter needs to succeed
 * in order for the group to succeed.
 *
 * Example:
 * <code>
 * $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
 *
 * // create a database filter
 * $database = new ezcAuthenticationDatabaseInfo( ezcDbInstance::get(), 'users', array( 'user', 'password' ) );
 * $databaseFilter = new ezcAuthenticationDatabaseFilter( $database );
 *
 * // create an LDAP filter
 * $ldap = new ezcAuthenticationLdapInfo( 'localhost', 'uid=%id%', 'dc=example,dc=com', 389 );
 * $ldapFilter = new ezcAuthenticationLdapFilter( $ldap );
 * $authentication = new ezcAuthentication( $credentials );
 *
 * // use the database and LDAP filters in paralel (only one needs to succeed in
 * // order for the user to be authenticated
 * $authentication->addFilter( new ezcAuthenticationGroupFilter( array( $databaseFilter, $ldapFilter ) ) );
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
 *             case 'ezcAuthenticationDatabaseFilter':
 *                 if ( $value === ezcAuthenticationDatabaseFilter::STATUS_USERNAME_INCORRECT )
 *                 {
 *                     $err["user"] = "<span class='error'>Username incorrect</span>";
 *                 }
 *                 if ( $value === ezcAuthenticationDatabaseFilter::STATUS_PASSWORD_INCORRECT )
 *                 {
 *                     $err["password"] = "<span class='error'>Password incorrect</span>";
 *                 }
 *                 break;
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
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationGroupFilter extends ezcAuthenticationFilter
{
    /**
     * All the filters in the group failed.
     */
    const STATUS_GROUP_FAILED = 1;

    /**
     * The properties of this class.
     * 
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Authentication filters, where only one filter needs to succeed in order for
     * the group to succeed.
     * 
     * @var array(ezcAuthenticationFilter)
     */
    private $filters = array();

    /**
     * Creates a new object of this class.
     *
     * @param array(ezcAuthenticationFilter) $filters Authentication filters
     * @param ezcAuthenticationGroupOptions $options Options for this class
     */
    public function __construct( array $filters, ezcAuthenticationGroupOptions $options = null )
    {
        $this->filters = $filters;
        $this->status = new ezcAuthenticationStatus();
        $this->options = ( $options === null ) ? new ezcAuthenticationGroupOptions() : $options;
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
            case 'status':
                if ( $value instanceof ezcAuthenticationStatus )
                {
                    $this->properties[$name] = $value;
                }
                else
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcAuthenticationStatus' );
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
            case 'status':
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
            case 'status':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        if ( count( $this->filters ) === 0 )
        {
            return self::STATUS_OK;
        }
        foreach ( $this->filters as $filter )
        {
            $code = $filter->run( $credentials );
            $this->status->append( get_class( $filter ), $code );
            if ( $code === self::STATUS_OK )
            {
                return self::STATUS_OK;
            }
        }
        return self::STATUS_GROUP_FAILED;
    }

    /**
     * Adds an authentication filter at the end of the filter list.
     *
     * @param ezcAuthenticationFilter $filter The authentication filter to add
     */
    public function addFilter( ezcAuthenticationFilter $filter )
    {
        $this->filters[] = $filter;
    }
}
?>
