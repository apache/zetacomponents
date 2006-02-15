<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which looks for a specific method name in the invocations.
 *
 * Checks the method name all incoming invocations, the name is checked against
 * the defined constraint $constraint. If the constraint is met it will return
 * true in matches().
 */
class ezcMockMethodNameMatcher extends ezcMockStatelessInvocationMatcher
{
    /**
     * Constraint which must be met for all method names.
     * @var ezcMockConstraint
     */
    private $constraint;

    /**
     * Initialises with a constraint to check against. If the constraint is not
     * an ezcMockConstraint object it will use the ezcMockIsEqualConstraint for
     * the match.
     */
    public function __construct( $constraint )
    {
        if ( !( $constraint instanceof ezcMockConstraint ) )
            $constraint = new ezcMockIsEqualConstraint( $constraint );

        $this->constraint = $constraint;
    }

    public function generateDescription()
    {
        return "method name " . $this->constraint->generateDescription();
    }

    /**
     * Returns true if the constraint matches the invoked method name.
     * @return bool
     */
    public function matches( ezcMockInvocation $invocation )
    {
        return $this->constraint->evaluate( $invocation->methodName );
    }

}

?>
