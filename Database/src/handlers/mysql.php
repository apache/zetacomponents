<?php
/**
 * File containing the ezcDbHandlerMysql class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * MySQL driver implementation
 *
 * @see ezcDbHandler
 * @package Database
 * @version //autogentag//
 */
class ezcDbHandlerMysql extends ezcDbHandler
{
    /**
     * Characters to quote identifiers with. Should be overwritten in handler
     * implementation, if different for a specific handler. In some cases the
     * quoting start and end characters differ (e.g. ODBC), but mostly they are
     * the same.
     *
     * @var string
     */
    protected $identifierQuoteChars = array(
        "start" => '`',
        "end"   => '`',
    );

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
     * @param array $dbParams Database connection parameters (key=>value pairs).
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
     * Returns true if $feature is supported by MySQL.
     *
     * @apichange Never implemented properly, no good use (See #10937)
     * @ignore
     * @param array(string) $feature
     * @return bool
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
