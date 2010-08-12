<?php
/**
 * File containing the ezcMvcRequestCookie class
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
 * @package MvcTools
 */

/**
 * This struct contains cookie arguments
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRequestCookie extends ezcBaseStruct
{
    /**
     * Cookie name
     *
     * @var string
     */
    public $name;

    /**
     * Cookie value
     *
     * @var string
     */
    public $value;

    /**
     * Constructs a new ezcMvcRequestCookie.
     *
     * @param string $name
     * @param string $value
     */
    public function __construct( $name = '', $value = '' )
    {
        $this->name = $name;
        $this->value = $value;
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
     * @param array(string=>mixed) $array
     * @return ezcMvcResultCache
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRequestCookie( $array['name'], $array['value'] );
    }
}
?>
