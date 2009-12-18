<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionClassTypeTest extends ezcReflectionClassTest
{
    public function setUpFixtures()
    {
        $this->class                   = new ezcReflectionClassType( 'SomeClass' );
        $this->classTestWebservice     = new ezcReflectionClassType( 'TestWebservice' );
        $this->classReflectionFunction = new ezcReflectionClassType( 'ReflectionFunction' );
    }

    public function testGetArrayType()
    {
        $this->assertNull( $this->class->getArrayType() );
    }

    public function testGetMapIndexType()
    {
        $this->assertNull( $this->class->getMapIndexType() );
    }

    public function testGetMapValueType()
    {
        $this->assertNull( $this->class->getMapValueType() );
    }

    public function testIsArray()
    {
        $this->assertFalse( $this->class->isArray() );
    }

    public function testIsClass()
    {
        $this->assertTrue( $this->class->isClass() );
    }

    public function testIsPrimitive()
    {
        $this->assertFalse( $this->class->isPrimitive() );
    }

    public function testIsMap()
    {
        $this->assertFalse( $this->class->isMap() );
    }

    public function testToString()
    {
        $this->assertEquals( 'SomeClass', $this->class->getTypeName() );
    }

    public function testIsScalarType()
    {
        $this->assertFalse( $this->class->isScalarType() );
    }

    public function testGetXmlNameWithPrefix()
    {
        $this->assertEquals( 'tns:SomeClass', $this->class->getXmlName( true ) );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'SomeClass', $this->class->getXmlName( false ) );
    }

    public function testGetXmlSchema()
    {
        $expected = new DOMDocument;
        $expected->preserveWhiteSpace = false;
        $expected->load( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'SomeClass.xsd' );

        $actual = new DOMDocument;
        $actual->appendChild( $this->class->getXmlSchema( $actual ) );

        $this->assertEquals( $expected, $actual );
    }

    public function testGetXmlSchema2()
    {
        $this->class = new ezcReflectionClassType( 'stdClass' );

        $expected = new DOMDocument;
        $expected->preserveWhiteSpace = false;
        $expected->load( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'stdClass.xsd' );

        $actual = new DOMDocument;
        $actual->appendChild( $this->class->getXmlSchema( $actual ) );

        $this->assertEquals( $expected, $actual );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionClassTypeTest' );
    }
}
?>
