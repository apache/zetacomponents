<?php
/**
 * File containing the ezcReflectionObjectType class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Reflection
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Representation for all class types
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionObjectType extends ezcReflectionPrimitiveType {

    /**
     * @var ReflectionClass
     */
    private $class;
    
    /**
     * Constructs a new ezcReflectionObjectType object.
     *
     * @param string|ReflectionClass $class
     *        Name or ReflectionClass object of the class to be
     *        reflected
     */
    public function __construct( $class )
    {
        if ( $class instanceof ReflectionClass )
        {
            $this->setClass( $class );
            parent::__construct( $this->getClass()->getName() );
        }
        else
        {
            parent::__construct( $class );
        }
    }

    /**
     * @return boolean
     */
    public function isObject()
    {
        return true;
    }

    /**
     * 
     * @param ReflectionClass $class
     * @return void
     */
    function setClass( ReflectionClass $class ) {
    	$this->class = $class;
    }
    
    /**
     * @return ezcReflectionClass
     * @throws ReflectionException if the specified class doesn't exist
     */
    public function getClass()
    {
        if ( empty( $this->class ) )
        {
            $typeName = $this->getTypeName();
            if ( $typeName == ezcReflectionTypeMapper::CANONICAL_NAME_OBJECT )
            {
                $typeName = 'stdClass';
            }
            $this->setClass( new ezcReflectionClass( $typeName ) );
        }
        return $this->class;
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
        return $prefix . $this->getClass()->getName();
    }

    /**
     * Returns an <xsd:complexType/>
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema(DOMDocument $dom, $namespaceXMLSchema = 'http://www.w3.org/2001/XMLSchema') {

        $schema = $dom->createElementNS($namespaceXMLSchema, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName(false));


        $parent = $this->getClass()->getParentClass();
        //if we have a parent class, we will include this infos in the xsd
        if ($parent != null) {
            $parent = new self( $parent );
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
        $props = $this->getClass()->getProperties();
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
