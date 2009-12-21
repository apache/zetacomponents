<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionMethodTest extends ezcReflectionFunctionTest
{
	public function setUp() {
        // comparison objects for expected values
        $this->php_fctM1 = new ReflectionMethod( 'TestMethods', 'm1' );
        $this->php_fctM2 = new ReflectionMethod( 'TestMethods', 'm2' );
        $this->php_fctM3 = new ReflectionMethod( 'TestMethods', 'm3' );
        $this->php_fctM4 = new ReflectionMethod( 'TestMethods', 'm4' );
        $this->php_fct_method_exists = new ReflectionMethod( 'ReflectionClass', 'hasMethod' );

        $this->setUpFixtures();
    }

    protected function setUpFixtures() {
        $this->fctM1 = new ezcReflectionMethod( 'TestMethods', 'm1' );
        $this->fctM2 = new ezcReflectionMethod( 'TestMethods', 'm2' );
        $this->fctM3 = new ezcReflectionMethod( 'TestMethods', 'm3' );
        $this->fctM4 = new ezcReflectionMethod( 'TestMethods', 'm4' );
        $this->fct_method_exists = new ezcReflectionMethod( 'ReflectionClass', 'hasMethod' );
        $this->ezc_TestMethods2_m1 = new ezcReflectionMethod( 'TestMethods2', 'm1' );
        $this->ezc_TestMethods2_m2 = new ezcReflectionMethod( 'TestMethods2', 'm2' );
        $this->ezc_TestMethods2_m3 = new ezcReflectionMethod( 'TestMethods2', 'm3' );
        $this->ezc_TestMethods2_m4 = new ezcReflectionMethod( 'TestMethods2', 'm4' );
        $this->ezc_TestMethods2_newMethod = new ezcReflectionMethod( 'TestMethods2', 'newMethod' );
        $this->ezc_ReflectionMethod_isInternal = new ezcReflectionMethod('ReflectionMethod', 'isInternal');
        $this->ezc_ezcReflectionMethod_isInternal = new ezcReflectionMethod('ezcReflectionMethod', 'isInternal');
        $this->ezc_ezcReflectionMethod_isInherited = new ezcReflectionMethod('ezcReflectionMethod', 'isInherited');
        $this->ezc_ezcReflectionMethod_getAnnotations = new ezcReflectionMethod('ezcReflectionMethod', 'getAnnotations');
    }

    public function testIsMagic() {
        self::assertFalse($this->fctM1->isMagic());

        $class = $this->fctM1->getDeclaringClass();
        self::assertTrue($class->getConstructor()->isMagic());
    }

    public function testGetAnnotations() {
        $class = new ezcReflectionClass('ezcReflectionClass');
        $method = $class->getMethod('getMethod');
        $annotations = $method->getAnnotations();
        self::assertEquals(3, count($annotations));

        $annotations = $this->fctM4->getAnnotations();
        $expectedAnnotations = array('webmethod', 'restmethod', 'restin', 'restout', 'author', 'param', 'param', 'param', 'return');
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);

        $annotations = $this->fctM4->getAnnotations('param');
        $expectedAnnotations = array('param', 'param', 'param');
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);

        $method = $this->fctM1;
        $annotations = $method->getAnnotations();
        $expectedAnnotations = array('param', 'author');
        ReflectionTestHelper::expectedAnnotations($expectedAnnotations, $annotations, $this);
    }

    public function testGetAnnotationsByName( $fixtureName = 'fctM4' ) {
        parent::testGetAnnotationsByName( $fixtureName );
    }

    public function testHasAnnotation() {
        self::assertTrue($this->fctM4->hasAnnotation('webmethod'));
        self::assertFalse($this->fctM4->hasAnnotation('fooobaaar'));
    }

    public function testGetLongDescription() {
        $desc = $this->fctM3->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public function testGetShortDescription() {
        $desc = $this->fctM3->getShortDescription();

        $expected = "This is the short description";
        self::assertEquals($expected, $desc);
    }

    public function testGetReturnDescription() {
        $desc = $this->fctM4->getReturnDescription();
        self::assertEquals("Hello\nWorld!", $desc);
    }

    public function testGetReturnType() {
        $type = $this->fctM4->getReturnType();
        self::assertType('ezcReflectionType', $type);
        self::assertEquals('string', $type->getTypeName());
    }

    public function testGetParameters() {
        $params = $this->ezc_ezcReflectionMethod_getAnnotations->getParameters();

        $expectedParams = array('name');
        foreach ($params as $param) {
            self::assertType('ezcReflectionParameter', $param);
            self::assertContains($param->getName(), $expectedParams);

            ReflectionTestHelper::deleteFromArray($param->getName(), $expectedParams);
        }
        self::assertEquals(0, count($expectedParams));
    }

    public function testIsInherited() {
        self::assertFalse( $this->ezc_TestMethods2_m2->isInherited() );
        self::assertTrue(  $this->ezc_TestMethods2_m3->isInherited() );
        self::assertFalse( $this->ezc_TestMethods2_newMethod->isInherited() );
        self::assertTrue(  $this->ezc_ReflectionMethod_isInternal->isInherited() ); 
        self::assertFalse( $this->ezc_ezcReflectionMethod_isInternal->isInherited() );
        self::assertFalse( $this->ezc_ezcReflectionMethod_isInherited->isInherited() );
    }

    public function testIsOverriden() {
        self::assertTrue(  $this->ezc_TestMethods2_m2->isOverridden() );
        self::assertFalse( $this->ezc_TestMethods2_newMethod->isOverridden() );
        self::assertFalse( $this->ezc_TestMethods2_m4->isOverridden() );
        self::assertTrue(  $this->ezc_ezcReflectionMethod_isInternal->isOverridden() );
        self::assertFalse( $this->ezc_ReflectionMethod_isInternal->isOverridden() );
    }

    public function testIsIntroduced() {
        self::assertFalse( $this->ezc_TestMethods2_m2->isIntroduced() );
        self::assertTrue(  $this->ezc_TestMethods2_newMethod->isIntroduced() );
        self::assertFalse( $this->ezc_TestMethods2_m4->isIntroduced() );
    }

	public function testIsDisabled() {
    	// is not available for methods
    }

    public function testGetCode() {
        self::assertEquals( "    public function m1() {\n\n    }\n", $this->fctM1->getCode() );
        self::assertEquals( "    public function m2() {\n\n    }\n", $this->fctM2->getCode() );
        self::assertEquals( "    public function m3(\$undocumented) {\n        static \$staticVar;\n    }\n", $this->fctM3->getCode() );
        self::assertEquals( "/* ReflectionClass::hasMethod is an internal function. Therefore the source code is not available. */", $this->fct_method_exists->getCode() );
    }


    // the following methods do not contain additional features
    // they just call the parent method or the reflection source

	public function testGetFileName() {
    	self::assertEquals('methods.php', basename($this->fctM1->getFileName()));
    }

    public function testGetStartLine() {
    	self::assertEquals(16, $this->fctM1->getStartLine());
    }

    public function testGetEndLine() {
    	self::assertEquals(18, $this->fctM1->getEndLine());
    }

	public function testGetDocComment() {
    	self::assertEquals("/**
     * @foo
     * @bar
     * @foobar
     */", $this->fctM2->getDocComment());
    }

    public function testInvoke() {
        self::assertEquals(
            $this->php_fct_method_exists->invoke( new ReflectionClass('ReflectionClass'), 'hasMethod' ),
            $this->fct_method_exists->invoke( new ReflectionClass('ReflectionClass'), 'hasMethod' )
        );
    }

    public function testInvokeArgs() {
        self::assertEquals(
            $this->php_fct_method_exists->invokeArgs( new ReflectionClass('ReflectionClass'), array( 'hasMethod' ) ),
            $this->fct_method_exists->invokeArgs( new ReflectionClass('ReflectionClass'), array( 'hasMethod' ) )
        );
    }

	public function testGetNumberOfParameters() {
    	self::assertEquals(1, $this->fctM3->getNumberOfParameters());
    	self::assertEquals(0, $this->fctM1->getNumberOfParameters());
    }

    public function testGetNumberOfRequiredParameters() {
    	self::assertEquals(0, $this->fctM1->getNumberOfRequiredParameters());
    	self::assertEquals(1, $this->fctM3->getNumberOfRequiredParameters());
    }

    public function testIsFinal() {
    	self::assertFalse($this->fctM1->isFinal());
    	self::assertFalse($this->fctM2->isFinal());
    }

	public function testIsAbstract() {
    	self::assertFalse($this->fctM1->isAbstract());
    	self::assertFalse($this->fctM2->isAbstract());
    }

	public function testIsPublic() {
    	self::assertTrue($this->fctM1->isPublic());
    	self::assertTrue($this->fctM2->isPublic());
    }

	public function testIsPrivate() {
    	self::assertFalse($this->fctM1->isPrivate());
    	self::assertFalse($this->fctM2->isPrivate());
    }

	public function testIsProtected() {
    	self::assertFalse($this->fctM1->isProtected());
    	self::assertFalse($this->fctM2->isProtected());
    }

	public function testIsStatic() {
    	self::assertFalse($this->fctM1->isStatic());
    	self::assertFalse($this->fctM2->isStatic());
    }

	public function testIsConstructor() {
    	self::assertFalse($this->fctM1->isConstructor());
    	self::assertFalse($this->fctM2->isConstructor());
    }

	public function testIsDestructor() {
    	self::assertFalse($this->fctM1->isDestructor());
    	self::assertFalse($this->fctM2->isDestructor());
    }

	public function testGetModifiers() {
    	self::assertEquals(65792, $this->fctM1->getModifiers());
    	self::assertEquals(65792, $this->fctM2->getModifiers());
    }

    public function testExport() {
        self::assertEquals(
            ReflectionMethod::export( 'TestMethods', 'm1', true ),
            ezcReflectionMethod::export( 'TestMethods', 'm1', true )
        );
        self::assertEquals(
            ReflectionMethod::export( 'TestMethods', 'm2', true ),
            ezcReflectionMethod::export( 'TestMethods', 'm2', true )
        );
        self::assertEquals(
            ReflectionMethod::export( 'TestMethods', 'm3', true ),
            ezcReflectionMethod::export( 'TestMethods', 'm3', true )
        );
        self::assertEquals(
            ReflectionMethod::export( 'TestMethods', 'm4', true ),
            ezcReflectionMethod::export( 'TestMethods', 'm4', true )
        );
        self::assertEquals(
            ReflectionMethod::export( new TestMethods(), 'm1', true ),
            ezcReflectionMethod::export( new TestMethods(), 'm1', true )
        );
        self::assertEquals(
            ReflectionMethod::export( new TestMethods(), 'm2', true ),
            ezcReflectionMethod::export( new TestMethods(), 'm2', true )
        );
        self::assertEquals(
            ReflectionMethod::export( new TestMethods(), 'm3', true ),
            ezcReflectionMethod::export( new TestMethods(), 'm3', true )
        );
        self::assertEquals(
            ReflectionMethod::export( new TestMethods(), 'm4', true ),
            ezcReflectionMethod::export( new TestMethods(), 'm4', true )
        );
    }

    public function getGetClasses() {
        return array(
            array( 'fctM1', 'TestMethods' ),
            array( 'fctM2', 'TestMethods' ),
            array( 'fctM3', 'TestMethods' ),
            array( 'fctM4', 'TestMethods' ),
            array( 'fct_method_exists', 'ReflectionClass' ),
            array( 'ezc_TestMethods2_m1', 'TestMethods2' ),
            array( 'ezc_TestMethods2_m2', 'TestMethods2' ),
            array( 'ezc_TestMethods2_m3', 'TestMethods2' ),
            array( 'ezc_TestMethods2_m4', 'TestMethods2' ),
            array( 'ezc_TestMethods2_newMethod', 'TestMethods2' ),
            array( 'ezc_ReflectionMethod_isInternal', 'ReflectionMethod' ),
            array( 'ezc_ezcReflectionMethod_isInternal', 'ezcReflectionMethod' ),
            array( 'ezc_ezcReflectionMethod_isInherited', 'ezcReflectionMethod' ),
            array( 'ezc_ezcReflectionMethod_getAnnotations', 'ezcReflectionMethod' ),
        );
    }

    /**
     * @dataProvider getGetClasses
     */
    public function testGetClass( $method, $expectedClassName ) {
        self::assertEquals( $expectedClassName, $this->$method->getCurrentClass()->getName() );
    }

    public function getGetDeclaringClasses() {
        return array(
            array( 'fctM1', 'TestMethods' ),
            array( 'fctM2', 'TestMethods' ),
            array( 'fctM3', 'TestMethods' ),
            array( 'fctM4', 'TestMethods' ),
            array( 'fct_method_exists', 'ReflectionClass' ),
            array( 'ezc_TestMethods2_m1', 'TestMethods' ),
            array( 'ezc_TestMethods2_m2', 'TestMethods2' ),
            array( 'ezc_TestMethods2_m3', 'TestMethods' ),
            array( 'ezc_TestMethods2_m4', 'TestMethods' ),
            array( 'ezc_TestMethods2_newMethod', 'TestMethods2' ),
            array( 'ezc_ReflectionMethod_isInternal', 'ReflectionFunctionAbstract' ),
            array( 'ezc_ezcReflectionMethod_isInternal', 'ezcReflectionMethod' ),
            array( 'ezc_ezcReflectionMethod_isInherited', 'ezcReflectionMethod' ),
            array( 'ezc_ezcReflectionMethod_getAnnotations', 'ezcReflectionMethod' ),
        );
    }

    /**
     * @dataProvider getGetDeclaringClasses
     */
    public function testGetDeclaringClass( $method, $expectedDeclaringClassName ) {
        $declaringClass = $this->$method->getDeclaringClass();
        self::assertType( 'ezcReflectionClass', $declaringClass );
        self::assertEquals( $expectedDeclaringClassName, $declaringClass->getName() );
    }

    public function getWrapperMethods() {
        $wrapperMethodsParent = parent::getWrapperMethods();
        $wrapperMethods = array(
            array( 'isFinal', array() ),
            array( 'isAbstract', array() ),
            array( 'isPublic', array() ),
            array( 'isPrivate', array() ),
            array( 'isProtected', array() ),
            array( 'isStatic', array() ),
            array( 'isConstructor', array() ),
            array( 'isDestructor', array() ),
            array( 'getModifiers', array() ),
            array( 'getPrototype', array() ),
        );
        return array_merge( $wrapperMethodsParent, $wrapperMethods );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionMethodTest" );
    }
}
?>
