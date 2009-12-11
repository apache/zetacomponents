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
     * @return boolean
     */
    function isStandardType()
    {
        if ( $this->getTypeName() != ezcReflectionTypeMapper::CANONICAL_NAME_NULL )
        {
            return true;
        }
        return false;
    }

}