<?php
/**
 * File containing the ezcQueryExpressionSqlite class.
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
 * The ezcQueryExpressionSqlite class is used to create SQL expression for SQLite.
 *
 * This class reimplements the methods that have a different syntax in
 * SQLite (substr) and contains PHP implementations of functions that are
 * registered with SQLite with it's PDO::sqliteRegisterFunction() method.
 *
 * @package Database
 * @version //autogentag//
 */
class ezcQueryExpressionSqlite extends ezcQueryExpression
{
    /**
     * Contains an interval map from generic intervals to SQLite native intervals.
     *
     * @var array(string=>string)
     */
    protected $intervalMap = array(
        'SECOND' => 'seconds',
        'MINUTE' => 'minutes',
        'HOUR' => 'hours',
        'DAY' => 'days',
        'MONTH' => 'months',
        'YEAR' => 'years',
    );

    /**
     * Returns part of a string.
     *
     * Note: Not SQL92, but common functionality. SQLite only supports the 3
     * parameter variant of this function, so we are using 2^30-1 as
     * artificial length in that case.
     *
     * @param string $value the target $value the string or the string column.
     * @param int $from extract from this characeter.
     * @param int $len extract this amount of characters.
     * @return string sql that extracts part of a string.
     */
    public function subString( $value, $from, $len = null )
    {
        $value = $this->getIdentifier( $value );
        if ( $len === null )
        {
            $len = $this->getIdentifier( $len );
            return "substr( {$value}, {$from}, 1073741823 )";
        }
        else
        {
            return "substr( {$value}, {$from}, {$len} )";
        }
    }

    /**
     * Returns the current system date and time in the database internal
     * format.
     *
     * @return string
     */
    public function now()
    {
        return '"' . date( 'Y-m-d H:i:s' ) . '"';
    }

    /**
     * Returns the SQL that performs the bitwise XOR on two values.
     *
     * @param string $value1
     * @param string $value2
     * @return string
     */
    public function bitXor( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "( ( {$value1} | {$value2} ) - ( {$value1} & {$value2} ) )";
    }

    /**
     * Returns the SQL that converts a timestamp value to a unix timestamp.
     *
     * @param string $column
     * @return string
     */
    public function unixTimestamp( $column )
    {
        if ( $column == 'NOW()' )
        {
            return " strftime( '%s', 'now' ) ";
        }
        else
        {
            $column = $this->getIdentifier( $column );
            return " toUnixTimestamp( {$column} ) ";
        }
    }

    /**
     * Returns the SQL that subtracts an interval from a timestamp value.
     *
     * @param string $column
     * @param numeric $expr
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateSub( $column, $expr, $type )
    {
        $type = $this->intervalMap[$type];

        $column = $this->getIdentifier( $column );
        return " datetime( {$column} , '-{$expr} {$type}' ) ";
    }

    /**
     * Returns the SQL that adds an interval to a timestamp value.
     *
     * @param string $column
     * @param numeric $expr
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateAdd( $column, $expr, $type )
    {
        $type = $this->intervalMap[$type];

        $column = $this->getIdentifier( $column );
        return " datetime( {$column} , '+{$expr} {$type}' ) ";
    }

    /**
     * Returns the SQL that extracts parts from a timestamp value.
     *
     * @param string $column
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateExtract( $column, $type )
    {
        switch ( $type )
        {
            case 'SECOND':
                $type = '%S';
                break;
            case 'MINUTE':
                $type = '%M';
                break;
            case 'HOUR':
                $type = '%H';
                break;
            case 'DAY':
                $type = '%d';
                break;
            case 'MONTH':
                $type = '%m';
                break;
            case 'YEAR':
                $type = '%Y';
                break;
        }

        if ( $column == 'NOW()' )
        {
            $column = "'now'";
        }

        $column = $this->getIdentifier( $column );
        return " strftime( '{$type}', {$column} ) ";
    }
}
?>
