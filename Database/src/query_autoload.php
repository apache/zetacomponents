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
    'ezcQuery' => 'Database/sqlabstraction/query.php',
    'ezcQueryException' => 'Database/exceptions/query_exception.php',
    'ezcQueryInvalidException' => 'Database/exceptions/query/invalid.php',
    'ezcQueryVariableParameterException' => 'Database/exceptions/query/variable_parameter.php',
    'ezcQuerySelect' => 'Database/sqlabstraction/query_select.php',
    'ezcQuerySubSelect' => 'Database/sqlabstraction/query_subselect.php',    
    'ezcQuerySelectOracle' => 'Database/sqlabstraction/implementations/query_select_oracle.php',
    'ezcQuerySelectSqlite' => 'Database/sqlabstraction/implementations/query_select_sqlite.php',
    'ezcQueryExpression' => 'Database/sqlabstraction/expression.php',
    'ezcQueryExpressionOracle' => 'Database/sqlabstraction/implementations/expression_oracle.php',
    'ezcQueryExpressionPgsql' => 'Database/sqlabstraction/implementations/expression_pgsql.php',
    'ezcQueryExpressionSqlite' => 'Database/sqlabstraction/implementations/expression_sqlite.php',
    'ezcQuerySqliteFunctions' => 'Database/sqlabstraction/implementations/query_sqlite_function_implementations.php',
    'ezcQueryInsert' => 'Database/sqlabstraction/query_insert.php',
    'ezcQueryUpdate' => 'Database/sqlabstraction/query_update.php',
    'ezcQueryDelete' => 'Database/sqlabstraction/query_delete.php',
);
?>
