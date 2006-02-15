<?php
/**
 * Provides generation of mock classes and objects from existing classes.
 *
 * The mocked class will contain all the methods of the original class but with
 * a different implementation which will call the current ezcMockInvocationMocker
 * object, this objects takes care of checking expectations and stubs.
 * It is also possible to define which methods are mocked by passing an array
 * of method names.
 *
 * The simplest way to define a mock object is to do:
 * <code>
 * ezcMock::generate( "MyClass" );
 * $o = new Mock_MyClass();
 * </code>
 *
 * The generate() method returns an object which can be queried.
 * <code>
 * $m = ezcMock::generate( "MyClass" );
 * $o = new $m->mockClassName;
 * echo "original class was: ", $m->className;
 * </code>
 */
class ezcMock
{
    public $mockClassName;
    public $className;
    public $methods;

    /**
     * Convenience function for generating the mock class and return the
     * mock definition object.
     *
     * @param string $className The name of an existing class, the mocked name
     *                          is generated from this.
     * @param array(string) $methods Array of string defining which methods to
     *                               mock, if set to false all methods will be
     *                               mocked.
     * @return ezcMock
     */
    public static function generate( $className, $methods = false, $mockClassName = false )
    {
        $mock = new ezcMock( $className, $methods, $mockClassName );
        if ( !class_exists( $mock->mockClassName, false ) )
            $mock->generateClass();
        return $mock;
    }

    /**
     * Initialise with original class name and optional array of methods to mock.
     *
     * @param string $className The name of an existing class, the mocked name
     *                          is generated from this.
     * @param array(string) $methods Array of string defining which methods to
     *                               mock, if set to false all methods will be
     *                               mocked.
     */
    public function __construct( $className, $methods = false, $mockClassName = false )
    {
        $this->mockClassName = $mockClassName;
        if ( $this->mockClassName === false )
            $this->mockClassName = 'Mock_' . $className;
        $this->className = $className;
        $this->methods  = $methods;
    }

    /**
     * Generates the mock class definition in a string and evaluates it to define the class.
     *
     * @throw Exception If the class already exists or is a finalized class.
     */
    protected function generateClass()
    {
        if ( class_exists( $this->mockClassName, false ) )
            throw new Exception( "Mock class <{$this->mockClassName}> already exists, cannot generate" );

        try
        {
            $class = new ReflectionClass( $this->className );

            if ( $class->isFinal() )
                throw new Exception( "Class <{$this->className}> is a finalized class, cannot make mock version of it" );

            $code = $this->generateClassDefinition( $class );

            eval( $code );
        }
        catch ( Exception $e )
        {
            throw new Exception( "Failed to generate mock class <{$this->mockClassName}> for class <{$this->className}>, caught an exception:\n" .
                                 $e->getMessage() );
        }
    }

    /**
     * Creates the class definition in a string and returns it.
     *
     * @param ReflectionClass $class The original class to mock.
     * @return string
     */
    protected function generateClassDefinition( $class )
    {
        if ( $class->isInterface() )
            $code = "interface ";
        else
            $code = "class ";

        if ( $class->isAbstract() )
            $code .= "abstract ";

        $code .= "{$this->mockClassName} extends {$this->className} implements ezcMockObject\n" .
            "{\n";
        $code .= $this->generateMockApi( $class );

        foreach( $class->getMethods() as $method )
        {
            if ( !$this->canMockMethod( $method ) )
                continue;
            if ( !$this->shouldMockMethod( $method ) )
                continue;
            $code .= $this->generateMethodDefinition( $class, $method );
        }

        $code .= "}\n";

        return $code;
    }

    /**
     * Returns true if it is possible to mock the method. Reasons for
     * not being able to mock it is if it is a constructor/desctructor or begins
     * with __ which are special PHP methods.
     *
     * @param ReflectionMethod $method Method from original class.
     * @return bool
     */
    protected function canMockMethod( $method )
    {
        // constructors and destructors already have a special definition
        if ( $method->isConstructor() ||
             $method->isDestructor() )
            return false;

        // This is an internal mock function or PHP special functions, do not touch
        if ( substr( $method->getName(), 0, 2 ) == "__" )
            return false;

        return true;
    }

