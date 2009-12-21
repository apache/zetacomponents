<?php
/**
 * File containing the ezcReflectionObject class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionObject class to provide type information
 * using PHPDoc annotations.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionObject extends ReflectionObject
{
    /**
     * @var ezcReflectionDocCommentParser Parser for source code annotations
     */
    protected $docParser;

    /**
     * @var object|ReflectionObject
     *      Instance or ReflectionObject of the object to be reflected
     */
    protected $reflectionSource;

    /**
     * Constructs a new ezcReflectionObject.
     *
     * @param object|ReflectionObject $argument
     *        Instance or ReflectionObject of the object to be reflected
     */
    public function __construct( $argument )
    {
        if ( !$argument instanceof parent )
        {
            parent::__construct( $argument );
        }
        $this->reflectionSource = $argument;
        // TODO: Parse comment on demand to save CPU time and memory
        $this->docParser = ezcReflectionApi::getDocCommentParserInstance();
        $this->docParser->parse( $this->getDocComment() );
    }

    /**
     * Use overloading to call additional methods
     * of the ReflectionObject instance given to the constructor.
     *
     * @param string $method Method to be called
     * @param array  $arguments Arguments that were passed
     * @return mixed
     */
    public function __call( $method, $arguments )
    {
        $callback = array( $this->reflectionSource, $method );  
        if ( $this->reflectionSource instanceof parent
             and is_callable( $callback ) )
        {
            // query external reflection object
            return call_user_func_array( $callback, $arguments );
        }
        else
        {
            throw new ezcReflectionCallToUndefinedMethodException( __CLASS__, $method );
        }
    }

    /**
     * Forwards a method invocation to either the reflection source passed to
     * the constructor of this class when creating an instance or to the parent
     * class.
     *
     * This method is part of the dependency injection mechanism and serves as
     * a helper for implementing wrapper methods without code duplication.
     * @param string $method Name of the method to be invoked
     * @param mixed[] $arguments Arguments to be passed to the method
     * @return mixed Return value of the invoked method
     */
    protected function forwardCallToReflectionSource( $method, $arguments = array() ) {
        if ( $this->reflectionSource instanceof parent ) {
            return call_user_func_array( array( $this->reflectionSource, $method ), $arguments );
        } else {
            //return call_user_func_array( array( parent, $method ), $arguments );
            $argumentStrings = array();
            foreach ( array_keys( $arguments ) as $key ) {
                $argumentStrings[] = '$arguments[' . var_export( $key, true ) . ']';
            }
            $cmd = 'return parent::$method( ' . implode( ', ', $argumentStrings ) . ' );';
            return eval( $cmd );
        }
    }

    /**
     * Returns an ezcReflectionMethod object of the method specified by $name.
     *
     * @param string $name Name of the method
     * @return ezcReflectionMethod
     * @throws ReflectionException if method doesn't exist
     */
    public function getMethod( $name ) {
        $method = $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
        if ( $this->reflectionSource instanceof parent ) {
            return new ezcReflectionMethod( $this, $method );
        } else {
            return new ezcReflectionMethod( $this, $method->name );
        }
    }

    /**
     * Returns an ezcReflectionMethod object of the constructor method.
     *
     * @return ezcReflectionMethod
     */
    public function getConstructor() {
        $constructor = $this->forwardCallToReflectionSource( __FUNCTION__ );
        if ($constructor != null) {
            if ( $this->reflectionSource instanceof parent ) {
                return new ezcReflectionMethod( $this, $constructor );
            } else {
                return new ezcReflectionMethod( $this, $constructor->name );
            }
        } else {
            return null;
        }
    }

    /**
     * Returns the methods as an array of ezcReflectionMethod objects.
     *
     * @param integer $filter
     *        A combination of
     *        ReflectionMethod::IS_STATIC,
     *        ReflectionMethod::IS_PUBLIC,
     *        ReflectionMethod::IS_PROTECTED,
     *        ReflectionMethod::IS_PRIVATE,
     *        ReflectionMethod::IS_ABSTRACT and
     *        ReflectionMethod::IS_FINAL
     * @return ezcReflectionMethod[]
     */
    public function getMethods( $filter = -1 ) {
        $methods = $this->forwardCallToReflectionSource( __FUNCTION__, array( $filter ) );
        $extMethods = array();
        foreach ( $methods as $method ) {
            if ( $this->reflectionSource instanceof parent ) {
                $extMethods[] = new ezcReflectionMethod( $this, $method );
            } else {
                $extMethods[] = new ezcReflectionMethod( $this, $method->name );
            }
        }
        return $extMethods;
    }

    /**
     * Returns an array of all interfaces implemented by the class.
     *
     * @return ezcReflectionClass[]
     */
    public function getInterfaces() {
        $ifaces = $this->forwardCallToReflectionSource( __FUNCTION__ );
    	$result = array();
    	foreach ($ifaces as $i) {
    		$result[] = new ezcReflectionClass($i);
    	}
    	return $result;
    }

    /**
     * Returns the class' parent class, or, if none exists, FALSE
     *
     * @return ezcReflectionClass|boolean
     */
    public function getParentClass()
    {
        $parentClass = $this->forwardCallToReflectionSource( __FUNCTION__ );
        if ( is_object( $parentClass ) ) {
            return new ezcReflectionClass( $parentClass );
        }
        else {
            return false;
        }
    }

    /**
     * Returns the class' property specified by its name
     *
     * @param string $name Name of the property
     * @return ezcReflectionProperty
     * @throws RelectionException if property doesn't exist
     */
    public function getProperty($name) {
        $prop = $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
		if (is_object($prop) && !($prop instanceof ezcReflectionProperty)) {
			return new ezcReflectionProperty($prop, $name);
        } else {
			// TODO: may be we should throw an exception here
            return $prop;
        }
    }

    /**
     * Returns an array of this class' properties
     *
     * @param integer $filter
     *        A combination of
     *        ReflectionProperty::IS_STATIC,
     *        ReflectionProperty::IS_PUBLIC,
     *        ReflectionProperty::IS_PROTECTED and
     *        ReflectionProperty::IS_PRIVATE
     * @return ezcReflectionProperty[] Properties of the class
     */
    public function getProperties($filter = -1) {
        $props = $this->forwardCallToReflectionSource( __FUNCTION__, array( $filter ) );
        $extProps = array();
        foreach ($props as $prop) {
            $extProps[] = new ezcReflectionProperty( $prop );
        }
        return $extProps;
    }

    /**
     * Returns the short description of the class from the source code
     * documentation
     *
     * @return string short description of the class
     * @since PHP 5.1.0
     */
    public function getShortDescription() {
        return $this->docParser->getShortDescription();
    }

    /**
     * Returns the long description of the class from the source code
     * documentation
     *
     * @return string Long description of the class
     * @since PHP 5.1.0
     */
    public function getLongDescription() {
        return $this->docParser->getLongDescription();
    }

    /**
     * Checks whether the class is annotated with the annotation $annotation
     *
     * @param string $annotation Name of the annotation
     * @return boolean
     * @since PHP 5.1.0
     */
    public function hasAnnotation($annotation) {
        return $this->docParser->hasAnnotation($annotation);
    }

    /**
     * Returns an array of annotations (optinally only annotations of a given name)
     *
     * @param string $name Name of the annotations
     * @return ezcReflectionAnnotation[] Annotations
     * @since PHP 5.1.0
     */
    public function getAnnotations( $name = '' ) {
        if ( $name == '' ) {
            return $this->docParser->getAnnotations();
        }
        else {
            return $this->docParser->getAnnotationsByName($name);
        }
    }

    /**
     * Returns NULL or the extension the class belongs to
     *
     * @return ezcReflectionExtension
     */
    public function getExtension() {
        $ext = $this->forwardCallToReflectionSource( __FUNCTION__ );
        if ($ext) {
            return new ezcReflectionExtension($ext);
        } else {
            return null;
        }
    }


    // only pure wrapper methods follow bellow this line

    /**
     * Returns FALSE or the name of the extension the class belongs to
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string|boolean Extension name or FALSE
     */
    public function getExtensionName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the name of the class.
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string Class name
     */
    public function getName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the doc comment for the class.
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string Doc comment
     * @since PHP 5.1.0
     */
    public function getDocComment() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the class' constant specified by its name
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the constant
     * @return mixed
     */
    public function getConstant( $name ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
    }

    /**
     * Returns an associative array containing this class' constants and their
     * values.
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return array<string, mixed> Constants and their values
     */
    public function getConstants() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns an associative array containing copies of all default property
     * values of the class.
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return array<string, mixed> Copies of all default property values
     */
    public function getDefaultProperties() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the line this class' declaration ends at
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return integer Line this class' declaration ends at
     */
    public function getEndLine() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the filename of the file this class was declared in
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string The filename of the file this class was declared in
     */
    public function getFileName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns an array of names of interfaces this class implements
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string[] Array of names of interfaces this class implements
     */
    public function getInterfaceNames() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns a bitfield of the access modifiers for this class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return integer Bitfield of the access modifiers for this method
     */
    public function getModifiers() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the line this class' declaration starts at
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return integer The line this class' declaration starts at
     */
    public function getStartLine() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns an associative array containing all static property values of
     * the class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return array<string,mixed>
     *         An associative array containing all static property values of
     *         the class
     */
    public function getStaticProperties() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the value of a static property
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the static property
     * @param mixed $default Default value
     * @return mixed Value of a static property
     * @since PHP 5.1.0
     */
    public function getStaticPropertyValue( $name, $default = null ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $name, $default ) );
    }

    /**
     * Returns whether a constant exists or not
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the constant
     * @return boolean Whether a constant exists or not
     * @since PHP 5.1.0
     */
    public function hasConstant( $name ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
    }

    /**
     * Returns whether a method exists or not
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the method
     * @return boolean Whether a method exists or not
     * @since PHP 5.1.0
     */
    public function hasMethod( $name ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
    }

    /**
     * Returns whether a property exists or not
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the property
     * @return boolean Whether a property exists or not
     * @since PHP 5.1.0
     */
    public function hasProperty( $name ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $name ) );
    }

    /**
     * Returns whether this class is a subclass of another class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string|ReflectionClass $class
     *        Name or ReflectionClass object of the super class
     * @return boolean Whether this class is a subclass of the given super lass
     */
    public function isSubclassOf( $class ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $class ) );
    }

    /**
     * Returns whether this class implements a given interface
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string|ReflectionClass $interface
     *        Name or ReflectionClass object of the interface
     * @return boolean Whether the given interface is implemented or not
     */
    public function implementsInterface( $interface ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $interface ) );
    }

    /**
     * Returns whether this class is abstract
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is abstract
     */
    public function isAbstract() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is final
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is final
     */
    public function isFinal() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is instantiable
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is instantiable
     */
    public function isInstantiable() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is an interface
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is an interface
     */
    public function isInterface() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is an internal class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is an internal class
     */
    public function isInternal() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is iterateable (can be used inside foreach)
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean
     *         Whether this class is iterateable (can be used inside foreach)
     */
    public function isIterateable() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is user-defined
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is user-defined
     */
    public function isUserDefined() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether the given object is an instance of this class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param object $object An object to be checked
     * @return boolean Whether the given object is an instance of this class
     */
    public function isInstance( $object ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $object ) );
    }

    /**
     * Returns an instance of this class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param mixed $argument,...  Arguments
     * @return object An instance of this class
     */
    public function newInstance( $arguments ) {
        /**
         * Note from PHP Manual: func_get_args() returns a copy of the passed
         * arguments only, and does not account for default (non-passed)
         * arguments.
         */
        $arguments = func_get_args();
        return $this->forwardCallToReflectionSource( __FUNCTION__, $arguments );
    }

    /**
     * Returns an instance of this class
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param array<integer,mixed> $arguments Arguments
     * @return object An instance of this class
     * @since PHP 5.1.3
     */
    public function newInstanceArgs( array $arguments = null ) {
        return $this->forwardCallToReflectionSource( __FUNCTION__, $arguments );
    }

    /**
     * Sets the value of a static property
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @param string $name Name of the static property
     * @param mixed $default Value
     * @return void
     * @since PHP 5.1.0
     */
    public function setStaticPropertyValue( $name, $value ) {
        $this->forwardCallToReflectionSource( __FUNCTION__, array( $name, $value ) );
    }

    /**
     * Returns the name of namespace where this class is defined
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string The name of namespace where this class is defined
     * @since PHP 5.3.0
     */
    public function getNamespaceName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this class is defined in a namespace
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this class is defined in a namespace
     * @since PHP 5.3.0
     */
    public function inNamespace() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the short name of the class (without namespace part)
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string
     *         Returns the short name of the class (without namespace part)
     * @since PHP 5.3.0
     */
    public function getShortName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns a string representation
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string A string representation
     */
    public function __toString() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Exports a ReflectionObject instance.
     *
     * Returns the output if TRUE is specified for $return, printing it otherwise.
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class (ReflectionObject::export()).
     * @param ReflectionObject $object ReflectionClass instance of the object
     * @param boolean $return
     *        Whether to return (TRUE) or print (FALSE) the output
     * @return mixed
     */
    public static function export($object, $return = false) {
        return parent::export($object, $return);
    }

}
?>
