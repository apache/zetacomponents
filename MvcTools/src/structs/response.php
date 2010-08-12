<?php
/**
 * File containing the ezcMvcResponse class
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
 * Struct which holds the abstract response.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResponse extends ezcBaseStruct
{
    /**
     * Result status, which contains additional information about the result, such
     * as a location header (for external redirects), or a www-authenticate information
     * struct.
     *
     * @var ezcBaseStruct
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
     * Server body.
     *
     * @var string
     */
    public $body;

    /**
     * Constructs a new ezcMvcResponse.
     *
     * @param ezcBaseStruct $status
     * @param DateTime $date
     * @param string $generator
     * @param ezcMvcResultCache $cache
     * @param array(ezcMvcResultCookie) $cookies
     * @param ezcMvcResultContent $content
     * @param string $body
     */
    public function __construct( $status = null, $date = null,
        $generator = '', $cache = null, $cookies = array(), $content = null, $body = '' )
    {
        $this->status = $status;
        $this->date = $date;
        $this->generator = $generator;
        $this->cache = $cache;
        $this->cookies = $cookies;
        $this->content = $content;
        $this->body = $body;
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
     * @return ezcMvcResponse
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcResponse( $array['status'], $array['date'],
            $array['generator'], $array['cache'], $array['cookies'],
            $array['content'], $array['body'] );
    }
}
?>
