<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Mocker for invocations which are sent from ezcMockObject objects.
 *
 * Keeps track of all expectations and stubs as well as registering
 * identifications for builders.
 */
class ezcMockInvocationMocker implements ezcMockStubMatchersCollection, ezcMockInvokable, ezcMockBuilderNamespace
{
    /**
     * Array of matchers which defines the expectations and stubs.
     * @var array(ezcMockInvocationMatcher)
     */
    private $matchers;
    /**
     * Associative array which keeps track of identifiers and their builders.
     * @var array(ezcMockMatchBuilder)
     */
    private $builderMap;

    /**
     * Initialise with an empty match list and builder map.
     */
    public function __construct()
    {
        $this->matchers = array();
        $this->builderMap = array();
    }

    /**
     * Adds the matcher $matcher to the match list.
     */
    public function addMatcher( ezcMockInvocationMatcher $matcher )
    {
        $this->matchers[] = $matcher;
    }

    /**
     * Tries to find the builder which is registered with id $id.
     *
     * @return ezcMockMatchBuilder
     * @param string $id Identification for builder.
     */
    public function lookupId( $id )
    {
        if ( isset( $this->builderMap[$id] ) )
            return $this->builderMap[$id];
        return null;
    }

    /**
     * Registers the builder $builder with the identification $id.
     *
     * @param string $id Identification for builder.
     * @param ezcMockMatchBuilder $builder The builder to register.
     * @throw Exception
     */
    public function registerId( $id, ezcMockMatchBuilder $builder )
    {
        if ( isset( $this->builderMap[$id] ) )
            // @todo change exception
            throw new Exception( "Match builder with id <{$id}> is already registered." );
        $this->builderMap[$id] = $builder;
    }

    /**
     * Creates a new expectation for the mock object by creating a new
     * builder with the invocation matcher $matcher and returning the
     * builder which can be accessed to build the expecations using its
     * methods.
     *
     * @param ezcMockInvocationMatcher $matcher The main matcher for the invocations.
     * @return ezcMockInvocationMockerBuilder
     */
    public function expects( ezcMockInvocationMatcher $matcher )
    {
        $builder = new ezcMockInvocationMockerBuilder( $this, $matcher );
        return $builder;
    }

    /**
     * Invokes the invocation $invocation so that it can be checked against
     * the expectations.
     * The return value will be fetched from the current stub if one is
     * defined.
     *
     * @param ezcMockInvocation $invocation The current invocation which has
     *                                      been passed from the mock object.
     * @return mixed
     */
    public function invoke( ezcMockInvocation $invocation )
    {
        $hasReturnValue = false;
        $returnValue = null;

        foreach( $this->matchers as $match )
        {
            if ( $match->matches( $invocation ) )
            {
                $value = $match->invoked( $invocation );
                if ( !$hasReturnValue )
                {
                    $returnValue = $value;
                    $hasReturnValue = true;
                }
            }
        }
        return $returnValue;
    }

    /**
     * Checks if the current invocation $invocation matches any of the
     * registered expectations and returns true if it does.
     *
     * @param ezcMockInvocation $invocation The current invocation which has
     *                                      been passed from the mock object.
     * @return bool
     */
    public function matches( ezcMockInvocation $invocation )
    {
        foreach( $this->matchers as $matcher )
        {
            if ( !$matcher->matches( $invocation ) )
                return false;
        }
        return true;
    }

    /**
     * Verifies all registered expectations. An exception will be throw if one
     * of them fails the verification.
     */
    public function verify()
    {
        foreach( $this->matchers as $matcher )
        {
            $matcher->verify();
        }
    }
}
?>
