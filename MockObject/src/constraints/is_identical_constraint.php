<?php
/**
 * Constraint which checks if one value is identical to another.
 *
 * Identical check is performed with PHP's === operator, the operator is explained
 * in detail at {@url http://www.php.net/manual/en/types.comparisons.php}.
 * Two values are identical if they have the same value and are of the same type.
 *
 * The expected value is passed in the constructor.
 */
class ezcMockIsIdenticalConstraint implements ezcMockConstraint
{
    /**
     * The constraint value which all other values must match (with ===).
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
        $type = '';
        if ( !is_null( $this->value ) )
            $type = gettype( $this->value ) . ":";
        return "is identical to <" . $type  . var_export( $this->value, true ) . ">";
    }

    public function evaluate( $other )
    {
        // Matching is done by PHP
        return $this->value === $other;
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description,
                                                     ezcMockDiff::diffIdentical( $this->value, $other ) );
    }
}
?>
