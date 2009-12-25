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
class ezcReflectionArrayType extends ezcReflectionPrimitiveType {

    /**#@+
     * @var ezcReflectionType
     */
//    protected $arrayType;
//    protected $mapKeyType;
//    protected $mapValueType;
    protected $keyType;
    protected $valueType;
	/**#@-*/

    /**#@+
     * @var boolean
     */
    protected $isList = false;
	/**#@-*/
    
    /**
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        parent::__construct($typeName);
        $this->_parseTypeName();
    }

    /**
     * Returns true if this array has been documented as a list, i.e., using
     * the notation of any type name followed by a pair of square brakets.
     * 
     * Examples of list types include mixed[], stdClass[], sting[][], or
     * array(mixed=>mixed)[].
     * 
     * @return boolean True this array has been documented as a list.
     */
    public function isList ()
    {
        return $this->isList;
    }
    

    /**
     * Returns key type of the array
     *
     * @return ezcReflectionType
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * Returns value type of the array
     *
     * @return ezcReflectionType
     */
    public function getValueType()
    {
        return $this->valueType;
    }
    
    /**
     * @return boolean
     */
    public function isArray()
    {
        return true;
    }

    /**
     * Returns wether this array is documented as 'array(mixed=>mixed)' or
     * simply 'array'.
     * 
     * @return boolean
     */
    public function isMap()
    {
        return !$this->isList();
    }

    /**
     * Internal method for parsing array type names.
     * 
     * @return void
     */
    protected function _parseTypeName()
    {
        //*
        if ( strlen( $this->typeName ) > 0 )
        {
            // last two chars are [], thus it should be something like string[]
            //if ( strlen( $this->typeName ) > 2 and substr( $this->typeName, -2 ) == '[]' )
            if ( preg_match( ezcReflectionTypeMapper::REGEXP_TYPE_NAME_LIST, $this->typeName, $matches ) )
            {
                $this->isList = true;
                $this->isMap  = false;
                $this->keyType
                    = ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_INTEGER );
                $this->valueType
                   = ezcReflectionApi::getTypeByName( $matches[1] );
            }
            
            // may be the author just wrote 'array'
            elseif ( $this->typeName == ezcReflectionTypeMapper::CANONICAL_NAME_ARRAY )
            {
                $this->isList = false;
                $this->isMap  = true;
                $this->keyType
                    = ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_MIXED );
                $this->valueType
                    = ezcReflectionApi::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_MIXED );
            }

        	// test for array map types array(int=>float)
            elseif ( preg_match( ezcReflectionTypeMapper::REGEXP_TYPE_NAME_MAP, $this->typeName, $matches ) )
            {
                $this->isList = false;
                $this->isMap  = true;
                $this->keyType
                    = ezcReflectionApi::getTypeByName( $matches[1] );
                $this->valueType
                    = ezcReflectionApi::getTypeByName( $matches[2] );
            }
        }
        /*/
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
        // TO BE DONE: add support for array(integer => mixed)
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
        //*/
    }

    /**
     * Returns the canonical name for this array, which can be used in type
     * annotations.
     * 
     * @return string Canonical name for this array
     */
    public function getTypeName()
    {
        if ( $this->isList() )
        {
            return $this->getValueType()->getTypeName().'[]';
        }
        else
        {
            return 'array(' . $this->getKeyType()->getTypeName()
                   . '=>' . $this->getValueType()->getTypeName() . ')';
        }
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
    function getXmlName( $usePrefix = true )
    {
        if ( $usePrefix ) {
            $prefix = 'tns:';
        } else {
            $prefix = '';
        }
        if ( $this->isList() )
        {
            return $prefix . 'ArrayOf' . $this->getValueType()->getXmlName( false );
        }
        else
        {
            throw new Exception( 'XML Schema mapping is not supported for map-types' );
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
        if ( !$this->isList() )
        {
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

        $elm->setAttribute( 'name', $this->getValueType()->getXmlName( false ) );
        $elm->setAttribute( 'type', $this->getValueType()->getXmlName( true ) );

        return $schema;
    }
}

?>
