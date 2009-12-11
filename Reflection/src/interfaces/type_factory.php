<?php
/**
 * File containing the ezcReflectionTypeFactory interface.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface definition for the type factory used by the reflection
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
interface ezcReflectionTypeFactory {

    /**
     * Creates a type object for given typeName
     * @param string $typeName
     * @return ezcReflectionType
     */
    function getType($typeName);
}

?>