<?php
/**
 * Builder for mocked or stubbed invocations.
 *
 * Provides methods for building expectations without having to resort to
 * instantiating the various matchers manually. These methods also form a
 * more natural way of reading the expectation. This class should be together
 * with the test case ezcMockCase.
 */
class ezcMockInvocationMockerBuilder implements ezcMockMethodNameMatchBuilder
{
    /**
     * Collection which contains all expectations and stubs for a mock object.
     * @var ezcMockStubMatchersCollection
     */
    private $collection;

    /**
     * The main matcher object which is used to create the expectation or stub.
     * @var ezcMockMatcher
     */
    private $matcher;

    /**
     * Initialise builder with the stub collection and the matcher for invocations.
     *
     * @param ezcMockStubMatchersCollection $collection The collection which the builder will add the expectation to.
     * @param ezcMockInvocationMatcher $invocationMatcher The main matcher for the invocation, is normally used for counting the number of expected invocations.
     */
    public function __construct( ezcMockStubMatchersCollection $collection, ezcMockInvocationMatcher $invocationMatcher )
    {
        $this->collection = $collection;
        $this->matcher = new ezcMockMatcher( $invocationMatcher );
        $this->collection->addMatcher( $this->matcher );
    }

    /**
     * Returns the main matcher object.
     *
     * @return ezcMockMatcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Records the unique ID for the current matcher.
     */
    public function id( $id )
    {
        $this->collection->registerId( $id, $this );
        return $this;
    }

    /**
     * Records the stub object $stub in the current matcher.
     *
     * @return ezcMockIdentityBuilder
     */
    public function will( ezcMockStub $stub )
    {
        $this->matcher->stub = $stub;
        return $this;
    }

    /**
     * Records the expectation which must occur before the current one.
     *
     * @return ezcTestMockStubBuilder
     */
    public function after( $id )
    {
        $this->matcher->afterMatchBuilderId = $id;
        return $this;
    }

    /**
     * Records the parameters which the method must match. All parameters to
     * this method is passed onto an ezcMockParametersMatcher object.
     * If the parameter value is not a constraint it will use the
     * ezcMockIsEqualConstraint for the value.
     *
     * @return ezcMockParametersMatchBuilder
     */
    public function with()
    {
        // @todo another exception type
        if ( $this->matcher->methodNameMatcher === null )
            throw Exception( "Method name matcher is not defined, cannot define parameter matcher without one" );

        // @todo another exception type
        if ( $this->matcher->parametersMatcher !== null )
            throw Exception( "Parameter matcher is already defined, cannot redefine" );

        $args = func_get_args();
        $this->matcher->parametersMatcher = new ezcMockParametersMatcher( $args );
        return $this;
    }

    /**
     * Sets a matcher which allows any kind of parameters.
     *
     * @return ezcMockParametersMatchBuilder
     */
    public function withAnyParameters()
    {
        // @todo another exception type
        if ( $this->matcher->methodNameMatcher === null )
            throw Exception( "Method name matcher is not defined, cannot define parameter matcher without one" );

        // @todo another exception type
        if ( $this->matcher->parametersMatcher !== null )
            throw Exception( "Parameter matcher is already defined, cannot redefine" );

        $this->matcher->parametersMatcher = new ezcMockAnyParametersMatcher();
        return $this;
    }

    /**
     * Records the method name which must be matched for the expectation or
     * stub to be checked.
     * @param mixed $constraint The constraint which will be used to match the
     * name, if this is not an ezcMockConstraint it will use the
     * ezcMockIsEqualConstraint for evaluating the value.
     *
     * @return ezcMockParametersMatchBuilder
     */
    public function method( $constraint )
    {
        // @todo another exception type
        if ( $this->matcher->methodNameMatcher !== null )
            throw Exception( "Method name matcher is already defined, cannot redefine" );

        $this->matcher->methodNameMatcher = new ezcMockMethodNameMatcher( $constraint );
        return $this;
    }

}
?>
