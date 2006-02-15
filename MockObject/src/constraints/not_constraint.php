<?php
/**
 * Constraint which inverts the evaluation result of a sub-constraint.
 *
 * This class will evaluate the sub-constraint and invert (not) the value,
 * this means true becomes false and false becomes true.
 *
 * The sub-constrainted is passed in the constructor.
 */
class ezcMockNotConstraint implements ezcMockConstraint
{
    /**
     * The sub-constraint which will be evaluated.
     */
    private $constraint;

    /**
     * Initialise with sub-constraint.
     * @param ezcMockConstraint $constraint The sub-constraint object, if this
     * is not an ezcMockConstraint instance it will use ezcMockIsEqualConstraint
     * for the value.
     */
    public function __construct( $constraint )
    {
        if ( !( $constraint instanceof ezcMockConstraint ) )
            $constraint = new ezcMockIsEqualConstraint( $constraint );
        $this->constraint = $constraint;
    }

    public function generateDescription()
    {
        return "not " . $this->constraint->generateDescription();
    }

    public function evaluate( $other )
    {
        return !$this->constraint->evaluate( $other );
    }

    public function fail( $other, $description )
    {
        $this->constraint->fail( $other, $description );
    }
}
?>
