<?php
/**
 * Constraint which checks if one value is less than another.
 *
 * The expected value is passed in the constructor.
 */
class ezcMockGreaterThanConstraint implements ezcMockConstraint
{
    /**
     * The constraint value which all other values must be greater than.
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
        return "is greater than <" . $type  . var_export( $this->value, true ) . ">";
    }

    public function evaluate( $other )
    {
        return $this->value < $other;
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description,
                                                     ezcMockDiff::diffIdentical( $this->value, $other ) );
    }
}
?>
