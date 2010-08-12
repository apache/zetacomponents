<?php
/**
 * File containing the ezcTemplateWebFunctions class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateWebFunctions extends ezcTemplateFunctions
{
    /**
     * Translates a function used in the Template language to a PHP function call.  
     * The function call is represented by an array with three elements:
     *
     * 1. The return typehint. Is it an array, a non-array, or both.
     * 2. The parameter input definition.
     * 3. The AST nodes.
     *
     * @param string $functionName
     * @param array(ezcTemplateAstNode) $parameters
     * @return array(mixed)
     */
    public static function getFunctionSubstitution( $functionName, $parameters )
    {
        switch ( $functionName )
        {
            // url_encode( $s )
            case "url_encode":
                return array( array( "%string" ), self::functionCall( "urlencode", array( "%string" ) ) );
            
            // url_decode( $s )
            case "url_decode":
                return array( array( "%string" ), self::functionCall( "urldecode", array( "%string" ) ) );
            
            // url_parameters_build( $params, [$prefix] )
            case "url_parameters_build":
                return array( array( "%params", "[%prefix]" ), self::functionCall( "http_build_query", array( "%params", "[%prefix]" ) ) );

            // url_build( $data )
            case "url_build":
                return array( array( "%data" ), self::functionCall( "ezcTemplateWeb::url_build", array( "%data" ) ) );
            
            // url_parse( $s )
            case "url_parse":
                return array( array( "%string" ), self::functionCall( "parse_url", array( "%string" ) ) );

        }

        return null;
    }
}
?>
