<?php
/**
 * Struct which holds the request authentication parameters.
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
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResponse extends ezcBaseStruct
{    
    /**
     * Server headers.
     * 
     * @var array
     */
    public $headers;

    /**
     * Server body.
     * 
     * @var string
     */
    public $body;

    /**
     * Constructs a new ezcMvcResponse with headers $headers and body $body.
     * 
     * @param array $headers Client headers.
     * @param string $bodye Client body.
     * @return void
     */
    public function __construct( $headers, $body )
    {
        $this->headers = $headers;
        $this->body    = $body;
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
        return new ezcMvcResponse( $array['headers'], $array['body'] );
    }
}
?>
