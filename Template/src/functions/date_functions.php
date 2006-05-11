<?php
/**
 * File containing the ezcTemplateDateFunctions class
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
class ezcTemplateDateFunctions extends ezcTemplateFunctions
{
    public static function getFunctionSubstitution( $functionName, $parameters )
    {
        switch( $functionName )
        {
            // date( $format, $timestamp )
            case "date_format":
                return array( array( "%format", "%timestamp" ), self::functionCall( "date", array( "%format", "%timestamp" ) ) );
        }

        return null;
    }
}
