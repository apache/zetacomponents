<?php
/**
 * Constraint which checks if a certain value is found in the input array.
 *
 * Uses in_array() to check if the value is found in the input array, if not
 * found the evaluaton fails.
 *
 * The array value is passed in the constructor.
 */
class ezcMockArrayContainsConstraint implements ezcMockConstraint
{
    /**
     * The array value which should be found in among the input array.
     */
    private $value;

    /**
     * Initialise constraint with array value to find in input array.
     */
    public function __construct( $value )
    {
        $this->value = $value;
    }

    public function generateDescription()
    {
        return "contains value <" . gettype( $this->value ) . ":" . var_export( $this->value, true ) . ">";
    }

    public function evaluate( $other )
    {
        return in_array( $this->value, $other );
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "expected array value <" . gettype( $this->value ) . ":" . var_export( $this->value, true ) . "> not found in array <" . var_export( $other, true ) . ">" );
    }
}
?>
