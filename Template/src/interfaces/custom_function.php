<?php
/**
 * File containing the ezcTemplateCustomFunction class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface for classes which provides custom functions to the template engine.
 * The classes must implement this interface and then return a
 * ezcTemplateCustomFunctionDefinition object from the method
 * getCustomFunctionDefinition().
 *
 * @package Template
 * @version //autogen//
 */
interface ezcTemplateCustomFunction
{
    public static function getCustomFunctionDefinition( $name );
}

?>
