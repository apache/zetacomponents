<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionArrayTypeTest extends ezcReflectionPrimitiveTypeTest
{
    /**
     * @var ezcReflectionArrayType
     */
    protected $type;

    public function setUp()
    {
        $this->type = new ezcReflectionArrayType( 'string[]' );
    }

    public function testGetTypeName()
    {
        self::assertEquals( 'string[]', $this->type->getTypeName() );
    }

    public function testGetGetKeyType()
    {
        $this->assertEquals( new ezcReflectionPrimitiveType( 'integer' ), $this->type->getKeyType() );
    }

    public function testGetValueType()
    {
        $this->assertEquals( new ezcReflectionPrimitiveType( 'string' ), $this->type->getValueType() );
    }

    public function testIsArray()
    {
        $this->assertTrue( $this->type->isArray() );
    }

    public function testIsMap()
    {
        $this->assertFalse( $this->type->isMap() );
    }

    public function testIsScalarType()
    {
        $this->assertFalse( $this->type->isScalarType() );
    }

    public function testGetXmlNameWithPrefix()
    {
        $this->assertEquals( 'tns:ArrayOfstring', $this->type->getXmlName( ) );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'ArrayOfstring', $this->type->getXmlName( false ) );
    }

    public function testGetNamespace()
    {
        $this->assertEquals( '', $this->type->getNamespace() );
    }

    public function testGetXmlSchema()
    {
        $expected = new DOMDocument;
        $expected->preserveWhiteSpace = false;
        $expected->load( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'array.xsd' );

        $actual = new DOMDocument;
        $actual->appendChild( $this->type->getXmlSchema( $actual ) );

        $this->assertEquals( $expected, $actual );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcReflectionArrayTypeTest' );
    }
}
?>
