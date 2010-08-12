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
    'ezcQueryException'              => 'Database/exceptions/query_exception.php',
    'ezcQueryInvalidException'       => 'Database/exceptions/query/invalid.php',
    'ezcQueryInvalidParameterException' => 'Database/exceptions/query/invalid_parameter.php',
    'ezcQueryVariableParameterException' => 'Database/exceptions/query/variable_parameter.php',
    'ezcQuery'                       => 'Database/sqlabstraction/query.php',
    'ezcQueryExpression'             => 'Database/sqlabstraction/expression.php',
    'ezcQuerySelect'                 => 'Database/sqlabstraction/query_select.php',
    'ezcQueryDelete'                 => 'Database/sqlabstraction/query_delete.php',
    'ezcQueryExpressionMssql'        => 'Database/sqlabstraction/implementations/expression_mssql.php',
    'ezcQueryExpressionOracle'       => 'Database/sqlabstraction/implementations/expression_oracle.php',
    'ezcQueryExpressionPgsql'        => 'Database/sqlabstraction/implementations/expression_pgsql.php',
    'ezcQueryExpressionSqlite'       => 'Database/sqlabstraction/implementations/expression_sqlite.php',
    'ezcQueryInsert'                 => 'Database/sqlabstraction/query_insert.php',
    'ezcQuerySelectMssql'            => 'Database/sqlabstraction/implementations/query_select_mssql.php',
    'ezcQuerySelectOracle'           => 'Database/sqlabstraction/implementations/query_select_oracle.php',
    'ezcQuerySelectSqlite'           => 'Database/sqlabstraction/implementations/query_select_sqlite.php',
    'ezcQuerySqliteFunctions'        => 'Database/sqlabstraction/implementations/query_sqlite_function_implementations.php',
    'ezcQuerySubSelect'              => 'Database/sqlabstraction/query_subselect.php',
    'ezcQueryUpdate'                 => 'Database/sqlabstraction/query_update.php',
);
?>
