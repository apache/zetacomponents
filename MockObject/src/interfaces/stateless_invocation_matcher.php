<?php
/**
 * Invocation matcher which does not care about previous state from earlier invocations.
 *
 * This abstract class can be implemented by matchers which does not care about
 * state but only the current run-time value of the invocation itself.
 */
abstract class ezcMockStatelessInvocationMatcher implements ezcMockInvocationMatcher
{
    /**
     * Initialise the matcher with no partical parameters.
     */
    public function __construct()
    {
    }

    public function invoked( ezcMockInvocation $invocation )
    {
    }

    public function verify()
    {
    }
}
?>
