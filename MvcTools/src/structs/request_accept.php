<?php
/**
 * File containing the ezcMvcRequestAccept class
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
 * Struct which defines client-acceptable contents.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRequestAccept extends ezcBaseStruct
{
    /**
     * Request content types.
     *
     * @var array
     */
    public $types;

    /**
     * Acceptable charsets.
     *
     * @var array
     */
    public $charsets;

    /**
     * Request languages.
     *
     * @var array
     */
    public $languages;

    /**
     * Acceptable encodings.
     *
     * @var array
     */
    public $encodings;

    /**
     * Constructs a new ezcMvcRequestAccept.
     *
     * @param array $types
     * @param array $charsets
     * @param array $languages
     * @param array $encodings
     */
    public function __construct( $types = array(),
        $charsets = array(), $languages = array(), $encodings = array() )
    {
        $this->types = $types;
        $this->charsets = $charsets;
        $this->languages = $languages;
        $this->encodings = $encodings;
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
     * @return ezcMvcRequestAccept
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRequestAccept( $array['types'], $array['charsets'],
            $array['languages'], $array['encodings'] );
    }
}
?>
