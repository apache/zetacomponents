<?php
/**
 * Encapsulates information on a method invocation which can be passed to matchers.
 *
 * The invocation consists of the object it occured from, the class name, the
 * method name and all the parameters. The mock object must instantiate this
 * class with the values from the mocked method and pass it to an object of
 * ezcMockInvokable.
 */
class ezcMockInvocation implements ezcMockSelfDescribing
{
    /**
     * The object which the invocation occured for.
     * @var Object
     */
    public $object;

    /**
     * The class name for the object $object.
     * @var string
     */
    public $className;

    /**
     * The name of the method.
     * @var string
     */
    public $methodName;

    /**
     * Array of parameters for the invocation.
     * @var array(mixed)
     */
    public $parameters;

    /**
     * Initialise the invocation with the object, class name, method name and parameters.
     */
    public function __construct( $object, $className, $methodName, $parameters )
    {
        $this->object = $object;
        $this->className = $className;
        $this->methodName = $methodName;
        $this->parameters = $parameters;
    }

    public function generateDescription()
    {
        return sprintf( "{$this->className}::{$this->methodName}(%s)",
                        join( ", ", array_map( create_function( '$a', 'return ezcMockDiff::shortenedExport( $a );' ), $this->parameters ) ) );
    }
}
?>
