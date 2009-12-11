<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionTypeFactoryTest extends ezcTestCase
{
    /**
	 * @var ezcReflectionTypeFactoryImpl
     */
    protected $factory;
    
    public function setUp() {
        $this->factory = new ezcReflectionTypeFactoryImpl();
    }
    
    public function tearDown() {
        unset( $this->factory );
    }
    
    /**
     * Test with primitive types
     */
    public function testGetTypePrimitive() {
        $ezcReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean'/* FIXME ,'void'*/);
        foreach ($ezcReflectionPrimitiveTypes as $prim) {
        	$type = $this->factory->getType($prim);
        	self::assertType('ezcReflectionType', $type);
            self::assertType('ezcReflectionPrimitiveType', $type);
        }
    }

    /**
     * Test with class types
	 * @expectedException ReflectionException
     */
    public function testGetTypeClass() {
        $classes = array('ReflectionClass', 'ezcTestClass');
        foreach ($classes as $class) {
        	$type = $this->factory->getType($class);
        	self::assertType('ezcReflectionType', $type);
            self::assertType('ezcReflectionClassType', $type);
        }

		$type = $this->factory->getType('NoneExistingClass');
    }

    public function getArrayTypeNames() {
        return array(
           array( 'array(integer => string)', 'integer', 'string' ),
           array( 'array(string => ReflectionClass)', 'string', 'ReflectionClass' ),
           array( 'array(ReflectionClass => float)', 'ReflectionClass', 'float' )
           // TODO Test array( 'array(ReflectionClass, float)', 'ReflectionClass', 'float' )
        );
    }
    
    /**
     * Test with array types
     * 
     * @dataProvider getArrayTypeNames
     */
    public function testGetTypeArray($arrayTypeName, $indexTypeName, $valueTypeName) {
        $type = $this->factory->getType($arrayTypeName);
        self::assertType('ezcReflectionType', $type);
        self::assertType('ezcReflectionArrayType', $type);
        self::assertType('ezcReflectionType', $type->getMapIndexType());
        self::assertType('ezcReflectionType', $type->getMapValueType());
        self::assertEquals($arrayTypeName, $type->getTypeName());
        self::assertEquals($indexTypeName, $type->getMapIndexType()->getTypeName());
        self::assertEquals($valueTypeName, $type->getMapValueType()->getTypeName());
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionTypeFactoryTest" );
    }
}
?>
