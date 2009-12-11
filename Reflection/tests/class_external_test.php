<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionClassExternalTest extends ezcReflectionClassTest
{
    public function setUpFixtures()
    {
        $this->class                   = new ezcReflectionClass( new MyReflectionClass( 'SomeClass' ) );
        $this->classTestWebservice     = new ezcReflectionClass( new MyReflectionClass( 'TestWebservice' ) );
        $this->classReflectionFunction = new ezcReflectionClass( new MyReflectionClass( 'ReflectionFunction' ) );
    }

	public function testCall() {
		self::assertTrue($this->class->doSomeMetaProgramming());
	}

	public function testGetMethod() {
		parent::testGetMethod();

		$m = $this->class->getMethod('helloWorld');
		self::assertTrue($m->change());
	}

	public function testGetProperty() {
		parent::testGetProperty();

		$prop = $this->class->getProperty('fields');
		self::assertTrue($prop->change());
	}

	public function testGetProperties() {
		parent::testGetProperties();

		$props = $this->class->getProperties();
		self::assertTrue($props[0]->change());
	}

	public function testGetConstructor() {
		parent::testGetConstructor();

		$ctr = $this->class->getConstructor();
		self::assertTrue($ctr->change());
	}

	public function testGetMethods() {
		parent::testGetMethods();

		$ms = $this->class->getMethods();
		self::assertTrue($ms[0]->change());
	}

	public function testGetInterfaces() {
		parent::testGetInterfaces();

		$is = $this->class->getInterfaces();
		self::assertTrue($is[0]->change());
	}

	public function testGetParentClass() {
		parent::testGetParentClass();

		$parent = $this->class->getParentClass();
		self::assertTrue($parent->change());
	}

	public function testGetExtension() {
		parent::testGetExtension();

		self::assertNull($this->class->getExtension());
		$c = new ezcReflectionClass( new MyReflectionClass( 'ReflectionClass' ) );
		$ext = $c->getExtension();
		self::assertTrue($ext->change());
	}

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionClassExternalTest" );
    }
}
?>
