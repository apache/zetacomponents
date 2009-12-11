<?php
/**
 * File containing the ezcReflectionArrayType class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provides type information of the array item type or map types
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 * @todo add support for ArrayAccess stuff from http://www.php.net/~helly/php/ext/spl/
 */
class ezcReflectionArrayType extends ezcReflectionAbstractType {

    /**
     * @var string
     */
    const TYPE_NAME_REGEXP = '/(.*)(\((.*?)(=>(.*?))?\))/';
    
    /**
     * @var ezcReflectionType
     */
    private $arrayType = null;

    /**
     * @var ezcReflectionType
     */
    private $mapKeyType = null;

    /**
     * @var ezcReflectionType
     */
    private $mapValueType = null;

    /**
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        $this->typeName = $typeName;
        $this->_parseTypeName();
    }

    /**
     * Returns type of array items or null
     *
     * @return ezcReflectionType
     */
    public function getArrayType()
    {
        return $this->arrayType;
    }

    /**
     * Returns key type of map items or null
     *
     * @return ezcReflectionType
     */
    public function getMapIndexType()
    {
        return $this->mapKeyType;
    }

    /**
     * Returns value type of map items or null
     *
     * @return ezcReflectionType
     */
    public function getMapValueType()
    {
        return $this->mapValueType;
    }

    /**
     * @return boolean
     */
    public function isArray()
    {
        return ($this->arrayType != null);
    }

    /**
     * @return boolean
     */
    public function isMap()
    {
        return ($this->mapKeyType != null);
    }

    protected function _parseTypeName()
    {
        $seamsToBeMap = false;
        $pos = strrpos($this->typeName, '[');
        //there seams to be an array
        if ($pos !== false) {
            //proof there is no array map annotation around
            $posm = strrpos($this->typeName, ')');
            if ($posm !== false) {
                if ($posm < $pos) {
                    $typeName = substr($this->typeName, 0, $pos);
                    $this->arrayType
                       = ezcReflectionApi::getTypeByName($typeName);
                }
            }
            else {
                $typeName = substr($this->typeName, 0, $pos);
                $this->arrayType
                   = ezcReflectionApi::getTypeByName($typeName);
            }
        }
        //TODO: add support for array(integer => mixed)
        if (preg_match(self::TYPE_NAME_REGEXP, $this->typeName, $matches)) {
            $type1 = null;
            $type2 = null;
            if (isset($matches[3])) {
                $type1 = ezcReflectionApi::getTypeByName($matches[3]);
            }
            if (isset($matches[5])) {
                $type2 = ezcReflectionApi::getTypeByName($matches[5]);
            }

            if ($type1 == null and $type2 != null) {
                $this->arrayType = $type2;
            }
            elseif ($type1 != null and $type2 == null) {
                $this->arrayType = $type1;
            }
            elseif ($type1 != null and $type2 != null) {
                $this->mapKeyType = $type1;
                $this->mapValueType = $type2;
            }
        }
    }

    /**
     * @return string
     * @todo change getTypeName output for map types
     */
    public function getTypeName()
    {
        if ($this->isArray()) {
            return $this->arrayType->getTypeName().'[]';
        }
        else if ($this->isMap()) {
            return 'array('.$this->mapKeyType->getTypeName()
                        .' => '.$this->mapValueType->getTypeName().')';
        }
        return $this->typeName;
    }

    /**
     * Returns XML Schema name of the complexType for the array
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
        if ($this->isArray()) {
            return $prefix . 'ArrayOf'.$this->arrayType->getXmlName(false);
        }
        elseif ($this->isMap()) {
            throw new Exception('XML Schema mapping is not supported for map-types');
        }
    }

    /**
     * @return string
     */
    function getNamespace() {
        return '';
    }

    /**
     * Returns an <xsd:complexType/>
     *
     * @example
     *   <xs:complexType name="ArrayOfLecture">
     *     <xs:sequence>
     *        <xs:element minOccurs="0" maxOccurs="unbounded"
     *                    name="Lecture" nillable="true" type="tns:Lecture" />
     *     </xs:sequence>
     *   </xs:complexType>
     *
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema(DOMDocument $dom, $namespaceXMLSchema = 'http://www.w3.org/2001/XMLSchema') {
        if ($this->isMap()) {
            throw new Exception('XML Schema mapping is not supported for map-types');
        }

        $schema = $dom->createElementNS($namespaceXMLSchema, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName(false));

        $seq = $dom->createElementNS($namespaceXMLSchema, 'xsd:sequence');
        $schema->appendChild($seq);
        $elm = $dom->createElementNS($namespaceXMLSchema, 'xsd:element');
        $seq->appendChild($elm);

        $elm->setAttribute('minOccurs', '0');
        $elm->setAttribute('maxOccurs', 'unbounded');
        $elm->setAttribute('nillable', 'true');

        $elm->setAttribute('name', $this->arrayType->getXmlName(false));
        $elm->setAttribute('type', $this->arrayType->getXmlName(true));

        return $schema;
    }
}

?>
