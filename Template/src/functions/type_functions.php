<?php
/**
 * File containing the ezcTemplateTypeFunctions class
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
class ezcTemplateTypeFunctions extends ezcTemplateFunctions
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
            // is_empty( $v )::
            // empty( $v )
            case "is_empty": return array( array( "%var" ), 
                    self::functionCall( "ezcTemplateType::is_empty", array( "%var" ) ) );

            // is_array( $v )::
            // is_array( $v )
            case "is_array": return array( array( "%var" ), 
                    self::functionCall( "is_array", array( "%var" ) ) );

            // is_bool( $v )::
            // is_bool( $v )
            case "is_bool": return array( array( "%var" ), 
                    self::functionCall( "is_bool", array( "%var" ) ) );

            // is_float( $v )::
            // is_float( $v )
            case "is_float": return array( array( "%var" ), 
                    self::functionCall( "is_float", array( "%var" ) ) );

            // is_int( $v )::
            // is_int( $v )
            case "is_int": return array( array( "%var" ), 
                    self::functionCall( "is_int", array( "%var" ) ) );
                    
            // is_bool( $v )::
            // is_bool( $v )
            case "is_bool": return array( array( "%var" ), 
                    self::functionCall( "is_bool", array( "%var" ) ) );


            // is_numeric( $v )::
            // is_numeric( $v )
            case "is_numeric": return array( array( "%var" ), 
                    self::functionCall( "is_numeric", array( "%var" ) ) );

            // is_object( $v )::
            // is_object( $v ) ?
            case "is_object": return array( array( "%var" ), 
                    self::functionCall( "is_object", array( "%var" ) ) );

            // is_class( $v, $class )::
            // getclass( $v ) == $class
            case "is_class": return array( 
                ezcTemplateAstNode::TYPE_VALUE,
                array( "%var", "%class" ), 

                array( "ezcTemplateIdenticalOperatorAstNode", array( 
                    self::functionCall( "get_class", array( "%var" ) ),
                    "%class" )
                ) );

            // instanceof.
            case "is_instance": return array( 
                ezcTemplateAstnode::TYPE_VALUE,
                array( "%var", "%class" ), 
                self::functionCall( "ezcTemplateType::is_instance", array( "%var", "%class" ) ) );


            // is_scalar( $v )::
            // is_scalar( $v )
            case "is_scalar": return array( array( "%var" ), 
                    self::functionCall( "is_scalar", array( "%var" ) ) );

            // is_string( $v )::
            // is_string( $v )
            case "is_string": return array( array( "%var" ), 
                    self::functionCall( "is_string", array( "%var" ) ) );

            // is_set( $v )::
            // is_set( $v )
            case "is_set": return array( array( "%var:Variable" ), 
                    self::functionCall( "isset", array( "%var:Variable" ) ) );

            // is_constant( $const )::
            // return defined( $const )
            case "is_constant": return array( array( "%var" ), 
                    self::functionCall( "defined", array( "%var" ) ) );

            // get_constant( $const )::
            // constant( $const );
            case "get_constant": return array( array( "%var" ), 
                    self::functionCall( "constant", array( "%var" ) ) );

            // get_class( $var )::
            // get_class( $var );
            case "get_class": return array( array( "%var" ), 
                    self::functionCall( "get_class", array( "%var" ) ) );

            // cast_string( $v )::
            // (string)$v
            case "cast_string": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array( "string", "%var" ) )  );

            // cast_int( $v )::
            // (int)$v
            case "cast_int": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array( "int", "%var" ) )  );

            // cast_float( $v )::
            // (float)$v
            case "cast_float": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array( "float", "%var" ) )  );

        }

        return null;
    }
}
?>
