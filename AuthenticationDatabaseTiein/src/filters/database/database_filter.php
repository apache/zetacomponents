<?php
/**
 * File containing the ezcAuthenticationDatabaseFilter class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 */

/**
 * Filter to authenticate against a database.
 *
 * The database instance to use is specified using a ezcAuthenticationDatabaseInfo
 * structure. Table name and field names are specified in the same structure.
 *
 * Example:
 * <code>
 * $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e' );
 * $database = new ezcAuthenticationDatabaseInfo( ezcDbInstance::get(), 'users', array( 'user', 'password' ) );
 * $authentication = new ezcAuthentication( $credentials );
 * $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
 * if ( !$authentication->run() )
 * {
 *     // authentication did not succeed, so inform the user
 *     $status = $authentication->getStatus();
 *     $err = array(
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
 * @property ezcAuthenticationDatabaseInfo $database
 *           Structure which holds a database instance, table name and fields
 *           which are used for authentication.
 *
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 * @mainclass
 */
class ezcAuthenticationDatabaseFilter extends ezcAuthenticationFilter
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
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Creates a new object of this class.
     *
     * @param ezcAuthenticationDatabaseInfo $database Database to use in authentication
     * @param ezcAuthenticationDatabaseOptions $options Options for this class
     */
    public function __construct( ezcAuthenticationDatabaseInfo $database, ezcAuthenticationDatabaseOptions $options = null )
    {
        $this->options = ( $options === null ) ? new ezcAuthenticationDatabaseOptions() : $options;
        $this->database = $database;
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
            case 'database':
                if ( $value instanceof ezcAuthenticationDatabaseInfo )
                {
                    $this->properties[$name] = $value;
                }
                else
                {
                    throw new ezcBaseValueException( $name, $value, 'instance of ezcAuthenticationDatabaseInfo' );
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
            case 'database':
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
            case 'database':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationPasswordCredentials $credentials Authentication credentials
     * @return int
     */
    public function run( $credentials )
    {
        $db = $this->database;

        // see if username exists
        $query = new ezcQuerySelect( $db->instance );
        $e = $query->expr;
        $query->select( 'COUNT( ' . $db->instance->quoteIdentifier( $db->fields[0] ) . ' )' )
              ->from( $db->instance->quoteIdentifier( $db->table ) )
              ->where(
                  $e->eq( $db->instance->quoteIdentifier( $db->fields[0] ), $query->bindValue( $credentials->id ) )
                     );
        $rows = $query->prepare();
        $rows->execute();
        $count = (int)$rows->fetchColumn( 0 );
        if ( $count === 0 )
        {
            return self::STATUS_USERNAME_INCORRECT;
        }

        // see if username has the specified password
        $query = new ezcQuerySelect( $db->instance );
        $e = $query->expr;
        $query->select( 'COUNT( ' . $db->instance->quoteIdentifier( $db->fields[0] ) . '  )' )
              ->from( $db->instance->quoteIdentifier( $db->table ) )
              ->where( $e->lAnd(
                  $e->eq( $db->instance->quoteIdentifier( $db->fields[0] ), $query->bindValue( $credentials->id ) ),
                  $e->eq( $db->instance->quoteIdentifier( $db->fields[1] ), $query->bindValue( $credentials->password ) )
                     ) );
        $rows = $query->prepare();
        $rows->execute();
        $count = (int)$rows->fetchColumn( 0 );
        if ( $count === 0 )
        {
            return self::STATUS_PASSWORD_INCORRECT;
        }

        return self::STATUS_OK;
    }
}
?>
