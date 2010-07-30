<?php
/**
 * File containing the ezcTemplateWeb class
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
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * This class contains a bundle of static functions, each implementing a specific
 * function used inside the template language. 
 * 
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateWeb
{
    /**
     * Returns a string that contains the url build of the data $data.
     *
     * @param (array(string=>string) $data 
     * @return string
     */
    public static function url_build( $data )
    {
        $url = '';
        if ( $data['scheme'] && $data['host'] )
        {
            $url .= $data['scheme'] . '://';
            if ( isset( $data['user'] ) )
            {
                $url .= $data['user'];
                if ( isset( $data['pass'] ) )
                {
                    $url .= ':' . $data['pass'];
                };
                $url .= '@';
            }
            $url .= $data['host'];
            if ( isset( $data['port'] ) )
            {
                $url .= ':' . $data['port'];
            }
        }
        $url .= $data['path'];
        if ( isset( $data['query'] ) )
        {
            $url .= '?' . $data['query'];
        }
        if ( isset( $data['fragment'] ) ) 
        {
            $url .= '#' . $data['fragment'];
        }

        return $url;
    }
}

?>
