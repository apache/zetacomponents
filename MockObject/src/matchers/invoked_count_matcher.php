<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which checks if a method has been invoked a certain amount of times.
 *
 * If the number of invocations exceeds the value it will immediately throw an exception,
 * if the number is less it will later be checked in verify() and also throw an exception.
 */
class ezcMockInvokedCountMatcher extends ezcMockInvokedRecorder
{
    /**
     * The expected number of times the method should be invoked.
     */
    private $expectedCount;

    /**
     * Initialises the matcher with the expected number of invocations.
     */
    public function __construct( $expectedCount )
    {
        $this->expectedCount = $expectedCount;
    }

    public function generateDescription()
    {
        return "invoked {$this->expectedCount} time(s)";
    }

    /**
     * Records the invocation and checks if the expected count has been exceeded.
     */
    public function invoked( ezcMockInvocation $invocation )
    {
        parent::invoked( $invocation );
        $count = $this->getInvocationCount();
        if ( $count > $this->expectedCount )
        {
            throw new ezcMockExpectationFailedException( "Expected count for invocation <" . $invocation->generateDescription() . "> is wrong.",
                                                         new ezcMockScalarDiff( $this->expectedCount, $count ) );
        }
    }

    /**
     * Checks if the invocation count has been reached, if not it throws an exception.
     */
    public function verify( )
    {
        $count = $this->getInvocationCount();
        if ( $count !== $this->expectedCount )
            throw new ezcMockExpectationFailedException( "Expected invocation count for is wrong.",
                                                         new ezcMockScalarDiff( $this->expectedCount, $count ) );
    }
}
?>
