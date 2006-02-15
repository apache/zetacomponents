<?php
/**
 * Constraint which checks if one value is equal to another.
 *
 * Equality is checked with PHP's == operator, the operator is explained in detail
 * at {@url http://www.php.net/manual/en/types.comparisons.php}.
 * Two values are equal if they have the same value disregarding type.
 *
 * The expected value is passed in the constructor.
 */
class ezcMockIsEqualConstraint implements ezcMockConstraint
{
    /**
     * The constraint value which all other values must match (with ==).
     */
    private $value;

    /**
     * Initialise constraint with value to match.
     */
    public function __construct( $value )
    {
        $this->value = $value;
    }

    public function generateDescription()
    {
        return "is equal to <" . var_export( $this->value, true ) . ">";
    }

    public function evaluate( $other )
    {
        // Matching is done by PHP
        return $this->value == $other;
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description,
                                                     ezcMockDiff::diffEqual( $this->value, $other ) );
    }
}
?>
