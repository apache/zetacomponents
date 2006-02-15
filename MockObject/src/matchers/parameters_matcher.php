<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which looks for specific parameters in the invocations.
 *
 * Checks the parameters of all incoming invocations, the parameter list is
 * checked against the defined constraints in $parameters. If the constraint
 * is met it will return true in matches().
 */
class ezcMockParametersMatcher extends ezcMockStatelessInvocationMatcher
{
    /**
     * Array of parameter constraints which must be met.
     * @var ezcMockConstraint
     */
    private $parameters;
    /**
     * The last invocation which occured, this will be accessed in verify() to
     * check that the expectation is met.
     */
    private $invocation;

    /**
     * Initialises the matcher with an array of parameter constraints.
     * @param array(mixed) $parameters Array of parameter constraints, if the
     *                                 value is not an ezcMockConstraint object
     *                                 it will use ezcMockIsEqualConstraint
     *                                 for the matching.
     */
    public function __construct( $parameters )
    {
        parent::__construct();
        $this->parameters = array();
        foreach( $parameters as $parameter )
        {
            if ( !( $parameter instanceof ezcMockConstraint ) )
                $parameter = new ezcMockIsEqualConstraint( $parameter );
            $this->parameters[] = $parameter;
        }
    }

    public function generateDescription()
    {
        $text = "with parameter";
        foreach( $this->parameters as $index => $parameter )
        {
            if ( $index > 0 )
                $text .= " and";
            $text .= " {$index} " . $parameter->generateDescription();
        }
        return $text;
    }

    /**
     * Returns true if the invocation has the correct number of parameters
     * and that all parameters matches the defined constraints.
     */
    public function matches( ezcMockInvocation $invocation )
    {
        $this->invocation = $invocation;

        $this->verify();

        return count( $invocation->parameters ) < count( $this->parameters );
    }

    /**
     * Verifies that the invocation has the correct number of parameters
     * and that all parameters match the defined constraint. If this fails
     * it will throw an exception.
     */
    public function verify()
    {
        if ( count( $this->invocation->parameters ) < count( $this->parameters ) )
            throw new ezcMockExpectationFailedException( "Parameter count for invocation " . $this->invocation->generateDescription() . " is too low.",
                                                         new ezcMockScalarDiff( count( $this->parameters ),
                                                                                count( $this->invocation->parameters ) ) );

        // Check constraint for all parameters
        foreach( $this->parameters as $i => $parameter )
        {
            if ( !$parameter->evaluate( $this->invocation->parameters[$i] ) )
                $parameter->fail( $this->invocation->parameters[$i],
                                 "Parameter {$i} for invocation " . $this->invocation->generateDescription() . " does not match expected value." );
        }
    }
}
?>
