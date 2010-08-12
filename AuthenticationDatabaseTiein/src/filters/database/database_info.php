<?php
/**
 * File containing the ezcAuthenticationDatabaseInfo structure.
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
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 */

/**
 * Structure for defining the database and table to authenticate against.
 *
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 */
class ezcAuthenticationDatabaseInfo extends ezcBaseStruct
{
    /**
     * Database instance.
     *
     * @var ezcDbHandler
     */
    public $instance;

    /**
     * Table which stores the user credentials.
     *
     * @var string
     */
    public $table;

    /**
     * Fields which hold the user credentials.
     *
     * @var array(string)
     */
    public $fields;

    /**
     * Constructs a new ezcAuthenticationDatabaseInfo object.
     *
     * @param ezcDbHandler $instance Database instance to use
     * @param string $table Table which stores usernames and passwords
     * @param array(string) $fields The fields which hold usernames and passwords
     */
    public function __construct( ezcDbHandler $instance, $table, array $fields )
    {
        $this->instance = $instance;
        $this->table = $table;
        $this->fields = $fields;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array Associative array of data members for this class
     * @return ezcAuthenticationDatabaseInfo
     */
    static public function __set_state( array $array )
    {
        return new ezcAuthenticationDatabaseInfo( $array['instance'], $array['table'], $array['fields'] );
    }
}
?>
