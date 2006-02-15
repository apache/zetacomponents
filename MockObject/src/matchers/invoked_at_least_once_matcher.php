<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which checks if a method has been invoked at least one time.
 *
 * if the number of invocations is 0 it will throw an exception in verify.
 */
class ezcMockInvokedAtLeastOnceMatcher extends ezcMockInvokedRecorder
{
    /**
     * Initialises the matcher.
     */
    public function __construct()
    {
    }

    public function generateDescription()
    {
        return "invoke at least once";
    }

    /**
     * Checks if any invocations has been done, if not it throws an exception.
     */
    public function verify( )
    {
        $count = $this->getInvocationCount();
        if ( $count < 1 )
            throw new ezcMockExpectationFailedException( "Expected invocation at least once but it never occured." );
    }
}
?>
