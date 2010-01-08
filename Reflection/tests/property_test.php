<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionPropertyTest extends ezcTestCase
{
    /**#@+
     * @var string
     */
	protected $refPropName;
	protected $publicPropertyName;
	protected $undocumentedPropertyName;
	/**#@-*/
	
	/**#@+
     * @var ezcReflectionProperty
     */
    protected $refProp;
    protected $publicProperty;
    /**#@-*/

    /**
     * @var array( string => array( string => ReflectionProperty ) )
     */
    protected $expected;
    
    /**
     * @var array( string => array( string => ezcReflectionProperty ) )
     */
    protected $actual;
    
    public function setUp() {
		$this->refPropName = 'fields';
        $this->publicPropertyName = 'publicProperty';
        $this->undocumentedPropertyName = 'undocumentedProperty';
        $this->instanceOfSomeClass = new SomeClass();
        $this->setUpFixtures();
    }

    public function setUpFixtures() {
		$this->refProp = new ezcReflectionProperty( 'SomeClass', $this->refPropName );
        $this->publicProperty = new ezcReflectionProperty( 'SomeClass', $this->publicPropertyName );
        $this->actual['SomeClass']['undocumentedProperty'] = new ezcReflectionProperty( 'SomeClass', $this->undocumentedPropertyName );
    }

    public function tearDown() {
        unset($this->refProp);
    }

    public function testGetType() {
        $type = $this->refProp->getType();
        self::assertType('ezcReflectionArrayType', $type);
        self::assertEquals('integer[]', $type->getTypeName());
        
        self::assertNull( $this->actual['SomeClass']['undocumentedProperty']->getType() );
    }

    public function testGetDeclaringClass() {
        $class = $this->refProp->getDeclaringClass();
        self::assertType('ezcReflectionClass', $class);
        self::assertEquals('SomeClass', $class->getName());
    }

    public function testHasAnnotation() {
        self::assertTrue($this->refProp->hasAnnotation('var'));
        self::assertFalse($this->refProp->hasAnnotation('nonExistingAnnotation'));
    }

    public function testGetAnnotations() {
        $expectedAnnotations = array('var');

        $annotations = $this->refProp->getAnnotations();
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);

        $annotations = $this->refProp->getAnnotations('var');
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);
    }

	public function testGetName() {
		self::assertEquals('fields', $this->refProp->getName());
	}

    public function testIsPublic() {
		self::assertFalse($this->refProp->isPublic());
	}

	public function testIsPrivate() {
		self::assertTrue($this->refProp->isPrivate());
	}

	public function testIsProtected() {
		self::assertFalse($this->refProp->isProtected());
	}

	public function testIsStatic() {
		self::assertFalse($this->refProp->isStatic());
	}

	public function testIsDefault() {
		self::assertTrue($this->refProp->isDefault());
	}

	public function testGetModifiers() {
		self::assertEquals(1024, $this->refProp->getModifiers());
	}

	public function testGetValue() {
		$o = $this->instanceOfSomeClass;
        $value = new SomeClass();
		self::assertEquals(null, $this->publicProperty->getValue($o));
        $propertyName = $this->publicPropertyName;
	    $o->$propertyName = $value;
		self::assertSame($value, $this->publicProperty->getValue($o));
    }

	/**
     * @expectedException ReflectionException
     */
	public function testGetValueOfPrivatePropertyThrowsException() {
		$this->refProp->getValue($this->instanceOfSomeClass);
	}

	public function testSetValue() {
		$o = $this->instanceOfSomeClass;
        $value = $this->instanceOfSomeClass;
        $propertyName = $this->publicPropertyName;
		self::assertEquals(null, $o->$propertyName);
		$this->publicProperty->setValue($o, $value);
		self::assertSame($value, $o->$propertyName);
	}

	/**
     * @expectedException ReflectionException
     */
	public function testSetValueOfPrivatePropertyThrowsException() {
		$this->refProp->setValue($this->instanceOfSomeClass, 3);
	}

	public function testGetDocComment() {
		self::assertEquals("/**
     * @var int[] An array of integers
     */", $this->refProp->getDocComment($this->instanceOfSomeClass));
	}

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionPropertyTest" );
    }
}
