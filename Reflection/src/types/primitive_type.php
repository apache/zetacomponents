<?php
/**
 * File containing the ezcReflectionPrimitiveType class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Representation for all primitive types like string, integer, float
 * and boolean
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionPrimitiveType extends ezcReflectionAbstractType {

    /**
     * @return boolean
     */
    public function isPrimitive()
    {
        return true;
    }

    /**
     * Returns whether this type is one of integer, float, string, or boolean.
     * 
     * Types array, object, resource, NULL, mixed, number, and callback are not
     * scalar.
     * 
     * @return boolean
     */
    function isScalarType()
    {
        if ( in_array(
            $this->getTypeName(),
            array(
                ezcReflectionTypeMapper::CANONICAL_NAME_BOOLEAN,
                ezcReflectionTypeMapper::CANONICAL_NAME_INTEGER,
                ezcReflectionTypeMapper::CANONICAL_NAME_FLOAT,
                ezcReflectionTypeMapper::CANONICAL_NAME_STRING
            )
        ))
        {
            return true;
        }
        return false;
    }

}