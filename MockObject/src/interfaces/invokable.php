<?php
/**
 * Interface for classes which can be invoked.
 *
 * The invocation will be taken from a mock object and passed to an object
 * of this class.
 */
interface ezcMockInvokable extends ezcMockVerifiable
{
    /**
     * Invokes the invocation object $invocation so that it can be checked for
     * expectations or matched against stubs.
     *
     * @return Object
     * @param ezcMockInvocation $invocation The invocation object passed from
     *                                      mock object.
     */
    public function invoke( ezcMockInvocation $invocation );

    /**
     * Checks if the invocation matches.
     *
     * @return bool
     * @param ezcMockInvocation $invocation The invocation object passed from
     *                                      mock object.
     */
    public function matches( ezcMockInvocation $invocation );
}
?>
