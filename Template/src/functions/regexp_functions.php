<?php
/**
 * File containing the ezcTemplateRegExpFunctions class
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
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateRegExpFunctions extends ezcTemplateFunctions
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
            // preg_has_match( $s, $reg )::
            // preg_match( $reg, $s )
            case "preg_has_match": return array( array( "%s", "%reg"), 
                    self::functionCall( "preg_match", array( "%reg", "%s" ) ) );

            // preg_match( $s, $reg, $flags = false [, $offset] )::
            // TODO, append optional parameters.
            case "preg_match": return array( array( "%s", "%reg" ), 
                    self::functionCall( "ezcTemplateRegExp::preg_match", array( "%reg", "%s" ) ) );

            // preg_replace( $s, $reg, $replace, [, $limit] )::
            // preg_replace( $reg, $replace, $s [, $limit] )
            case "preg_replace": return array( array( "%s", "%reg", "%replace", "[%limit]" ), 
                    self::functionCall( "preg_replace", array( "%reg", "%replace", "%s", "[%limit]" ) ) );

            // preg_quote( $s [, $delim] )::
            // preg_quote( $s [, $delim] )
            case "preg_quote": return array( array( "%s", "[%delim]" ), 
                    self::functionCall( "preg_quote", array( "%s", "[%delim]" ) ) );

            // preg_split( $s, $reg [, $limit [, $flags] ] )::
            // preg_split( $reg, $s [, $limit [, $flags] ] )
            // TODO the last two parameters.
            case "preg_split": return array( array( "%s", "%reg" ), 
                    self::functionCall( "preg_split", array( "%reg", "%s" ) ) );

            // preg_grep( $reg, $a [, $flags] )::
            // preg_grep( $reg, $a [, $flags] )
            case "preg_grep": return array( array( "%array", "%reg" ), 
                    self::functionCall( "preg_grep", array( "%reg", "%array" ) ) );


                    /*
- *string* preg_quote( $s [, $delim] )::
    preg_quote( $s [, $delim] )

array* preg_split( $reg, $s [, $limit [, $flags] ] )::
  preg_split( $reg, $s [, $limit [, $flags] ] )

- *array* preg_grep( $reg, $a [, $flags] )::

    preg_grep( $reg, $a [, $flags] )
    */


        }

        return null;
    }
}
?>
