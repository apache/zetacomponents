<?php
/**
 * Interface for collections of stubs and expectations.
 */
interface ezcMockStubMatchersCollection
{
    /**
     * Adds a new matcher to the collection which can be used as an expectation
     * or a stub.
     *
     * @param ezcMockInvocationMatcher $matcher Matcher for invocations to mock objects.
     */
    public function addMatcher( ezcMockInvocationMatcher $matcher );
}
?>
