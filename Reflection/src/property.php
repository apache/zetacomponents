<?php
/**
 * File containing the ezcReflectionProperty class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionProperty class to provide type information
 * using PHPDoc annotations.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionProperty extends ReflectionProperty
{

	/**
     * @var ezcReflectionDocCommentParser Parser for source code annotations
     */
    protected $docParser;

    /**
     * @var ReflectionProperty
     *      Name, instance of the property's class
     *      or ReflectionProperty object of the property
     */
	protected $reflectionSource;

    /**
     * Constructs a new ezcReflectionProperty object
     *
     * Throws an Exception in case the given property does not exist
     * @param string|object|ReflectionProperty $class
     *        Name, instance of the property's class
     *        or ReflectionProperty object of the property
     * @param string $name
     *        Name of the property to be reflected.
     *        Can be null or will be ignored if a ReflectionProperty object is
     *        given as first parameter.
     */
    public function __construct( $class, $name = null )
    {
        if ( !$class instanceof ReflectionProperty )
        {
            parent::__construct( $class, $name );
        }
        $this->reflectionSource = $class;

        $this->docParser = ezcReflectionApi::getDocCommentParserInstance();
        $this->docParser->parse( $this->getDocComment() );
    }

    /**
     * Use overloading to call additional methods
     * of the ReflectionProperty instance given to the constructor.
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
     * Determines the type of the property based on source code annotations.
     *
     * @return ezcReflectionType Type of the property
     * @since PHP 5.1.0
     */
    public function getType()
    {
        $vars = $this->docParser->getVarAnnotations();
        if ( isset( $vars[0] ) )
        {
            return ezcReflectionApi::getTypeByName( $vars[0]->getTypeName() );
        }
        else
        {
            return null;
        }
    }

    /**
     * Returns the declaring class.
     *
     * @return ezcReflectionClassType
     */
    public function getDeclaringClass()
    {
		if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return new ezcReflectionClassType( $this->reflectionSource->getDeclaringClass() );
        }
        else
        {
            $class = parent::getDeclaringClass();
            return new ezcReflectionClassType( $class->getName() );
        }
    }

    /**
     * Checks whether the property is annotated with the annotation $annotation
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
    public function getAnnotations($name = '') {
        if ($name == '') {
            return $this->docParser->getAnnotations();
        }
        else {
            return $this->docParser->getAnnotationsByName($name);
        }
    }

	/**
     * Returns the PHPDoc comment of the property.
     *
     * @return string PHPDoc comment
     * @since PHP 5.1.0
     */
    public function getDocComment()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            // query external reflection object
            $comment = $this->reflectionSource->getDocComment();
        }
        else
        {
            $comment = parent::getDocComment();
        }
        return $comment;
    }

	/**
     * Returns the name of the property.
     *
     * @return string property name
     */
    public function getName()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            $name = $this->reflectionSource->getName();
        }
        else
        {
            $name = parent::getName();
        }
        return $name;
    }

	/**
     * Returns true if this property has public as access level.
     *
     * @return bool
     */
    public function isPublic()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return $this->reflectionSource->isPublic();
        }
        else
        {
            return parent::isPublic();
        }
    }

	/**
     * Returns true if this property has protected as access level.
     *
     * @return bool
     */
    public function isProtected()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return $this->reflectionSource->isProtected();
        }
        else
        {
            return parent::isProtected();
        }
    }

	/**
     * Returns true if this property has private as access level.
     *
     * @return bool
     */
    public function isPrivate()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return $this->reflectionSource->isPrivate();
        }
        else
        {
            return parent::isPrivate();
        }
    }

	/**
     * Returns true if this property has is a static property.
     *
     * @return bool
     */
    public function isStatic()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return $this->reflectionSource->isStatic();
        }
        else
        {
            return parent::isStatic();
        }
    }

	/**
     * Returns whether the property is a default property defined in the class.
     *
	 * A default property is defined in the class definition.
	 * A non-default property is an instance specific state.
     * @return bool
     */
    public function isDefault()
    {
        if ( $this->reflectionSource instanceof ReflectionProperty )
        {
            return $this->reflectionSource->isDefault();
        }
        else
        {
            return parent::isDefault();
        }
    }

	/**
     * Returns a bitfield of the access modifiers for this property.
     *
     * @return int
     */
    public function getModifiers()
    {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

	/**
     * Returns the property's value.
     *
     * @param object $object An object from which the property value is obtained
     * @return mixed The property's value
     */
    public function getValue( $object = null )
    {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $object ) );
    }

	/**
     * Changes the property's value.
     *
     * @param object $object An object on which the property value will be changed
     * @param mixed $value Value of the property
     * @return void
     */
    public function setValue( $object, $value = null )
    {
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $object, $value ) );
    }

    /**
     * Sets whether non-public properties can be requested
     *
     * @param boolean $value Whether non-public properties can be requested
     * @return void
     * @since PHP 5.3.0
     */
    public function setAccessible( $value )
    {
        $this->forwardCallToReflectionSource( __FUNCTION__, array( $object, $value ) );
    }

    /**
     * Returns a string representation
     * @return string
     */
    public function __toString() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->__toString();
        } else {
            return parent::__toString();
        }
    }

    /**
     * Exports a ReflectionProperty instance.
     *
     * Returns the output if TRUE is specified for return, printing it otherwise.
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class.
     * @param ReflectionClass|string $class
     *        ReflectionClass object or name of the class
     * @param ReflectionProperty|string $property
     *        ReflectionProperty object or name of the class
     * @param boolean $return
     *        Whether to return (TRUE) or print (FALSE) the output
     * @return mixed
     */
    public static function export($class, $property, $return = false) {
        return parent::export($class, $property, $return);
    }

}
?>
