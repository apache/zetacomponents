<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which checks if a method was invoked at a certain index.
 *
 * If the expected index number does not match the current invocation index it
 * will not match which means it skips all method and parameter matching. Only
 * once the index is reached will the method and parameter start matching and
 * verifying.
 *
 * If the index is never reached it will throw an exception in index.
 */
class ezcMockInvokedAtIndexMatcher implements ezcMockInvocationMatcher
{
    /**
     * The expected number of times the method should be invoked.
     */
    private $sequenceIndex;

    /**
     * The current invocation index.
     */
    private $currentIndex;

    /**
     * Initialises the matcher with the sequence index it should check invocations.
     * @note The first sequence index is 0.
     * @param int $sequenceIndex The index number the invocation is expected at.
     */
    public function __construct( $sequenceIndex )
    {
        $this->sequenceIndex = $sequenceIndex;
        $this->currentIndex = -1;
    }

    public function generateDescription()
    {
        return "invoked at sequence index {$this->sequenceIndex}";
    }

    /**
     * The invocation will match as soon as the correct index is found.
     */
    public function matches( ezcMockInvocation $invocation )
    {
        ++$this->currentIndex;
        return $this->currentIndex == $this->sequenceIndex;
    }

    /**
     * Does nothing special.
     */
    public function invoked( ezcMockInvocation $invocation )
    {
    }

    /**
     * Verifies that the expected invocation index has occured, if not throw
     * an exception.
     */
    public function verify( )
    {
        if ( $this->currentIndex < $this->sequenceIndex )
            throw new ezcMockExpectationFailedException( "The expected invocation at index {$this->sequenceIndex} was never reached.",
                                                         new ezcMockScalarDiff( $this->sequenceIndex, $this->currentIndex ) );
    }
}
?>
