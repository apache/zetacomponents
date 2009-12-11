<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionTypeMapperTest extends ezcTestCase
{
    public function testIsPrimitive() {
        $ezcReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        foreach ($ezcReflectionPrimitiveTypes as $type) {
        	self::assertTrue(ezcReflectionTypeMapper::getInstance()->isPrimitive($type));
        }

        $noneezcReflectionPrimitiveTypes = array('ReflectionClass', 'array', 'int[]',
                                    'string[]', 'NonExistingClassFooBar');
        foreach ($noneezcReflectionPrimitiveTypes as $type) {
        	self::assertFalse(ezcReflectionTypeMapper::getInstance()->isPrimitive($type));
        }
    }

    public function testIsArray() {
        $arrayDefs = array('array', 'string[]', 'bool[]', 'ReflectionClass[]',
                           'NonExistingTypeFooBar[]');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

        $arrayDefs = array('array(int => string)', 'array(string => ReflectionClass)',
                           'array(ReflectionClass => float)');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

        $noneezcReflectionArrayTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean', 'NonExistingClassFooBar',
                                'ReflectionClass');
        foreach ($noneezcReflectionArrayTypes as $type) {
        	self::assertFalse(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }

    }

    /**
     * Test ez Style arrays
     */
    public function testIsArray2() {
        $arrayDefs = array('array(string=>float)', 'array( int => ReflectionClass )',
                           'array( string => array( int => ReflectionClass ) )');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(ezcReflectionTypeMapper::getInstance()->isArray($type));
        }
    }

    public function testGetXmlTypeWithNonStandardTypeName() {
        self::assertEquals( 'int', ezcReflectionTypeMapper::getInstance()->getXmlType( 'int' ) );
    }

    public function testGetXmlTypeWithNonExistingType() {
        self::assertNull( ezcReflectionTypeMapper::getInstance()->getXmlType( 'NonExistingType' ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionTypeMapperTest" );
    }
}
?>
