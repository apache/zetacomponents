<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionAbstractTypeTest extends ezcTestCase
{
    /**
     * @var ezcReflectionAbstractType
     */
    protected $type;

    protected function setUp()
    {
        $this->type = $this->getMock(
            'ezcReflectionAbstractType',
            null,
            array( 'string' )
        );
    }

    protected function tearDown()
    {
        $this->type = null;
    }

    public function testGetTypeName()
    {
        self::assertEquals( 'string', $this->type->getTypeName() );
    }

    public function testToString()
    {
        self::assertEquals( $this->type->getTypeName(), (string) $this->type );
    }

    public function testIsArray()
    {
        $this->assertFalse( $this->type->isArray() );
    }

    public function testIsObject()
    {
        $this->assertFalse( $this->type->isObject() );
    }

    public function testIsPrimitive()
    {
        $this->assertFalse( $this->type->isPrimitive() );
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
        $this->assertEquals( 'xsd:string', $this->type->getXmlName() );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'string', $this->type->getXmlName( false ) );
    }

    public function testGetXmlSchema()
    {
        $this->assertNull( $this->type->getXmlSchema( new DOMDocument() ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionAbstractTypeTest' );
    }
}
?>
