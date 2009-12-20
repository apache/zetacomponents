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
     * @return boolean
     */
    public function isArray();

    /**
     * @return boolean
     */
    public function isObject();

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
     * Returns whether this type is one of integer, float, string, or boolean.
     * 
     * Types array, object, resource, NULL, mixed, number, and callback are not
     * scalar.
     * 
     * @return boolean
     */
    public function isScalarType();

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
