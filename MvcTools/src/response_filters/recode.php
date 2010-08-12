<?php
/**
 * File containing the ezcMvcRecodeResponseFilter class
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
 * Response filter that converts the encoding of the body.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcRecodeResponseFilter implements ezcMvcResponseFilter
{
    /**
     * Contains the from (internal) encoding
     * @var string
     */
    private $fromEncoding = 'utf-8';

    /**
     * Contains the to (external) encoding
     * @var string
     */
    private $toEncoding = 'utf-8';

    /**
     * This function re-codes the response body from charset $fromEncoding to charset $toEncoding.
     *
     * @param ezcMvcResponse $response
     */
    public function filterResponse( ezcMvcResponse $response )
    {
        $test = @iconv( $this->fromEncoding, $this->fromEncoding, $response->body );
        if ( $test !== $response->body )
        {
            throw new ezcMvcInvalidEncodingException( $response->body, $this->fromEncoding );
        }
        $res = @iconv( $this->fromEncoding, $this->toEncoding . '//IGNORE', $response->body );
        $response->body = $res;
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
        foreach ( $options as $option => $value )
        {
            switch ( $option )
            {
                case 'fromEncoding':
                case 'toEncoding':
                    $this->$option = $value;
                    break;
                default:
                    throw new ezcBasePropertyNotFoundException( $option );
            }
        }
    }
}
?>
