<?php
/**
 * File containing the ezcTemplateFunctions class
 *
 * @package TemplateFunctions
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateTypeFunctions extends ezcTemplateFunctions
{
    public static function getFunctionSubstitution( $functionName, $parameters )
    {
        switch( $functionName )
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
            // TODO, needs to be tested.
            case "is_class": return array( array( "%var", "%class" ), 
                array( "ezcTemplateEqualOperatorAstNode", array( 
                    self::functionCall( "getclass", array( "%var" ) ),
                    self::value( "%class" )
                ) ) );

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
            case "is_set": return array( array( "%var" ), 
                    self::functionCall( "isset", array( "%var" ) ) );

            // is_constant( $const )::
            // return defined( $const )
            case "is_constant": return array( array( "%var" ), 
                    self::functionCall( "defined", array( "%var" ) ) );

            // get_constant( $const )::
            // constant( $const );
            case "get_constant": return array( array( "%var" ), 
                    self::functionCall( "constant", array( "%var" ) ) );

            // get_class( $var )::
            // getclass( $var );
            case "get_class": return array( array( "%var" ), 
                    self::functionCall( "getclass", array( "%var" ) ) );

            // cast_string( $v )::
            // (string)$v
            case "cast_string": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array("string", "%var") )  );

            // cast_int( $v )::
            // (int)$v
            case "cast_int": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array("int", "%var") )  );

            // cast_float( $v )::
            // (float)$v
            case "cast_float": return array( array( "%var" ), 
                    array( "ezcTemplateTypeCastAstNode", array("float", "%var") )  );

        }

        return null;
    }
}
