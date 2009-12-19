<?php
/**
 * File containing the ezcReflectionClassType class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Representation for all class types
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionClassType extends ezcReflectionClass implements ezcReflectionType {

    /**
     * @return boolean
     */
    public function isArray() {
        return false;
    }

    /**
     * @return boolean
     */
    public function isClass()
    {
        return true;
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
     * @return string
     */
    function getTypeName()
    {
        return $this->getName();
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
        return false;
    }

    /**
     * Returns XML Schema name of the complexType for the class
     *
     * The `this namespace' (tns) prefix is comonly used to refer to the
     * current XML Schema document.
     *
     * @param boolean $usePrefix augments common prefix `tns:' to the name
     * @return string
     */
    function getXmlName($usePrefix = true) {
        if ($usePrefix) {
            $prefix = 'tns:';
        } else {
            $prefix = '';
        }
        return $prefix . $this->getName();
    }

    /**
     * Returns an <xsd:complexType/>
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema(DOMDocument $dom, $namespaceXMLSchema = 'http://www.w3.org/2001/XMLSchema') {

        $schema = $dom->createElementNS($namespaceXMLSchema, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName(false));


        $parent = $this->getParentClass();
        //if we have a parent class, we will include this infos in the xsd
        if ($parent != null) {
            $complex = $dom->createElementNS($namespaceXMLSchema, 'xsd:complexContent');
            $complex->setAttribute('mixed', 'false');
            $ext = $dom->createElementNS($namespaceXMLSchema, 'xsd:extension');
            $ext->setAttribute('base', $parent->getXmlName(true));
            $complex->appendChild($ext);
            $schema->appendChild($complex);
            $root = $ext;
        }
        else {
            $root = $schema;
        }

        $seq = $dom->createElementNS($namespaceXMLSchema, 'xsd:sequence');
        $root->appendChild($seq);
        $props = $this->getProperties();
        foreach ($props as $property) {
            $type = $property->getType();
            if ($type != null and !$type->isMap()) {
                $elm = $dom->createElementNS($namespaceXMLSchema, 'xsd:element');
                $elm->setAttribute('minOccurs', '0');
                $elm->setAttribute('maxOccurs', '1');
                $elm->setAttribute('nillable', 'true');

                $elm->setAttribute('name', $property->getName());
                $elm->setAttribute('type', $type->getXmlName(true));
            	$seq->appendChild($elm);
        	}
        }
        return $schema;
    }

}
?>
