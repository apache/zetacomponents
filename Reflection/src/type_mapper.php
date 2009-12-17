<?php
/**
 * File containing the ezcReflectionTypeMapper class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provides mapping from type names used in documentation to standardized
 * type names
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionTypeMapper
{

    // scalar types
    const CANONICAL_NAME_BOOLEAN  = 'boolean';
    const CANONICAL_NAME_INTEGER  = 'integer';
    const CANONICAL_NAME_FLOAT    = 'float';
    const CANONICAL_NAME_STRING   = 'string';
    
    // compound types
    const CANONICAL_NAME_ARRAY    = 'array';
    const CANONICAL_NAME_OBJECT   = 'object';
    
    // special types
    const CANONICAL_NAME_RESOURCE = 'resource';
    const CANONICAL_NAME_NULL     = 'NULL';
    
    // pseudo-types for readability reasons
    const CANONICAL_NAME_MIXED    = 'mixed';
    const CANONICAL_NAME_CALLBACK = 'callback';
    const CANONICAL_NAME_NUMBER   = 'number';
    
    // regular expressions for complex array notations
    const REGEXP_TYPE_NAME_LIST = '/^(.+)\[\]$/';
    const REGEXP_TYPE_NAME_MAP  = '/^array\s*\((\S+?)=>(\S+)\)$/';

    /**
     * @var ezcReflectionTypeMapper
     */
    private static $instance = null;

    /**
     * @var array<string,string>
     */
    protected $mappingTable;

    /**
     * @var array<string,string>
     */
    protected $xmlMappingTable;

    /**
     * Constructs a type mapper
     */
    private function __construct()
    {
        $this->initMappingTable();
    }

    /**
     * @return ezcReflectionTypeMapper
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ezcReflectionTypeMapper();
        }
        return self::$instance;
    }

    /**
     * @return void
     */
    protected function initMappingTable()
    {
        $this->mappingTable['int']     = self::CANONICAL_NAME_INTEGER;
        $this->mappingTable['integer'] = self::CANONICAL_NAME_INTEGER;
        $this->mappingTable['long']    = self::CANONICAL_NAME_INTEGER;
        $this->mappingTable['short']   = self::CANONICAL_NAME_INTEGER;
        $this->mappingTable['byte']    = self::CANONICAL_NAME_INTEGER;

        $this->mappingTable['boolean'] = self::CANONICAL_NAME_BOOLEAN;
        $this->mappingTable['bool']    = self::CANONICAL_NAME_BOOLEAN;
        $this->mappingTable['true']    = self::CANONICAL_NAME_BOOLEAN;
        $this->mappingTable['false']   = self::CANONICAL_NAME_BOOLEAN;

        $this->mappingTable['float']   = self::CANONICAL_NAME_FLOAT;
        $this->mappingTable['double']  = self::CANONICAL_NAME_FLOAT;

        $this->mappingTable['string']  = self::CANONICAL_NAME_STRING;
        $this->mappingTable['char']    = self::CANONICAL_NAME_STRING;

        $this->mappingTable['array']   = self::CANONICAL_NAME_ARRAY;
        $this->mappingTable['mixed']   = self::CANONICAL_NAME_MIXED;
        $this->mappingTable['void']    = self::CANONICAL_NAME_NULL;
        $this->mappingTable['null']    = self::CANONICAL_NAME_NULL;
        $this->mappingTable['object']  = self::CANONICAL_NAME_OBJECT;

        /*
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            boolean has the 'value space' required to support the mathematical
            concept of binary-valued logic: {true, false}.
            An instance of a datatype that is defined as 'boolean' can have the
            following legal literals {true, false, 1, 0}.
        */
        $this->xmlMappingTable[self::CANONICAL_NAME_BOOLEAN] = 'boolean';

        /*
        PHP Manual:
            The size of an integer is platform-dependent, although a maximum value
            of about two billion is the usual value (that's 32 bits signed).
            PHP does not support unsigned integers.
            [...]
            If you specify a number beyond the bounds of the integer type,
            it will be interpreted as a float instead. Also, if you perform
            an operation that results in a number beyond the bounds of the
            integer type, a float will be returned instead.
            [...]
            boundaries of integer (usually +/- 2.15e+9 = 2^31)
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            int is 'derived' from long by setting the value of 'maxInclusive'
            to be 2147483647 and 'minInclusive' to be -2147483648.
        */
        $this->xmlMappingTable[self::CANONICAL_NAME_INTEGER] = 'int';

        /*
        PHP Manual:
            The size of a float is platform-dependent, although a maximum
            of ~1.8e308 with a precision of roughly 14 decimal digits is a
            common value (that's 64 bit IEEE format).
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            float is patterned after the IEEE single-precision 32-bit floating
            point type [IEEE 754-1985].
            [...]
            The double datatype is patterned after the IEEE double-precision
            64-bit floating point type [IEEE 754-1985].
        */
        //$this->xmlMappingTable[self::CANONICAL_NAME_FLOAT]   = 'float';
        $this->xmlMappingTable[self::CANONICAL_NAME_FLOAT]   = 'double'; // according to the PHP Manual `double' seems to be appropriate

        /*
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            The string datatype represents character strings in XML.
        */
        $this->xmlMappingTable[self::CANONICAL_NAME_STRING]  = 'string';

        $this->xmlMappingTable[self::CANONICAL_NAME_MIXED]   = 'any';
    }

    /**
     * Maps a type to a canonical type name
     * @param string $typeName
     * @return string
     */
    public function getTypeName( $typeName ) {
        $typeName = trim( $typeName );
        if ( isset( $this->mappingTable[ strtolower( $typeName ) ] ) )
        {
            return $this->mappingTable[ strtolower( $typeName ) ];
        }
        else
        {
            return $typeName;
        }
    }

    /**
     * Maps a typename to the name of the correspondent XML Schema datatype
     * @param string $typeName
     * @return string
     */
    public function getXmlType($typeName) {
        if (isset($this->xmlMappingTable[$typeName])) {
            // it is assumed that the method is mostly called
            // with the standard name of the type
            return $this->xmlMappingTable[$typeName];
        }
        else {
            // try to obtain the standard name for the type
            $typeName = $this->getTypeName($typeName);
            if (isset($this->xmlMappingTable[$typeName])) {
                return $this->xmlMappingTable[$typeName];
            }
            else {
                return null;
            }
        }
    }

    /**
     * Tests whether the given type is a primitive type.
     * 
     * Types annotated as boolean, float, integer, string, void, or object are
     * considered to be primitive.
     * 
     * @param string $typeName
     * @return boolean
     */
    public function isPrimitive($typeName) {
        if (
            !$this->isMixed( $typeName )
            and !$this->isArray( $typeName )
            and isset( $this->mappingTable[ strtolower( $typeName ) ] )
        )
        {
            return true;
        }
        return false;
    }

    /**
     * Test whether the given type is an array or hash map
     * 
     * @param string $typeName
     * @return boolean
     */
    public function isArray( $typeName )
    {
        $typeName = $this->getTypeName( $typeName );
        if ( strlen( $typeName ) > 0 )
        {
            // last two chars are [], thus it should be something like string[]
            //if ( strlen( $typeName ) > 2 and substr( $typeName, -2 ) == '[]' )
            if ( preg_match( self::REGEXP_TYPE_NAME_LIST, $typeName ) )
            {
                return true;
            }
            
            // may be the author just wrote 'array'
            elseif ( $typeName == self::CANONICAL_NAME_ARRAY )
            {
                return true;
            }

        	// test for array map types array(int=>float)
            elseif ( preg_match( self::REGEXP_TYPE_NAME_MAP, $typeName ) )
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Tests whether the given type is described as mixed, number, or callback.
     * 
     * @param string $typeName
     * @return boolean
     */
    public function isMixed( $typeName )
    {
        $typeName = $this->getTypeName( $typeName ); 
        if (
            $typeName == self::CANONICAL_NAME_MIXED
            or $typeName == self::CANONICAL_NAME_NUMBER
            or $typeName == self::CANONICAL_NAME_CALLBACK
            or preg_match( '/^.+\|.+$/', $typeName )
        )
        {
            return true;
        }
        return false;
    }
}
?>
