<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionObjectTypeTest extends ezcTestCase
{

    /**#@+
     * @var ezcReflectionObjectType
     * @deprecated
     */
    protected $class;
    protected $classTestWebservice;
    protected $classReflectionFunction;
    protected $type;
    /**#@-*/

    public function setUp()
    {
        $this->class                   = new ezcReflectionObjectType( 'SomeClass' );
        $this->classTestWebservice     = new ezcReflectionObjectType( 'TestWebservice' );
        $this->classReflectionFunction = new ezcReflectionObjectType( 'ReflectionFunction' );
        $this->stdClass = new ezcReflectionObjectType( 'stdClass' );
        $this->object = new ezcReflectionObjectType( 'object' );
        $this->type                   = new ezcReflectionObjectType( 'SomeClass' );
    }
    
    public function testGetTypeName() {
    	$this->assertEquals( 'SomeClass', $this->class->getTypeName() );
    	$this->assertEquals( 'TestWebservice', $this->classTestWebservice->getTypeName() );
      	$this->assertEquals( 'ReflectionFunction', $this->classReflectionFunction->getTypeName() );
    	$this->assertEquals( 'stdClass', $this->stdClass->getTypeName() );
    	$this->assertEquals( 'object', $this->object->getTypeName() );
    }

    public function testGetClass() {
    	$this->assertEquals( 'SomeClass', $this->class->getClass()->getName() );
    	$this->assertEquals( 'TestWebservice', $this->classTestWebservice->getClass()->getName() );
      	$this->assertEquals( 'ReflectionFunction', $this->classReflectionFunction->getClass()->getName() );
    	$this->assertEquals( 'stdClass', $this->stdClass->getClass()->getName() );
    	$this->assertEquals( 'stdClass', $this->object->getClass()->getName() );
    }

    public function testIsArray()
    {
        $this->assertFalse( $this->class->isArray() );
    }

    public function testIsObject()
    {
        $this->assertTrue( $this->class->isObject() );
    }

    public function testIsPrimitive()
    {
        $this->assertTrue( $this->class->isPrimitive() );
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
        $expected = new DOMDocument;
        $expected->preserveWhiteSpace = false;
        $expected->load( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'stdClass.xsd' );

        $actual = new DOMDocument;
        $actual->appendChild( $this->stdClass->getXmlSchema( $actual ) );

        $this->assertEquals( $expected, $actual );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionObjectTypeTest' );
    }
}
?>
