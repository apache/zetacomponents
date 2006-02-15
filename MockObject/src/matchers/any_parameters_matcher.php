<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Invocation matcher which allos any parameters to a method.
 *
 */
class ezcMockAnyParametersMatcher extends ezcMockStatelessInvocationMatcher
{
    /**
     * Initialises the matcher by calling parent clas.s
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function generateDescription()
    {
        return "with any parameters";
    }

    /**
     * Always matches since any parameters are allowed.
     */
    public function matches( ezcMockInvocation $invocation )
    {
        return true;
    }
}
?>
