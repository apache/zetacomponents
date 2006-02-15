<?php
/**
 * File containing the ezcDbHandlerMysql class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * MySQL driver implementation
 *
 * @see ezcDbHandler
 * @package Database
 */
class ezcDbHandlerMysql extends ezcDbHandler
{
    /**
     * Constructs a handler object from the parameters $dbParams.
     *
     * Supported database parameters are:
     * - dbname|database: Database name
     * - user|username:   Database user name
     * - pass|password:   Database user password
     * - host|hostspec:   Name of the host database is running on
     * - port:            TCP port
     * - charset:         Client character set
     * - socket:          UNIX socket path
     *
     * @throws ezcDbMissingParameterException if the database name was not specified.
     * @param array $dbparams Database connection parameters (key=>value pairs).
     */
    public function __construct( $dbParams )
    {
        $database = null;
        $charset  = null;
        $host     = null;
        $port     = null;
        $socket   = null;

        foreach ( $dbParams as $key => $val )
        {
            switch ( $key )
            {
                case 'database':
                case 'dbname':
                    $database = $val;
                    break;

                case 'charset':
                    $charset = $val;
                    break;

                case 'host':
                case 'hostspec':
                    $host = $val;
                    break;

                case 'port':
                    $port = $val;
                    break;

                case 'socket':
                    $socket = $val;
                    break;
            }
        }

        if ( !isset( $database ) )
        {
            throw new ezcDbMissingParameterException( 'database', 'dbParams' );
        }

        $dsn = "mysql:dbname=$database";

        if ( isset( $host ) && $host )
        {
            $dsn .= ";host=$host";
        }

        if ( isset( $port ) && $port )
        {
            $dsn .= ";port=$port";
        }

        if ( isset( $charset ) && $charset )
        {
            $dsn .= ";charset=$charset";
        }

        if ( isset( $socket ) && $socket )
        {
            $dsn .= ";unix_socket=$socket";
        }

        parent::__construct( $dbParams, $dsn );
    }

    /**
     * Returns 'mysql'.
     *
     * @return string
     */
    static public function getName()
    {
        return 'mysql';
    }

    /**
     * Returns the features supported by MySQL.
     *
     * @return array(string)
     */
    static public function hasFeature( $feature )
    {
        $supportedFeatures = array( 'multi-table-delete', 'cross-table-update' );
        return in_array( $feature, $supportedFeatures );
    }

    /**
     * Returns a new ezcUtilities derived object for this database instance.
     *
     * @return ezcUtilitiesMysql
     */
    public function createUtilities()
    {
        return new ezcDbUtilitiesMysql( $this );
    }
}
?>
