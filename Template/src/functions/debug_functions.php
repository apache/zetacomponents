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
class ezcTemplateDebugFunctions extends ezcTemplateFunctions
{
    public static function getFunctionSubstitution( $functionName, $parameters )
    {
        switch( $functionName )
        {
            // TODO improve the output for objects.
            case "debug_dump": return array( array( "%val" ), 
                self::functionCall( "ezcTemplateDebug::debug_dump", array( "%val" ) ) );
        }

        return null;
    }
}
