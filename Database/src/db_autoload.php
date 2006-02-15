<?php
/**
 * Autoloading helper.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */

return array(
    'ezcDbFactory'              => 'Database/factory.php',
    'ezcDbInstance'             => 'Database/instance.php',
    'ezcDbException'            => 'Database/exceptions/exception.php',
    'ezcDbHandlerNotFoundException' => 'Database/exceptions/handler_not_found.php',
    'ezcDbTransactionException' => 'Database/exceptions/transaction.php',
    'ezcDbMissingParameterException' => 'Database/exceptions/missing_parameter.php',
    'ezcDbHandler'              => 'Database/handler.php',
    'ezcDbHandlerMysql'         => 'Database/handlers/mysql.php',
    'ezcDbHandlerOracle'        => 'Database/handlers/oracle.php',
    'ezcDbHandlerPgsql'         => 'Database/handlers/pgsql.php',
    'ezcDbHandlerSqlite'        => 'Database/handlers/sqlite.php',
    'ezcDbUtilities'            => 'Database/sqlabstraction/utilities.php',
    'ezcDbUtilitiesMysql'       => 'Database/sqlabstraction/implementations/utilities_mysql.php',
    'ezcDbUtilitiesOracle'      => 'Database/sqlabstraction/implementations/utilities_oracle.php',
    'ezcDbUtilitiesPgsql'       => 'Database/sqlabstraction/implementations/utilities_pgsql.php',
    'ezcDbUtilitiesSqlite'      => 'Database/sqlabstraction/implementations/utilities_sqlite.php',
);
?>
