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
 * Group authentication filters together.
 *
 * If there are no filters in the group, then the run() method will return
 * STATUS_OK.
 *
 * The way of grouping the filters is specified with the mode option:
 *  - ezcAuthenticationGroupFilter::MODE_OR (default): at least one filter
 *    in the group needs to succeed in order for the group to succeed.
 *  - ezcAuthenticationGroupFilter::MODE_AND: all filters in the group
 *    need to succeed in order for the group to succeed.
 *
 * Example of using the mode option:
 * <code>
 * $options = new ezcAuthenticationGroupOptions();
 * $options->mode = ezcAuthenticationGroupFilter::MODE_AND;
 *
 * // $filter1 and $filter2 are authentication filters which all need to succeed
 * // in order for the group to succeed
 * $filter = new ezcAuthenticationGroupFilter( array( $filter1, $filter2 ), $options );
 * </code>
 *
 * Example of using the group filter with LDAP and Database filters:
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
 * // use the database and LDAP filters in paralel (at least one needs to succeed in
 * // order for the user to be authenticated)
 * $authentication->addFilter( new ezcAuthenticationGroupFilter( array( $databaseFilter, $ldapFilter ) ) );
 * // add more filters if needed
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array(
 *              ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
 *              ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password',
 *              ezcAuthenticationDatabaseFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
 *              ezcAuthenticationDatabaseFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
 *              );
 *     for ( $i = 0; $i < count( $status ); $i++ )
 *     {
 *         list( $key, $value ) = each( $status[$i] );
 *         echo $err[$value];
 *     }
 * }
 * else
 * {
 *     // authentication succeeded, so allow the user to see his content
 * }
 * </code>
 *
 * @property ezcAuthenticationStatus $status
 *           The status object which holds the status of the run filters.
 *
 * @package Authentication
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationGroupFilter extends ezcAuthenticationFilter
{
    /**
     * All or some of the filters in the group failed (depeding on the mode
     * option).
     */
    const STATUS_GROUP_FAILED = 1;

    /**
     * At least one filter needs to succeed in order for the group to succeed.
     */
    const MODE_OR = 1;

    /**
     * All the filters need to succeed in order for the group to succeed.
     */
    const MODE_AND = 2;

    /**
     * Authentication filters.
     * 
     * @var array(ezcAuthenticationFilter)
     */
    protected $filters = array();

    /**
     * The properties of this class.
     * 
     * @var array(string=>mixed)
     */
    private $properties = array();

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

        $success = false;

        if ( $this->options->mode === self::MODE_OR )
        {
            $success = false;
            foreach ( $this->filters as $filter )
            {
                $code = $filter->run( $credentials );
                $this->status->append( get_class( $filter ), $code );
                if ( $code === self::STATUS_OK )
                {
                    $success = true;
                }
            }
        }

        if ( $this->options->mode === self::MODE_AND )
        {
            $success = true;
            foreach ( $this->filters as $filter )
            {
                $code = $filter->run( $credentials );
                $this->status->append( get_class( $filter ), $code );
                if ( $code !== self::STATUS_OK )
                {
                    $success = false;
                }
            }
        }

        // other modes are not possible due to the way mode is set in __set()
        // in the options class

        return ( $success === true ) ? self::STATUS_OK :
                                       self::STATUS_GROUP_FAILED;
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
