<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Records invocations and provides convenience methods for checking them later on.
 *
 * This abstract class can be implemented by matchers which needs to check the
 * number of times an invocation has occured.
 */
abstract class ezcMockInvokedRecorder implements ezcMockInvocationMatcher
{
    /**
     * Array of previous invocations.
     */
    private $invocations;

    /**
     * Initialises the matcher with an empty invocation list.
     */
    public function __construct()
    {
        $this->invocations = array();
    }

    /**
     * Returns the number of invocations it has recorded.
     * @return int
     */
    public function getInvocationCount()
    {
        return count( $this->invocations );
    }

    /**
     * Returns all recorded invocations.
     * @return array(ezcMockInvocation)
     */
    public function getInvocations()
    {
        return $this->invocations;
    }

    /**
     * Returns true if the matcher has been invoked at least once.
     * @return bool
     */
    public function hasBeenInvoked()
    {
        return count( $this->invocations ) > 0;
    }

    /**
     * Stores the invocation in the internal list which can be accessed with
     * getInvocations() and getInvocationCount().
     */
    public function invoked( ezcMockInvocation $invocation )
    {
        $this->invocations[] = $invocation;
    }

    /**
     * The invocation will always match.
     */
    public function matches( ezcMockInvocation $invocation )
    {
        return true;
    }
}
?>
