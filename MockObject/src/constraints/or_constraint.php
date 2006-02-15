<?php
/**
 * Constraint which will only evaluate to true if at least one of the sub-constraints does the same.
 *
 * This means the constraint behaves like a logical or. All parameters passed
 * to the constructor will be considered a constraint to check.
 */
class ezcMockOrConstraint implements ezcMockConstraint
{
    /**
     * Array of constraints which will be evaluated.
     */
    private $constraints;

    /**
     * Initialise constraint with no sub-constraints, set them using setConstraints().
     */
    public function __construct()
    {
        $this->constraints = array();
    }

    /**
     * Sets all sub-constraints, if one of them is not an instance of
     * ezcMockConstraint it will use the ezcMockIsEqualConstraint for it.
     */
    public function setConstraints( $constraints )
    {
        $this->constraints = array();
        foreach( $constraints as $key => $constraint )
        {
            if ( !( $constraint instanceof ezcMockConstraint ) )
                $constraint = new ezcMockIsEqualConstraint( $constraint );
            $this->constraints[] = $constraint;
        }
    }

    public function generateDescription()
    {
        $text = "";
        foreach( $this->constraints as $key => $constraint )
        {
            if ( $key > 0 )
                $text .= " or ";
            $text .= $constraint->generateDescription();;
        }
        return $text;
    }

    /**
     * Evaluates all sub-constraints and returns true if all of them evaluates
     * to true.
     * @return bool
     */
    public function evaluate( $other )
    {
        // at least one sub-constraint must evaluate to true
        foreach( $this->constraints as $key => $constraint )
        {
            if ( $constraint->evaluate( $other ) )
            {
                return true;
            }
        }
        return false;
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "expected <{$other}> " . $this->generateDescription() );
    }
}
?>
