<?php
/**
 * Builder interface for stubs which are actions replacing an invocation.
 */
interface ezcMockStubBuilder extends ezcMockIdentityBuilder
{
    /**
     * Stubs the matching method with the stub object $stub. Any invocations of
     * the matched method will now be handled by the stub instead.
     *
     * @param ezcMockStub $stub The stub object.
     * @return ezcMockIdentityBuilder
     */
    public function will( ezcMockStub $stub );
}
?>
