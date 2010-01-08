<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionPrimitiveTypeTest extends ezcReflectionAbstractTypeTest
{
    /**
     * @var ezcReflectionPrimitiveType
     */
    protected $type;

    public function setUp()
    {
        $this->type = new ezcReflectionPrimitiveType( 'string' );
    }

    public function testIsPrimitive()
    {
        $this->assertTrue( $this->type->isPrimitive() );
    }

    public function testIsScalarType()
    {
        $this->assertTrue( $this->type->isScalarType() );
    }

    public function testIsScalarType2()
    {
        $this->type = new ezcReflectionPrimitiveType( 'void' );

        $this->assertFalse( $this->type->isScalarType() );
    }

    public function testGetXmlNameWithPrefix()
    {
        $this->assertEquals( 'xsd:string', $this->type->getXmlName( true ) );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'string', $this->type->getXmlName( false ) );
    }

    public function testGetXmlSchema()
    {
        $this->assertNull( $this->type->getXmlSchema( new DOMDocument ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionPrimitiveTypeTest' );
    }
}
?>
