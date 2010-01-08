<?php
/**
 * File containing the ezcTemplateCustomBlock class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface for classes which provides custom blocks to the template engine.
 * The classes must implement this interface and then return a
 * ezcTemplateCustomBlockDefinition object from the method
 * getCustomBlockDefinition().
 *
 * @package Template
 * @version //autogen//
 */
interface ezcTemplateCustomBlock
{
    /**
     * Return a ezcTemplateCustomBlockDefinition for the given block $name.
     *
     * @param string $name
     * @return ezcTemplateCustomBlockDefinition
     */
    public static function getCustomBlockDefinition( $name );
}

?>
