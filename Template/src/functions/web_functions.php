<?php
/**
 * File containing the ezcTemplateWebFunctions class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateWebFunctions extends ezcTemplateFunctions
{
    public static function getFunctionSubstitution( $functionName, $parameters )
    {
        switch( $functionName )
        {
            // base64_encode( $s )
            case "base64_encode":
                return array( array( "%string" ), self::functionCall( "base64_encode", array( "%string" ) ) );
            
            // base64_decode( $s )
            case "base64_decode":
                return array( array( "%string" ), self::functionCall( "base64_decode", array( "%string" ) ) );
            
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
