<?php
/**
 * Constraint which will only evaluate to true if all sub-constraints does the same.
 *
 * This means the constraint behaves like a logical and. All parameters passed
 * to the constructor will be considered a constraint to check.
 */
class ezcMockAndConstraint implements ezcMockConstraint
{
    /**
     * Array of constraints which will be evaluated.
     */
    private $constraints;
    /**
     * The last constraint to fail its evaluation.
     */
    private $failedConstraint;

    /**
     * Initialise constraint with no sub-constraints, set them using setConstraints().
     */
    public function __construct()
    {
        $this->constraints = array();
        $this->failedConstraint = null;
    }

    /**
     * Sets all sub-constraints.
     * @throw Exception if one of the sub-constraints is a non-constraint.
     */
    public function setConstraints( $constraints )
    {
        $this->constraints = array();
        foreach( $constraints as $key => $constraint )
        {
            if ( !( $constraint instanceof ezcMockConstraint ) )
                throw new Exception( "All parameters to " . __CLASS__ . " must be a constraint object." );
            $this->constraints[] = $constraint;
        }
    }

    public function generateDescription()
    {
        $text = "";
        foreach( $this->constraints as $key => $constraint )
        {
            if ( $key > 0 )
                $text .= " and ";
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
        // all sub-constraints must evaluate to true
        $this->failedConstraint = null;
        foreach( $this->constraints as $key => $constraint )
        {
            if ( !$constraint->evaluate( $other ) )
            {
                $this->failedConstraint = $constraint;
                return false;
            }
        }
        return true;
    }

    public function fail( $other, $description )
    {
        if ( $this->failedConstraint !== null )
            $this->failedConstraint->fail( $other,
                                           $description . "\n" .
                                           "Expected that <{$other}> " . $this->generateDescription());
        else
            throw new ezcMockExpectationFailedException( $description . "\n" .
                                                         "Expected that <{$other}> " . $this->generateDescription() );
    }
}
?>
