<?php
/**
 * File containing the ezcReflectionType interface.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for type objects representing a type/class
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
interface ezcReflectionType {
    /**
     * Return type of elements in an array type or null if is not an array
     *
     * @return ezcReflectionType
     */
    public function getArrayType();

    /**
     * Returns type of key used in a map
     *
     * @return ezcReflectionType
     */
    public function getMapIndexType();

    /**
     * Returns type of values used in a map
     *
     * @return ezcReflectionType
     */
    public function getMapValueType();

    /**
     * @return boolean
     */
    public function isArray();

    /**
     * @return boolean
     */
    public function isClass();

    /**
     * @return boolean
     */
    public function isPrimitive();

    /**
     * @return boolean
     */
    public function isMap();

    /**
     * Return the name of this type as string
     *
     * @return string
     */
    public function getTypeName();

    /**
     * @return boolean
     */
    public function isStandardType();

    /**
     * Returns the name to be used in a xml schema for this type
     * @return string
     */
    public function getXmlName();

    /**
     * @param  DOMDocument $dom
     * @return DOMElement
     */
    public function getXmlSchema(DOMDocument $dom);
}
?>
