<?php
/**
 * An object that stubs the process of a normal method for a mock object.
 *
 * The stub object will replace the code for the stubbed method and return a
 * specific value instead of the original value.
 */
interface ezcMockStub extends ezcMockSelfDescribing
{
    /**
     * Fakes the processesing of the invocation $invocation by returning a
     * specific value.
     *
     * @return mixed
     * @param ezcMockInvocation $invocation The invocation which was mocked
     *                                      and matched by the current method
     *                                      and argument matchers.
     */
    public function invoke( ezcMockInvocation $invocation );
}
?>
