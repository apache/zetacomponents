<?php
/**
 * File containing the ezcReflectionParameter class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcReflectionParameter class retrieves information about a function's
 * or method's parameters and their types.
 *
 * Extends the ReflectionParameter class to provide type information
 * using PHPDoc annotations.
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
 class ezcReflectionParameter extends ReflectionParameter {

    /**
     * Type of the parameter
     * @var ezcReflectionType
     */
    protected $type;

    /**
     * ReflectionParameter instance if one was provided to the constructor
     * @var ReflectionParameter
     * @deprecated
     */
    protected $parameter = null;
    
    /**
     * @var integer|string|ReflectionParameter
     *      Position, name, or ReflectionParameter instance of the parameter to
     *      inspect
     */
    protected $reflectionSource;

    /**
     * Constructor
     *
     * If called with a ReflectionParameter instance as second argument the,
     * first argument should be a string identifying the type of the parameter.
     * @param string|array<integer,string|object> $functionOrMethod
     *        The function, method or type of the parameter given as function
     *        name, array($classname, $method), or array($object, $method)
     * @param integer|string|ReflectionParameter $parameter
     *        Position (starting at 0), name, or ReflectionParameter instance
     *        of the parameter to introspect.
     * @param string $type
     *        Type of the parameter given in form of the type name.
     * @throws ReflectionException
     *         in case the given method or function does not exist.
     */
    public function __construct( $functionOrMethod, $parameterPositionNameOrSource, $type = null )
    {
        if ( $parameterPositionNameOrSource instanceof parent ) {
            $this->parameter = $parameterPositionNameOrSource; // source
            $this->reflectionSource = $parameterPositionNameOrSource;
        }
        else {
            parent::__construct( $functionOrMethod, $parameterPositionNameOrSource );
        }
        $this->type = ezcReflection::getTypeByName( $type );
    }

    /**
     * Use overloading to call additional methods
     * of the ReflectionParameter instance given to the constructor.
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
            //*
            return call_user_func_array( array( $this, 'parent::' . $method ), $arguments );
            /*/
            $argumentStrings = array();
            foreach ( array_keys( $arguments ) as $key ) {
                $argumentStrings[] = '$arguments[' . var_export( $key, true ) . ']';
            }
            $cmd = 'return parent::$method( ' . implode( ', ', $argumentStrings ) . ' );';
            return eval( $cmd );
            //*/
        }
    }

    /**
     * Returns the type of this parameter in form of an ezcReflectionType
     *
     * A valid type hint for the parameter will be preferred over a type
     * annotation.
     *
     * @return ezcReflectionType
     * @throws ReflectionException
     *         if a parameter uses 'self' or 'parent' as type hint, but function
     *         is not a class member, if a parameter uses 'parent' as type hint,
     *         although class does not have a parent, or if the class does not
     *         exist
     */
    public function getType() {
        $typeHint = $this->getClass();
        if ( $typeHint instanceOf ReflectionClass ) {
            return ezcReflection::getTypeByName( $typeHint );
        } else {
            return $this->type;
        }
    }

    /**
     * Returns whether NULL is allowed as this parameters's value
     * @return boolean
     */
    public function allowsNull() {
        if ($this->parameter != null) {
            return $this->parameter->allowsNull();
        }
        else {
            return parent::allowsNull();
        }
    }

    /**
     * Returns whether this parameter is an optional parameter
     * @return boolean
     * @since PHP 5.0.3
     */
    public function isOptional() {
        if ($this->parameter != null) {
            return $this->parameter->isOptional();
        }
        else {
            return parent::isOptional();
        }
    }

    /**
     * Returns whether this parameters is passed to by reference
     * @return boolean
     */
    public function isPassedByReference() {
        if ($this->parameter != null) {
            return $this->parameter->isPassedByReference();
        }
        else {
            return parent::isPassedByReference();
        }
    }

	/**
     * Returns whether parameter MUST be an array
     * @return boolean
     * @since PHP 5.1.0
     */
    public function isArray() {
        if ($this->parameter != null) {
            return $this->parameter->isArray();
        }
        else {
            return parent::isArray();
        }
    }

    /**
     * Returns whether the default value of this parameter is available
     * @return boolean
     * @since PHP 5.0.3
     */
    public function isDefaultValueAvailable() {
        if ($this->parameter != null) {
            return $this->parameter->isDefaultValueAvailable();
        }
        else {
            return parent::isDefaultValueAvailable();
        }
    }

    /**
     * Returns this parameters's name
     * @return string
     */
    public function getName() {
        if ($this->parameter != null) {
            return $this->parameter->getName();
        }
        else {
            return parent::getName();
        }
    }

	/**
     * Returns whether this parameter is an optional parameter
     * @return integer
     * @since PHP 5.2.3
     */
    public function getPosition() {
        if ($this->parameter != null) {
            return $this->parameter->getPosition();
        }
        else {
            return parent::getPosition();
        }
    }

    /**
     * Returns the default value of this parameter or throws an exception
     * @return mixed
     * @since PHP 5.0.3
     */
    public function getDefaultValue() {
        if ($this->parameter != null) {
            return $this->parameter->getDefaultValue();
        }
        else {
            return parent::getDefaultValue();
        }
    }

    /**
     * Returns reflection object identified by type hinting or NULL if there is
     * no hint
     *
     * This method does not rely on type annotations. That gives users the
     * freedom to decide on whether they want to trust the type annotations,
     * i.e., by calling {@link getType()}, or only PHP's type hinting, which is
     * the sole data source for this method.
     *
     * @return ezcReflectionClass|NULL
     *         Class identified by type hinting or NULL if there is no hint
     * @throws ReflectionException
     *         if a parameter uses 'self' or 'parent' as type hint, but function
     *         is not a class member, if a parameter uses 'parent' as type hint,
     *         although class does not have a parent, or if the class does not
     *         exist
     */
    public function getClass() {
        $class = $this->forwardCallToReflectionSource( __FUNCTION__ );
        if ( $class instanceOf ReflectionClass ) {
            return new ezcReflectionClass( $class );
        } else {
            return $class;
        }
    }

    /**
     * Returns the function or method declaring this parameter
     * @return ezcReflectionFunction|ezcReflectionMethod
     * @since PHP 5.2.3
     */
    public function getDeclaringFunction()
    {
        if ( $this->parameter instanceOf parent ) {
            $func = $this->parameter->getDeclaringFunction();
        }
        else {
            $func = parent::getDeclaringFunction();
        }
        if ( $func instanceOf ReflectionMethod ) {
            return new ezcReflectionMethod( $func->getDeclaringClass(), $func->getName() );
        }
        else {
            return new ezcReflectionFunction( $func->getName() );
        }
	}

    /**
     * Returns in which class this parameter is defined (not the type hint of the parameter)
     * @return ezcReflectionClass
     */
    function getDeclaringClass() {
        if ($this->parameter != null) {
            $class = $this->parameter->getDeclaringClass();
        }
        else {
            $class = parent::getDeclaringClass();
        }

		if (!empty($class)) {
		    return new ezcReflectionClass($class->getName());
		}
		else {
		    return null;
		}
    }

    /**
     * Returns a string representation
     * @return string
     */
    public function __toString() {
        if ( $this->parameter ) {
            return $this->parameter->__toString();
        } else {
            return parent::__toString();
        }
    }

    /**
     * Exports a reflection object.
     *
     * Returns the output if TRUE is specified for $return, printing it otherwise.
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class.
     * @param mixed $function Function or Method
     * @param mixed $parameter Parameter
     * @param boolean $return
     *        Whether to return (TRUE) or print (FALSE) the output
     * @return mixed
     */
    public static function export($function, $parameter, $return = false) {
        return parent::export($function, $parameter, $return);
    }

}
?>
