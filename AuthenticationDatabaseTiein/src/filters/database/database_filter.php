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
        // see if username exists
        $query = new ezcQuerySelect( $this->database->instance );
        $e = $query->expr;
        $query->select( 'COUNT(*)' )
              ->from( $this->database->table )
              ->where(
                  $e->eq( $this->database->fields[0], $query->bindValue( $credentials->id ) )
                     );
        $rows = $query->prepare();
        $rows->execute();
        $count = (int)$rows->fetchColumn( 0 );
        if ( $count === 0 )
        {
            return self::STATUS_USERNAME_INCORRECT;
        }

        // see if username has the specified password
        $query = new ezcQuerySelect( $this->database->instance );
        $e = $query->expr;
        $query->select( 'COUNT(*)' )
              ->from( $this->database->table )
              ->where( $e->lAnd(
                  $e->eq( $this->database->fields[0], $query->bindValue( $credentials->id ) ),
                  $e->eq( $this->database->fields[1], $query->bindValue( $credentials->password ) )
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
