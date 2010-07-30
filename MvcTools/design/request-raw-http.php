<?php
/**
 * Class that encapsulates a semi-parsed HTTP request by using PHP's super
 * globals to extract information.
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
class ezcMvcHttpRawRequest extends ezcMvcRawRequest
{
    /**
     * Contains an array of headers, where the key is the original HTTP
     * header name, and the value extracted from the $_SERVER superglobal.
     *
     * @var array(string=>string);
     */
    public $headers;

    /**
     * Contains the request body (read from php://stdin if available).
     *
     * @var string
     */
    public $body;
}
?>
