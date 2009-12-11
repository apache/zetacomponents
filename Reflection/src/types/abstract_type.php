<?php
/**
 * File containing the ezcReflectionAbstractType class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Abstract class provides default implementation for types.
 * Methods do return null or false values as default.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
abstract class ezcReflectionAbstractType implements ezcReflectionType
{

    /**
     * @var string
     */
    protected $typeName = null;

    /**
     * @param string $typeName
     */
    public function __construct( $typeName )
    {
        $this->typeName = ezcReflectionTypeMapper::getInstance()->getType( $typeName );
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Return type of elements in an array type or null if is not an array
     *
     * @return ezcReflectionType
     */
    public function getArrayType()
    {
        return null;
    }

    /**
     * Returns key type of map items or null
     *
     * @return ezcReflectionType
     */
    public function getMapIndexType()
    {
        return null;
    }

    /**
     * Returns value type of map items or null
     *
     * @return ezcReflectionType
     */
    public function getMapValueType()
    {
        return null;
    }

    /**
     * @return boolean
     */
    public function isArray()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isClass()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isPrimitive()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isMap()
    {
        return false;
    }

    /**
     * @return boolean
     */
    function isStandardType()
    {
        return false;
    }

    /**
     * Returns name of the correspondent XML Schema datatype
     *
     * The prefix `xsd' is comonly used to refer to the
     * XML Schema namespace.
     *
     * @param boolean $usePrefix augments common prefix `xsd:' to the name
     * @return string
     */
    function getXmlName($usePrefix = true) {
        if ($usePrefix) {
            $prefix = 'xsd:';
        } else {
            $prefix = '';
        }
        return $prefix . ezcReflectionTypeMapper::getInstance()->getXmlType($this->typeName);
    }

    /**
     * @param  DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema(DOMDocument $dom) {
        return null;
    }

}