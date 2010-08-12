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
 * PostgreSQL driver implementation
 *
 * @see ezcDbHandler
 * @package Database
 * @version //autogentag//
 */
class ezcDbHandlerPgsql extends ezcDbHandler
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

                case 'host':
                case 'hostspec':
                    $host = $val;
                    break;

                case 'port':
                    $port = $val;
                    break;
            }
        }

        if ( !isset( $database ) )
        {
            throw new ezcDbMissingParameterException( 'database', 'dbParams' );
        }

        $dsn = "pgsql:dbname=$database";

        if ( isset( $host ) && $host )
        {
            $dsn .= " host=$host";
        }

        if ( isset( $port ) && $port )
        {
            $dsn .= " port=$port";
        }

        parent::__construct( $dbParams, $dsn );
    }

    /**
     * Returns 'pgsql'.
     *
     * @return string
     */
    static public function getName()
    {
        return 'pgsql';
    }

    /**
     * Returns a new ezcQueryExpression derived object with PostgreSQL implementation specifics.
     *
     * @return ezcQueryExpressionPgsql
     */
    public function createExpression()
    {
        return new ezcQueryExpressionPgsql( $this );
    }

    /**
     * Returns a new ezcUtilities derived object with PostgreSQL implementation specifics.
     *
     * @return ezcUtilitiesPgsql
     */
    public function createUtilities()
    {
        return new ezcDbUtilitiesPgsql( $this );
    }
}
?>
