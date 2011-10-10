<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionClassTest extends ezcTestCase
{
    /**#@+
     * @var ezcReflectionClass
     * @deprecated
     */
    protected $class;
    protected $classTestWebservice;
    protected $classReflectionFunction;
    /**#@-*/

	public function setUp() {
        // comparison objects for expected values
        $this->expected = array(
            'SomeClass'
                => new ReflectionClass( 'SomeClass' ),
            'TestWebservice'
                => new ReflectionClass( 'TestWebservice' ),
            'ReflectionFunction'
                => new ReflectionClass( 'ReflectionFunction' ),
        );
        $this->setUpFixtures();
        $this->actual = array(
            'SomeClass'
                => $this->class,
            'TestWebservice'
                => $this->classTestWebservice,
            'ReflectionFunction'
                => $this->classReflectionFunction,
        );
    }

    public function setUpFixtures() {
        $this->class                   = new ezcReflectionClass( 'SomeClass' );
        $this->classTestWebservice     = new ezcReflectionClass( 'TestWebservice' );
        $this->classReflectionFunction = new ezcReflectionClass( 'ReflectionFunction' );
    }

    public function tearDown() {
        unset($this->class);
    }

    /**
     * @expectedException ezcReflectionCallToUndefinedMethodException
     */
    public function testCall() {
        $this->class->undefinedMethod();
    }

    public function testGetName() {
        self::assertEquals('SomeClass', $this->class->getName());
    }

    public function testGetMethod() {
        $method = $this->class->getMethod('helloWorld');
        self::assertInstanceOf('ezcReflectionMethod', $method);
        self::assertEquals('helloWorld', $method->getName());
    }

    public function testGetConstructor() {
        $method = $this->class->getConstructor();
        self::assertInstanceOf('ezcReflectionMethod', $method);
        self::assertEquals('__construct', $method->getName());
        self::assertEquals('SomeClass', $method->getDeclaringClass()->getName());
        
        $method = $this->classReflectionFunction->getConstructor();
        self::assertInstanceOf('ezcReflectionMethod', $method);
        self::assertEquals('__construct', $method->getName());
        self::assertEquals('ReflectionFunction', $method->getDeclaringClass()->getName());
    }

    public function testGetConstructorReturnsNull() {
        self::assertNull( $this->classTestWebservice->getConstructor() );
    }

	public function testGetInterfaces() {
        $ifaces = $this->class->getInterfaces();

        self::assertInstanceOf('ezcReflectionClass', $ifaces[0]);
        self::assertEquals('IInterface', $ifaces[0]->getName());
        self::assertEquals(1, count($ifaces));
    }

    public function testGetMethods() {
        $methods = $this->classTestWebservice->getMethods();
        self::assertEquals(0, count($methods));

        $methods = $this->class->getMethods();

        $expectedMethods = array('__construct', 'helloWorld', 'doSomeMetaProgramming');
        self::assertEquals(count($expectedMethods), count($methods));
        foreach ($methods as $method) {
            self::assertInstanceOf('ezcReflectionMethod', $method);
            self::assertContains($method->getName(), $expectedMethods);

            ReflectionTestHelper::deleteFromArray($method->getName(), $expectedMethods);
        }
        self::assertEquals(0, count($expectedMethods));
    }

    public function testGetParentClass() {
        $parent = $this->class->getParentClass();

        self::assertInstanceOf('ezcReflectionClass', $parent);
        self::assertEquals('BaseClass', $parent->getName());
    }

    public function testGetParentClassFalse() {
        self::assertFalse( $this->classTestWebservice->getParentClass() );
    }

    public function testGetProperty() {
        $prop = $this->class->getProperty('fields');

        self::assertInstanceOf('ezcReflectionProperty', $prop);
        self::assertEquals('fields', $prop->getName());

        try {
            $prop = $this->class->getProperty('none-existing-property');
        }
        catch (ReflectionException $expected) {
            return;
        }
        $this->fail('ReflectionException has not been raised on none existing property.');
    }

    public function testGetProperties() {
        $properties = $this->classTestWebservice->getProperties();

        $expected = array('prop1', 'prop2', 'prop3');

        foreach ($properties as $prop) {
            self::assertInstanceOf('ezcReflectionProperty', $prop);
            self::assertContains($prop->getName(), $expected);

            ReflectionTestHelper::deleteFromArray($prop->getName(), $expected);
        }
        self::assertEquals(0, count($expected));
    }

    public function testGetShortDescription() {
        $desc = $this->classTestWebservice->getShortDescription();

        self::assertEquals('This is the short description', $desc);
    }

    public function testGetLongDescription() {
        $desc = $this->classTestWebservice->getLongDescription();

        $expected = <<<ENDDATA
This is the long description with may be additional infos and much more lines
of text.

Empty lines are valid, too.

foo bar

Licensed to the Apache Software Foundation (ASF) under one
or more contributor license agreements.  See the NOTICE file
distributed with this work for additional information
regarding copyright ownership.  The ASF licenses this file
to you under the Apache License, Version 2.0 (the
"License"); you may not use this file except in compliance
with the License.  You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing,
software distributed under the License is distributed on an
"AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, either express or implied.  See the License for the
specific language governing permissions and limitations
under the License.
ENDDATA;

        self::assertEquals($expected, $desc);
    }

    public function testHasAnnotation() {
        self::assertFalse($this->class->hasAnnotation('foobar'));

        self::assertTrue($this->classTestWebservice->hasAnnotation('foobar'));
    }

    public function testGetAnnotations() {
        $annotations = $this->class->getAnnotations();

        $expectedAnnotations = array('licence', 'donotdocument', 'testclass', 'ignore');
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);

        $expectedAnnotations = array('webservice', 'foobar');
        $annotations = $this->classTestWebservice->getAnnotations();
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);
    }

    public function testGetAnnotationsByName() {
        $annotations = $this->class->getAnnotations( 'licence' );
        self::assertTrue( is_array( $annotations ) );
        self::assertEquals( 1, count( $annotations ) );
        foreach ( $annotations as $annotation ) {
            $this->assertInstanceOf( 'ezcReflectionAnnotation', $annotation );
            $this->assertContains( $annotation->getName(), 'licence' );
        }
    }

    public function testGetExtension() {
        $ext = $this->classReflectionFunction->getExtension();
        self::assertInstanceOf('ezcReflectionExtension', $ext);
        self::assertEquals('Reflection', $ext->getName());

        $ext = $this->class->getExtension();
        self::assertNull($ext);
    }

    public function testGetExtensionName() {
        self::assertEquals( 'Reflection', $this->classReflectionFunction->getExtensionName() );
        self::assertEquals( '', $this->class->getExtensionName() );
    }
    
    public function testGetConstant() {
    	self::assertEquals( 'ConstantValue', $this->actual['SomeClass']->getConstant( 'CLASS_CONSTANT' ) );
    	self::assertEquals( '', $this->actual['SomeClass']->getConstant( 'NON_EXISTING_CLASS_CONSTANT' ) );
    }
    
    public function testSetStaticPropertyValue() {
        $oldValue = $this->expected['SomeClass']->getStaticPropertyValue( 'staticProperty' );
        $newValue = 'aNewValue';
    	$this->actual['SomeClass']->setStaticPropertyValue( 'staticProperty', $newValue );
    	self::assertEquals( $newValue, $this->expected['SomeClass']->getStaticPropertyValue( 'staticProperty' ) );
    	$this->expected['SomeClass']->setStaticPropertyValue( 'staticProperty', $oldValue );
    }

    public function testExport() {
        self::assertEquals( ReflectionClass::export('TestWebservice', true), ezcReflectionClass::export('TestWebservice', true) );
    }

    public function getWrapperMethods() {
        $wrapperMethods = array(
            array( '__toString', array() ),
            array( 'getName', array() ),
            array( 'isInternal', array() ),
            array( 'isUserDefined', array() ),
            array( 'getFileName', array() ),
            array( 'getStartLine', array() ),
            array( 'getEndLine', array() ),
            array( 'getDocComment', array() ),
            array( 'getExtension', array() ),
            array( 'getExtensionName', array() ),
            array( 'getConstants', array() ),
            array( 'getDefaultProperties', array() ),
            array( 'getInterfaceNames', array() ),
            array( 'getModifiers', array() ),
            array( 'getStaticProperties', array() ),
            array( 'isAbstract', array() ),
            array( 'isFinal', array() ),
            array( 'isInstantiable', array() ),
            array( 'isIterateable', array() ),
            array( 'isInterface', array() ),
        );
        if ( version_compare( PHP_VERSION, '5.3.0' ) === 1 ) {
            $wrapperMethods530 = array(
                array( 'getNamespaceName', array() ),
                array( 'inNamespace', array() ),
                array( 'getShortName', array() ),
            );
        } else {
            $wrapperMethods530 = array();
        }
        return array_merge( $wrapperMethods, $wrapperMethods530 );
    }

    /**
     * @dataProvider getWrapperMethods
     */
    public function testWrapperMethods( $method, $arguments )
    {
        foreach ( array_keys( $this->expected ) as $fixtureName )
        {
            $actual = call_user_func_array(
                array( $this->actual[ $fixtureName ], $method ), $arguments
            );
            $expected = call_user_func_array(
                array( $this->expected[ $fixtureName ], $method ), $arguments
            );
            if ( $expected instanceOf Reflector )
            {
                self::assertEquals( (string) $expected, (string) $actual );
            }
            else
            {
                self::assertEquals( $expected, $actual );
            }
        }
    }

    /**
     * @return array[]
     */
    public function getWrapperMethodsWithParameters()
    {
        return array(
            array(
                'SomeClass',
                'getStaticPropertyValue',
                array( 'staticProperty' )
            ),
            array(
                'SomeClass',
                'hasConstant',
                array( 'CLASS_CONSTANT' )
            ),
            array(
                'SomeClass',
                'hasConstant',
                array( 'NONEXISTING_CONSTANT' )
            ),
            array(
                'SomeClass',
                'hasProperty',
                array( 'staticProperty' )
            ),
            array(
                'SomeClass',
                'hasProperty',
                array( 'nonexistingProperty' )
            ),
            array(
                'SomeClass',
                'hasMethod',
                array( 'helloWorld' )
            ),
            array(
                'SomeClass',
                'hasMethod',
                array( 'nonexistingMethod' )
            ),
            array(
                'ReflectionFunction',
                'isSubclassOf',
                array( 'ReflectionFunctionAbstract' )
            ),
            array(
                'ReflectionFunction',
                'isSubclassOf',
                array( 'ReflectionMethod' )
            ),
            array(
                'ReflectionFunction',
                'implementsInterface',
                array( 'Reflector' )
            ),
            array(
                'ReflectionFunction',
                'implementsInterface',
                array( 'ezcReflectionType' )
            ),
            array(
                'TestWebservice',
                'isInstance',
                array( new TestWebservice )
            ),
            array(
                'ReflectionFunction',
                'newInstance',
                array( 'get_declared_interfaces' )
            ),
            array(
                'ReflectionFunction',
                'newInstanceArgs',
                array( array( 'get_declared_interfaces' ) )
            ),
            array(
                'SomeClass',
                'newInstanceArgs',
                array( array() )
            ),
            array(
                'SomeClass',
                'setStaticPropertyValue',
                array( 'staticProperty', 'newValue' )
            ),
            array(
                'SomeClass',
                'getStaticPropertyValue',
                array( 'staticProperty' )
            ),
        );
    }
    
    /**
     * @dataProvider getWrapperMethodsWithParameters
     */
    public function testWrapperMethodsWithParameters( $fixtureName, $method, $arguments )
    {
        $actual = call_user_func_array(
            array( $this->actual[ $fixtureName ], $method ), $arguments
        );
        $expected = call_user_func_array(
            array( $this->expected[ $fixtureName ], $method ), $arguments
        );
        if ( $expected instanceOf Reflector )
        {
            self::assertEquals( (string) $expected, (string) $actual );
        }
        else
        {
            self::assertEquals( $expected, $actual );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionClassTest" );
    }
}
?>
