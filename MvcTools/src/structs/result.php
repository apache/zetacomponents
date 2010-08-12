<?php
/**
 * File containing the ezcMvcResult class
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
 * This struct contains the result data to be formatted by a response writer.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResult extends ezcBaseStruct
{
    /**
     * Result status
     *
     * Set this to an object that implements the ezcMvcResultStatusObject, for
     * example ezcMvcResultUnauthorized or ezcMvcExternalRedirect. These status
     * objects are used by the response writers to take appropriate actions.
     *
     * @var ezcMvcResultStatusObject
     */
    public $status;

    /**
     * Date of the result
     *
     * @var DateTime
     */
    public $date;

    /**
     * Generator string, f.e. "eZ Components MvcTools"
     *
     * @var string
     */
    public $generator;

    /**
     * Contains cache control settings
     *
     * @var ezcMvcResultCache
     */
    public $cache;

    /**
     * Contains all the cookies to be set
     *
     * @var array(ezcMvcResultCookie)
     */
    public $cookies;

    /**
     * Contains content meta-data, such as language, type, charset.
     *
     * @var ezcMvcResultContent
     */
    public $content;

    /**
     * Result variables
     *
     * @var array(mixed)
     */
    public $variables;

    /**
     * Constructs a new ezcMvcResult.
     *
     * @param int $status
     * @param DateTime $date
     * @param string $generator
     * @param ezcMvcResultCache $cache
     * @param array(ezcMvcResultCookie) $cookies
     * @param ezcMvcResultContent $content
     * @param array(mixed) $variables
     */
    public function __construct( $status = 0, $date = null,
        $generator = '', $cache = null, $cookies = array(), $content = null,
        $variables = array() )
    {
        $this->status = $status;
        $this->date = $date;
        $this->generator = $generator;
        $this->cache = $cache;
        $this->cookies = $cookies;
        $this->content = $content;
        $this->variables = $variables;
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
     * @return ezcMvcResult
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcResult( $array['status'], $array['date'],
            $array['generator'], $array['cache'], $array['cookies'],
            $array['content'], $array['variables'] );
    }
}
?>
