<?php
/**
 * Constraint which checks if one object is and instance of a given class.
 *
 * The expected class name is passed in the constructor.
 */
class ezcMockIsInstanceOfConstraint implements ezcMockConstraint
{
    /**
     * The class name which the other value must be an instance of.
     */
    private $className;

    /**
     * Initialise constraint with class name.
     */
    public function __construct( $className )
    {
        $this->className = $className;
    }

    public function generateDescription()
    {
        return "is instance of <{$this->className}>";
    }

    public function evaluate( $other )
    {
        // Matching is done by PHP
        return ( $other instanceof $this->className );
    }

    public function fail( $other, $description )
    {
        if ( !is_object( $other ) )
            throw new ezcMockExpectationFailedException( $description . "\n" .
                                                         "expected object instance of class <{$this->className}>, got " . gettype( $other ) . " <" . var_export( $other, true ) . ">" );
        else
            throw new ezcMockExpectationFailedException( $description . "\n" .
                                                         "expected object instance of class <{$this->className}>, got class <" . get_class( $other ) . ">" );
    }
}
?>