    /**
     * Returns true if the method should be mocked. A method should be mocked
     * if it is part of the method mock list ($methods) or all methods should
     * be mocked.
     *
     * @param ReflectionMethod $method Method from original class.
     * @return bool
     * @note The method must first be checked if it can be mocked by using
     *       canMockMethod().
     */
    protected function shouldMockMethod( $method )
    {
        // no methods define so want to override all of them
        if ( $this->methods === false )
            return true;

        return in_array( $method->getName(), $this->methods );
    }

    /**
     * Generates the method definition as a string and returns it. The method
     * will have code which calls the invoke() method of the invocation mocker.
     *
     * @param ReflectionClass $class The original class to mock.
     * @param ReflectionMethod $method Method from original class.
     * @return string
     */
    protected function generateMethodDefinition( $class, $method )
    {
        $code = "    ";
        if ( $method->isPrivate() )
            $code .= "private ";
        else if ( $method->isProtected() )
            $code .= "protected ";
        else
            $code .= "public ";

        if ( $method->isAbstract() )
            $code .= "abstract ";

        if ( $method->isStatic() )
            $code .= "static ";

        $code .= "function ";

        if ( $method->returnsReference() )
            $code .= "&";

        $code .= $method->getName() . "( " . $this->generateMethodParameters( $method ) . " )\n" .
                 "    {\n" .
                 "        \$args = func_get_args();\n" .
                 "        return \$this->invocationMocker->invoke( new ezcMockInvocation( \$this, " . var_export( $class->getName(), true ) . ", " . var_export( $method->getName(), true ) . ", \$args ) );\n" .
                 "    }\n\n";

        return $code;
    }

    /**
     * Generates the basic API for the mock class as a string and returns it.
     * The API contains the constructor, descructor, clone method and implements
     * the ezcMockObject interface.
     *
     * @param ReflectionMethod $method Method from original class.
     * @return string
     */
    protected function generateMockApi( $class )
    {
        $constructor = $class->getConstructor();

        if ( !$constructor )
            return '';

        return "    private \$invocationMocker;\n" .
               "\n" .
               "    public function __construct( " . $this->generateMethodParameters( $constructor ) . " )\n" .
               "    {\n" .
               "        \$this->invocationMocker = new ezcMockInvocationMocker( \$this );\n" .
               "        parent::" . $constructor->getName() . "( " . $this->generateMethodParameters( $constructor, true ) . " );\n" .
               "    }\n" .
               "\n" .
               "    public function __destruct()\n" .
               "    {\n" .
               "        //\$this->invocationMocker->verify();\n" .
               "    }\n" .
               "\n" .
               "    public function __clone()\n" .
               "    {\n" .
               "        \$this->invocationMocker = clone \$this->invocationMocker;\n" .
               "        parent::__clone();\n" .
               "    }\n" .
               "\n" .
               "    public function getInvocationMocker()\n" .
               "    {\n" .
               "        return \$this->invocationMocker;\n" .
               "    }\n" .
               "\n" .
               "    public function expects( ezcMockInvocationMatcher \$matcher )\n" .
               "    {\n" .
               "        return \$this->invocationMocker->expects( \$matcher );\n" .
               "    }\n" .
               "\n" .
               "    public function verify()\n" .
               "    {\n" .
               "        return \$this->invocationMocker->verify();\n" .
               "    }\n";
    }

    /**
     * Generates the definition for the parameters of the method as a string
     * and returns it. If $asCall is true it will not generate a definition
     * but a call which contains only the parameter values and their definition.
     *
     * @param ReflectionMethod $method Method from original class.
     * @param bool $asCall Controls whether to make a definition or call string.
     * @return string
     */
    protected function generateMethodParameters( $method, $asCall = false )
    {
        $list = array();
        foreach( $method->getParameters() as $parameter )
        {
            $name = '$' . $parameter->getName();

            if ( $asCall )
            {
                $list[] = $name;
            }
            else
            {
                $typeHint = "";
                if ( $parameter->isArray() )
                {
                    $typeHint = "Array ";
                }
                else
                {
                    $class = $parameter->getClass();
                    if ( $class )
                        $typeHint = $class->getName() . " ";
                }

                $default = "";
                if ( $parameter->isDefaultValueAvailable() )
                {
                    $value = $parameter->getDefaultValue();
                    $default = " = " . var_export( $value, true );
                }

                $ref = "";
                if ( $parameter->isPassedByReference() )
                    $ref = "&";

                $list[] = $typeHint . $ref . $name . $default;
            }
        }
        return join( ", ", $list );
    }
}
?>
