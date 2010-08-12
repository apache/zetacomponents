<?php
/**
 * Autoloader definition for the Database component.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Database
 */

return array(
    'ezcDbException'                 => 'Database/exceptions/exception.php',
    'ezcDbHandlerNotFoundException'  => 'Database/exceptions/handler_not_found.php',
    'ezcDbMissingParameterException' => 'Database/exceptions/missing_parameter.php',
    'ezcDbTransactionException'      => 'Database/exceptions/transaction.php',
    'ezcDbHandler'                   => 'Database/handler.php',
    'ezcDbUtilities'                 => 'Database/sqlabstraction/utilities.php',
    'ezcDbFactory'                   => 'Database/factory.php',
    'ezcDbHandlerMssql'              => 'Database/handlers/mssql.php',
    'ezcDbHandlerMysql'              => 'Database/handlers/mysql.php',
    'ezcDbHandlerOracle'             => 'Database/handlers/oracle.php',
    'ezcDbHandlerPgsql'              => 'Database/handlers/pgsql.php',
    'ezcDbHandlerSqlite'             => 'Database/handlers/sqlite.php',
    'ezcDbInstance'                  => 'Database/instance.php',
    'ezcDbMssqlOptions'              => 'Database/options/identifiers.php',
    'ezcDbUtilitiesMysql'            => 'Database/sqlabstraction/implementations/utilities_mysql.php',
    'ezcDbUtilitiesOracle'           => 'Database/sqlabstraction/implementations/utilities_oracle.php',
    'ezcDbUtilitiesPgsql'            => 'Database/sqlabstraction/implementations/utilities_pgsql.php',
    'ezcDbUtilitiesSqlite'           => 'Database/sqlabstraction/implementations/utilities_sqlite.php',
);
?>
