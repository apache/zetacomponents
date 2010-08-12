<?php
/**
 * File containing the ezcMvcGzDeflateResponseFilter class
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
 * Response filter that gz deflates the contents.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcGzDeflateResponseFilter implements ezcMvcResponseFilter
{
    /**
     * This function filters the $response by gz-deflating it.
     *
     * @param ezcMvcResponse $response
     */
    public function filterResponse( ezcMvcResponse $response )
    {
        $response->body = gzdeflate( $response->body );
        if ( !$response->content )
        {
            $response->content = new ezcMvcResultContent;
        }
        $response->content->encoding = 'deflate';
    }

    /**
     * Should not be called with any options, as this filter doesn't support any.
     *
     * @throws ezcMvcFilterHasNoOptionsException if the $options array is not
     * empty.
     * @param array $options
     */
    public function setOptions( array $options )
    {
        if ( count( $options ) )
        {
            throw new ezcMvcFilterHasNoOptionsException( __CLASS__ );
        }
    }
}
?>
