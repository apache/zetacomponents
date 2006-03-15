<?php
/**
 * Constraint which checks if a certain key is found in the input array.
 *
 * Uses array_key_exists() to check if the key is found in the input array, if not
 * found the evaluaton fails.
 *
 * The array key is passed in the constructor.
 */
class ezcMockArrayHasKeyConstraint implements PHPUnit2_Framework_Constraint
{
    /**
     * The array key which should exist in the input array.
     */
    private $key;

    /**
     * Initialise constraint with array key to find in input array.
     */
    public function __construct( $key )
    {
        $this->key = $key;
    }

    public function toString()
    {
        return "has key <" . gettype( $this->key ) . ":" . var_export( $this->key, true ) . ">";
    }

    public function evaluate( $other )
    {
        return array_key_exists( $this->key, $other );
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "expected array key <" . gettype( $this->key ) . ":" . var_export( $this->key, true ) . "> not found in array <" . var_export( $other, true ) . ">" );
    }
}
?>
