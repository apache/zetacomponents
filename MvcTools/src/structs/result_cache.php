<?php
/**
 * File containing the ezcMvcResultCache class
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
 * This struct contains the cache control sessints for the result.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResultCache extends ezcBaseStruct
{
    /**
     * Vary headers for cache control
     *
     * @var string
     */
    public $vary;

    /**
     * Expiry date
     *
     * @var DateTime
     */
    public $expire;

    /**
     * Cache control parameters
     *
     * @var array(string)
     */
    public $controls;

    /**
     * Contains cache pragma settings
     *
     * @var string
     */
    public $pragma;

    /**
     * Last modified date
     *
     * @var DateTime
     */
    public $lastModified;

    /**
     * Constructs a new ezcMvcResultCache.
     *
     * @param string $vary
     * @param DateTime $expire
     * @param array(string) $controls
     * @param string $pragma
     * @param DateTime $lastModified
     */
    public function __construct( $vary = '', $expire = null,
        $controls = null, $pragma = '', $lastModified = null )
    {
        $this->vary = $vary;
        $this->expire = $expire;
        $this->controls = $controls;
        $this->pragma = $pragma;
        $this->lastModified = $lastModified;
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
        return new ezcMvcResultCache( $array['vary'], $array['expire'],
            $array['controls'], $array['pragma'], $array['lastModified'] );
    }
}
?>
