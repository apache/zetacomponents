<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionMixedTypeTest extends ezcReflectionAbstractTypeTest
{
    /**#@+
     * @var ezcReflectionMixedType
     */
    protected $type;
    protected $number;
    protected $callback;
    /**#@-*/

    public function setUp()
    {
        $this->type = new ezcReflectionMixedType( 'mixed' );
        $this->number = new ezcReflectionMixedType( 'number' );
        $this->callback = new ezcReflectionMixedType( 'callback' );
        $this->pipeNotation = new ezcReflectionMixedType( 'string|integer' );
    }

    public function testGetTypes()
    {
        $types = $this->type->getTypes();
        $this->assertTrue( is_array( $types ) );
        $this->assertEquals( 0, count( $types ) );
    }

    public function testGetTypesForNumber()
    {
        $types = $this->number->getTypes();
        $this->assertTrue( is_array( $types ) );
        $this->assertEquals( 2, count( $types ) );
        $this->assertContainsOnly( 'ezcReflectionPrimitiveType' , $types );
        $this->assertTrue( $types[0]->isScalarType() );
        $this->assertTrue( $types[1]->isScalarType() );
        $this->assertEquals( 'integer', $types[0]->getTypeName() );
        $this->assertEquals( 'float',   $types[1]->getTypeName() );
    }

    public function testGetTypesForCallback()
    {
        $types = $this->callback->getTypes();
        $this->assertTrue( is_array( $types ) );
        $this->assertEquals( 3, count( $types ) );
        $this->assertContainsOnly( 'ezcReflectionType' , $types );
        $this->assertTrue( $types[0]->isScalarType() );
        $this->assertTrue( $types[1]->isArray() );
        $this->assertTrue( $types[1]->isList() );
        $this->assertType( 'ezcReflectionMixedType', $types[1]->getValueType() );
        $this->assertTrue( $types[2]->isObject() );
        $this->assertEquals( 'string',  $types[0]->getTypeName() );
        $this->assertEquals( 'mixed[]', $types[1]->getTypeName() );
        $this->assertEquals( 'Closure', $types[2]->getClass()->getName() );
    }

    public function testGetTypeName()
    {
        $this->assertEquals( 'mixed',    $this->type->getTypeName() );
        $this->assertEquals( 'number',   $this->number->getTypeName() );
        $this->assertEquals( 'callback', $this->callback->getTypeName() );
    }

    public function testGetXmlNameWithPrefix()
    {
        $this->assertEquals( 'xsd:any', $this->type->getXmlName() );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'any', $this->type->getXmlName( false ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
