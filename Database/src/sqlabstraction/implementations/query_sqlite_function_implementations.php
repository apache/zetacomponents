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
class ezcQuerySqliteFunctions
{
    /**
     * Returns the md5 sum of the data that SQLite's md5() function receives.
     *
     * @param string $data
     * @return string
     */
    static public function md5Impl( $data )
    {
        return md5( $data );
    }

    /**
     * Returns the modules of the data that SQLite's mod() function receives.
     *
     * @param numeric $dividend
     * @param numeric $divisor
     * @return string
     */
    static public function modImpl( $dividend, $divisor )
    {
        return $dividend % $divisor;
    }

    /**
     * Returns a concattenation of the data that SQLite's concat() function receives.
     *
     * @return string
     */
    static public function concatImpl()
    {
        $args = func_get_args();
        return join( '', $args );
    }

    /**
     * Returns the SQL to locate the position of the first occurrence of a substring
     * 
     * @param string $substr
     * @param string $value
     * @return integer
     */
     static public function positionImpl( $substr, $value )
     {
         return strpos( $value, $substr ) + 1;
     }

    /**
     * Returns the next lowest integer value from the number
     * 
     * @param numeric $number
     * @return integer
     */
     static public function floorImpl( $number )
     {
         return (int) floor( $number );
     }

     /**
      * Returns the next highest integer value from the number
      * 
      * @param numeric $number
      * @return integer
      */
     static public function ceilImpl( $number )
     {
         return (int) ceil( $number );
     }

     /**
      * Returns the unix timestamp belonging to a date/time spec
      *
      * @param string $spec
      * @return integer
      */
     static public function toUnixTimestampImpl( $spec )
     {
         return strtotime( $spec );
     }
}
?>
