<?php
/**
 * File containing the ezcReflectionFunction class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionFunction class to provide type information
 * using PHPDoc annotations.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionFunction extends ReflectionFunction
{
    /**
     * @var ezcReflectionDocCommentParser Parser for source code annotations
     */
    protected $docParser;

    /**
     * @var string|ReflectionFunction
     *     ReflectionFunction object or function name used to initialize this
     *     object
     */
    protected $reflectionSource;

    /**
     * Constructs a new ezcReflectionFunction object
     *
     * Throws an Exception in case the given function does not exist
     * @param string|ReflectionFunction $function
     *        Name or ReflectionFunction object of the function to be reflected
     */
    public function __construct( $function ) {
        if ( !$function instanceof ReflectionFunction ) {
            parent::__construct( $function );
        }
        $this->reflectionSource = $function;

        $this->docParser = ezcReflection::getDocCommentParser();
        $this->docParser->parse( $this->getDocComment() );
    }

    /**
     * Use overloading to call additional methods
     * of the ReflectionFunction instance given to the constructor.
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
     * Returns the parameters of the function as ezcReflectionParameter objects
     *
     * @return ezcReflectionParameter[] Parameters of the Function
     * @since PHP 5.1.0
     */
    function getParameters() {
        $params = $this->docParser->getParamAnnotations();
        $extParams = array();
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            $apiParams = $this->reflectionSource->getParameters();
        } else {
            $apiParams = parent::getParameters();
        }
        foreach ($apiParams as $param) {
            $type = null;
            foreach ($params as $annotation) {
                if (
                    $annotation instanceof ezcReflectionAnnotationParam
                    and $annotation->getParamName() == $param->getName()
                ) {
                    $type = $annotation->getTypeName();
                    break;
                }
            }
            if ( $this->reflectionSource instanceof ReflectionFunction ) {
                $extParams[] = new ezcReflectionParameter(
                    null,
                    $param,
                    $type
                );
            } else {
                // slightly increase performance and save some memory
                $extParams[] = new ezcReflectionParameter(
                    $this->getName(),
                    $param->getPosition(),
                    $type
                );
            }
        }
        return $extParams;
    }

    /**
     * Returns the type of the return value
     *
     * @return ezcReflectionType
     * @since PHP 5.1.0
     */
    function getReturnType() {
        $re = $this->docParser->getReturnAnnotations();
        if (count($re) == 1 and isset($re[0]) and $re[0] instanceof ezcReflectionAnnotationReturn) {
            return ezcReflection::getTypeByName($re[0]->getTypeName());
        }
        return null;
    }

    /**
     * Returns the description of the return value
     *
     * @return string
     * @since PHP 5.1.0
     */
    function getReturnDescription() {
        $re = $this->docParser->getReturnAnnotations();
        if (count($re) == 1 and isset($re[0])) {
            return $re[0]->getDescription();
        }
        return '';
    }

    /**
     * Returns the short description from the function's documentation
     *
     * @return string Short description
     * @since PHP 5.1.0
     */
    public function getShortDescription() {
        return $this->docParser->getShortDescription();
    }

    /**
     * Returns the long description from the function's documentation
     *
     * @return string Long descrition
     * @since PHP 5.1.0
     */
    public function getLongDescription() {
        return $this->docParser->getLongDescription();
    }

    /**
     * Checks whether the function is annotated with the annotation $annotation
     *
     * @param string $annotation Name of the annotation
     * @return boolean True if the annotation exists for this function
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
     * Returns the source code of the function
     *
     * @return string Source code
     */
    public function getCode()
    {
        if ( $this->isInternal() ) {
            $code = '/* ' . $this->getName() . ' is an internal function.'
                  . ' Therefore the source code is not available. */';
        } else {
            $filename = $this->getFileName();

            $start = $this->getStartLine();
            $end = $this->getEndLine();

            $offset = $start - 1;
            $length = $end - $start + 1;
            
            $lines = array_slice( file( $filename ), $offset, $length );

            if ( strpos( trim( $lines[0] ), 'function' ) !== 0 ) {
                $lines[0] = substr( $lines[0], strpos( $lines[0], 'function' ) );
            }

            $code = implode( '', $lines );
        }
        return $code;
    }
    

    // the following methods do not contain additional features
    // they just call the parent method or the reflection source

    /**
     * Returns a string representation
     *
     * @return string String representation
     */
    public function __toString() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->__toString();
        } else {
            return parent::__toString();
        }
    }

    /**
     * Returns this function's name
     *
     * @return string This function's name
     */
    public function getName() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getName();
        } else {
            return parent::getName();
        }
    }

    /**
     * Returns whether this is an internal function
     *
     * @return boolean True if this is an internal function
     */
    public function isInternal() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->isInternal();
        } else {
            return parent::isInternal();
        }
    }

    /**
     * Returns whether this is a user-defined function
     *
     * @return boolean True if this is a user-defined function
     */
    public function isUserDefined() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->isUserDefined();
        } else {
            return parent::isUserDefined();
        }
    }

    /**
     * Returns whether this function has been disabled or not
     *
     * @return boolean True if this function has been disabled
     */
    public function isDisabled() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->isDisabled();
        } else {
            return parent::isDisabled();
        }
    }

    /**
     * Returns the filename of the file this function was declared in
     *
     * @return string Filename of the file this function was declared in
     */
    public function getFileName() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getFileName();
        } else {
            return parent::getFileName();
        }
    }

    /**
     * Returns the line this function's declaration starts at
     *
     * @return integer Line this function's declaration starts at
     */
    public function getStartLine() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getStartLine();
        } else {
            return parent::getStartLine();
        }
    }

    /**
     * Returns the line this function's declaration ends at
     *
     * @return integer Line this function's declaration ends at
     */
    public function getEndLine() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getEndLine();
        } else {
            return parent::getEndLine();
        }
    }

    /**
     * Returns the doc comment for this function
     *
     * @return string Doc comment for this function
     * @since PHP 5.1.0
     */
    public function getDocComment() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getDocComment();
        } else {
            return parent::getDocComment();
        }
    }

    /**
     * Returns an associative array containing this function's static variables
     * and their values
     *
     * @return array<sting,mixed> This function's static variables
     */
    public function getStaticVariables() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getStaticVariables();
        } else {
            return parent::getStaticVariables();
        }
    }

    /**
     * Invokes the function
     *
     * @param mixed $argument,...  Arguments
     * @return mixed               Return value of the function invocation
     */
    public function invoke( $arguments = array() ) {
        $arguments = func_get_args();
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            // doesn't work: return call_user_func_array( array( $this->reflectionSource, 'invoke' ), $arguments );
            // but hopefully the methods invoke and invokeArgs of
            // the external ReflectionFunction implementation are semantically the same
            return $this->reflectionSource->invokeArgs( $arguments );
        } else {
            // doesn't work: return call_user_func_array( array( parent, 'invoke' ), $arguments );
            // but hopefully the methods invoke and invokeArgs of
            // PHP's ReflectionFunction are semantically the same
            return parent::invokeArgs( $arguments );
        }
    }

    /**
     * Invokes the function and allows to pass its arguments as an array
     *
     * @param array<integer,mixed> $arguments
     *     Arguments
     * @return mixed
     *     Return value of the function invocation
     * @since PHP 5.1.0
     */
    public function invokeArgs( Array $arguments ) {
        /*
        return $this->forwardCallToReflectionSource( __FUNCTION__, array( $arguments ) );
        /*/
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->invokeArgs( $arguments );
        } else {
            return parent::invokeArgs( $arguments );
        }
        //*/
    }

    /**
     * Returns whether this function returns a reference
     *
     * @return boolean True if this function returns a reference
     */
    public function returnsReference() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->returnsReference();
        } else {
            return parent::returnsReference();
        }
    }

    /**
     * Returns the number of parameters
     *
     * @return integer The number of parameters
     * @since PHP 5.0.3
     */
    public function getNumberOfParameters() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getNumberOfParameters();
        } else {
            return parent::getNumberOfParameters();
        }
    }

    /**
     * Returns the number of required parameters
     *
     * @return integer The number of required parameters
     * @since PHP 5.0.3
     */
    public function getNumberOfRequiredParameters() {
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->getNumberOfRequiredParameters();
        } else {
            return parent::getNumberOfRequiredParameters();
        }
    }

    /**
     * Returns NULL or the extension the function belongs to
     *
     * @return ezcReflectionExtension Extension the function belongs to
     */
    public function getExtension() {
        if ( $this->getExtensionName() === false ) {
            return null;
        } else {
            if ( $this->reflectionSource instanceof ReflectionFunction ) {
                return new ezcReflectionExtension(
                    $this->reflectionSource->getExtension()
                );
            } else {
                // using the name, since otherwhise the object would be treated like an
                // external reflection implementation and that would decrease performance
                return new ezcReflectionExtension( parent::getExtensionName() );
            }
        }
    }

    /**
     * Returns false or the name of the extension the function belongs to
     *
     * @return string|boolean False or the name of the extension
     */
    public function getExtensionName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this function is deprecated
     *
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class.
     * @return boolean
     */
    public function isDeprecated() {
        // TODO: also check @deprecated annotation
        if ( $this->reflectionSource instanceof ReflectionFunction ) {
            return $this->reflectionSource->isDeprecated();
        } else {
            return parent::isDeprecated();
        }
    }

    /**
     * Returns the name of namespace where this function is defined
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string The name of namespace where this function is defined
     * @since PHP 5.3.0
     */
    public function getNamespaceName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this function is defined in a namespace
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this function is defined in a namespace
     * @since PHP 5.3.0
     */
    public function inNamespace() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns the short name of the function (without namespace part)
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return string
     *         Returns the short name of the function (without namespace part)
     * @since PHP 5.3.0
     */
    public function getShortName() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Returns whether this is a closure
     *
     * This is purely a wrapper method, which either calls the corresponding
     * method of the parent class or forwards the call to the ReflectionClass
     * instance passed to the constructor.
     * @return boolean Whether this is a closure 
     * @since PHP 5.3.0
     */
    public function isClosure() {
        return $this->forwardCallToReflectionSource( __FUNCTION__ );
    }

    /**
     * Exports a ReflectionFunction object.
     *
     * Returns the output if TRUE is specified for $return, printing it otherwise.
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class (ReflectionFunction::export()).
     * @param string $function Name of the function
     * @param boolean $return
     *        Whether to return (TRUE) or print (FALSE) the output
     * @return mixed
     */
    public static function export($function, $return = false) {
        return parent::export($function, $return);
    }

}
?>
