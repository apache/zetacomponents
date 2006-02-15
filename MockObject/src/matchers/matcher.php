<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Main matcher which defines a full expectation using method, parameter and invocation matchers.
 *
 * This matcher encapsulates all the other matchers and allows the builder to set
 * the specific matchers when the appropriate methods are called (once(), where()
 * etc.).
 *
 * All properties are public so that they can easily be accessed by the builder.
 */
class ezcMockMatcher implements ezcMockInvocationMatcher
{
    /**
     * The matcher for method names or null if no matcher is set yet.
     * @var ezcMockMethodNameMatcher
     */
    public $methodNameMatcher;
    /**
     * The matcher for parameters or null if no matcher is set yet.
     * @var ezcMockParameterMatcher
     */
    public $parametersMatcher;
    /**
     * The matcher for invocation which is supplied in constructor.
     * @var ezcMockInvocationMatcher
     */
    public $invocationMatcher;
    /**
     * Identification of matcher which must be invoked before this
     * one or null of not defined.
     * @var string/null
     */
    public $afterMatchBuilderId;
    /**
     * Controls whether the current matcher has been invoked.
     * @var bool
     */
    public $afterMatchBuilderIsInvoked;

    /**
     * Initialises the matcher with the main invocation matcher and sets the rest to null.
     */
    public function __construct( ezcMockInvocationMatcher $invocationMatcher )
    {
        $this->invocationMatcher = $invocationMatcher;
        $this->methodNameMatcher = null;
        $this->parametersMatcher = null;
        $this->afterMatchBuilderId = null;
        $this->afterMatchBuilderIsInvoked = false;
        $this->stub = null;
    }

    /**
     * Generates description for all defined matchers and returns it.
     */
    public function generateDescription()
    {
        $list = array();

        if ( $this->invocationMatcher !== null )
            $list[] = $this->invocationMatcher->generateDescription();

        if ( $this->methodNameMatcher !== null )
            $list[] = "where " . $this->methodNameMatcher->generateDescription();

        if ( $this->parametersMatcher !== null )
            $list[] = "and " . $this->parametersMatcher->generateDescription();

        if ( $this->afterMatchBuilderId !== null )
            $list[] = "after " . $this->afterMatchBuilderId;

        if ( $this->stub !== null )
            $list[] = "will " . $this->stub->generateDescription();

        return join( " ", $list );
    }

    public function invoked( ezcMockInvocation $invocation )
    {
        // @todo use specific exception
        if ( $this->invocationMatcher === null )
            throw Exception( "No invocation matcher is set" );

        // @todo use specific exception
        if ( $this->methodNameMatcher === null )
            throw Exception( "No method matcher is set" );

        // If we have an ID we need to check that it has already been run
        // before doing the rest of the matching
        if ( $this->afterMatchBuilderId !== null )
        {
            $builder = $invocation->object->getInvocationMocker()->lookupId( $this->afterMatchBuilderId );
            if ( !$builder )
                // todo proper exception
                throw new Exception( "No builder found for match builder identification <{$this->afterMatchBuilderId}>" );

            $matcher = $builder->getMatcher();

            if ( $matcher and
                 $matcher->invocationMatcher->hasBeenInvoked() )
            {
                $this->afterMatchBuilderIsInvoked = true;
            }
        }

        $this->invocationMatcher->invoked( $invocation );

        try
        {
            if ( $this->parametersMatcher !== null and
                 !$this->parametersMatcher->matches( $invocation ) )
                $this->parametersMatcher->verify();
        }
        catch ( ezcMockExpectationFailedException $e )
        {
            throw new ezcMockExpectationFailedException( "Expectation failed for " . $this->methodNameMatcher->generateDescription() .
                                                         " when " . $this->invocationMatcher->generateDescription() . "\n" .
                                                         $e->description,
                                                         $e->diff );
        }

        // If we have stub execute it and return its value
        if ( $this->stub )
            return $this->stub->invoke( $invocation );

        // No stub so we return null
        return null;
    }

    public function matches( ezcMockInvocation $invocation )
    {
        // If we have an ID we need to check that it has already been run
        // before doing the rest of the matching
        if ( $this->afterMatchBuilderId !== null )
        {
            $builder = $invocation->object->getInvocationMocker()->lookupId( $this->afterMatchBuilderId );
            if ( !$builder )
                // todo proper exception
                throw new Exception( "No builder found for match builder identification <{$this->afterMatchBuilderId}>" );

            $matcher = $builder->getMatcher();

            if ( !$matcher )
                return false;

            if ( !$matcher->invocationMatcher->hasBeenInvoked() )
                return false;
        }

        // @todo use specific exception
        if ( $this->invocationMatcher === null )
            throw Exception( "No invocation matcher is set" );

        // @todo use specific exception
        if ( $this->methodNameMatcher === null )
            throw Exception( "No method matcher is set" );

        if ( !$this->invocationMatcher->matches( $invocation ) )
            return false;

        try
        {
            if ( !$this->methodNameMatcher->matches( $invocation ) )
                return false;
        }
        catch ( ezcMockExpectationFailedException $e )
        {
            throw new ezcMockExpectationFailedException( "Expectation failed for " . $this->methodNameMatcher->generateDescription() .
                                                         " when " . $this->invocationMatcher->generateDescription() . "\n" .
                                                         $e->description,
                                                         $e->diff );
        }

        return true;
    }

    public function verify()
    {
        // When a stub is set there is no need to verify?
        if ( $this->stub !== null )
            return;

        // @todo use specific exception
        if ( $this->invocationMatcher === null )
            throw Exception( "No invocation matcher is set" );

        // @todo use specific exception
        if ( $this->methodNameMatcher === null )
            throw Exception( "No method matcher is set" );

        // If we have an ID we need to check that it has already been run
        // before doing the rest of the matching
/*        if ( $this->afterMatchBuilderId !== null )
        {
            if ( !$this->afterMatchBuilderIsInvoked )
                // todo specific exception
                throw new Exception( "" );
        }*/

        $this->invocationMatcher->verify();

        try
        {
            if ( $this->parametersMatcher !== null )
                $this->parametersMatcher->verify();
        }
        catch ( ezcMockExpectationFailedException $e )
        {
            throw new ezcMockExpectationFailedException( "Expectation failed for " . $this->methodNameMatcher->generateDescription() .
                                                         " when " . $this->invocationMatcher->generateDescription() . "\n" .
                                                         $e->description,
                                                         $e->diff );
        }
    }

}
?>
