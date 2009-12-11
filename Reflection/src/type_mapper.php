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
        $boolean = 'boolean';
        $integer = 'integer';
        $float   = 'float';
        $string  = 'string';
        $array   = 'array';
        $mixed   = 'mixed';
        $void    = 'void';
        $object  = 'object';

        $this->mappingTable['int']     = $integer;
        $this->mappingTable['integer'] = $integer;
        $this->mappingTable['long']    = $integer;
        $this->mappingTable['short']   = $integer;
        $this->mappingTable['byte']    = $integer;

        $this->mappingTable['boolean'] = $boolean;
        $this->mappingTable['bool']    = $boolean;
        $this->mappingTable['true']    = $boolean;
        $this->mappingTable['false']   = $boolean;

        $this->mappingTable['float']   = $float;
        $this->mappingTable['double']  = $float;

        $this->mappingTable['string']  = $string;
        $this->mappingTable['char']    = $string;

        $this->mappingTable['array']   = $array;
        $this->mappingTable['mixed']   = $mixed;
        $this->mappingTable['void']    = $void;
        $this->mappingTable['object']  = $object;

        /*
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            boolean has the 'value space' required to support the mathematical
            concept of binary-valued logic: {true, false}.
            An instance of a datatype that is defined as 'boolean' can have the
            following legal literals {true, false, 1, 0}.
        */
        $this->xmlMappingTable[$boolean] = 'boolean';

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
        $this->xmlMappingTable[$integer] = 'int';

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
        //$this->xmlMappingTable[$float]   = 'float';
        $this->xmlMappingTable[$float]   = 'double'; // according to the PHP Manual `double' seems to be appropriate

        /*
        XML Schema Part 2 - Datatypes Second Edition (24 Oktober 2004):
            The string datatype represents character strings in XML.
        */
        $this->xmlMappingTable[$string]  = 'string';

        $this->xmlMappingTable[$mixed]   = 'any';
    }

    /**
     * Maps a type to a standard type name
     * @param string $type
     * @return string
     */
    public function getType($type) {
        if (isset($this->mappingTable[strtolower($type)])) {
            return $this->mappingTable[strtolower($type)];
        }
        else {
            return $type;
        }
    }

    /**
     * Maps a typename to the name of the correspondent XML Schema datatype
     * @param string $type
     * @return string
     */
    public function getXmlType($type) {
        if (isset($this->xmlMappingTable[$type])) {
            // it is assumed that the method is mostly called
            // with the standard name of the type
            return $this->xmlMappingTable[$type];
        }
        else {
            // try to obtain the standard name for the type
            $type = $this->getType($type);
            if (isset($this->xmlMappingTable[$type])) {
                return $this->xmlMappingTable[$type];
            }
            else {
                return null;
            }
        }
    }

    /**
     * Tests whether the given type is a primitive type
     * @param string $type
     * @return boolean
     */
    public function isPrimitive($type) {
        if (
            $this->getType($type) != 'array'
            and $this->getType($type) != 'mixed'
            and isset($this->mappingTable[strtolower($type)])
        )
        {
            return true;
        }
        return false;
    }

    /**
     * Test whether the given type is an array or hash map
     * @param string $type
     * @return boolean
     */
    public function isArray($type) {
        $type = trim($type);
        if (strlen($type) > 0) {
            //last char is ] so it should be something like array[]
            if ($type{strlen($type)-1} == ']') {
                return true;
            }
            //may be the author just wrote 'array'
            if ($type == 'array') {
                return true;
            }

            //test for array map types array<int,int>
            //@TODO Remove support for array<int, int> definitions
            /*
            elseif (preg_match('/(.*)(<(.*?)(,(.*?))?>)/', $type)) {
                return true;
            }
            */
        	//test for array map types array(int=>int)
            elseif (preg_match(ezcReflectionArrayType::TYPE_NAME_REGEXP, $type)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Test whether the given type is an array or hash map
     * @param string $type
     * @return boolean
     */
    public function isMixed( $type )
    {
        if ( $this->getType( $type ) == $this->mappingTable['mixed'] )
        {
            return true;
        }
        return false;
    }
}
?>
