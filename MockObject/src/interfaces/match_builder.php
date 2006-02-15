<?php
/**
 * Builder interface for invocation order matches.
 */
interface ezcMockMatchBuilder extends ezcMockStubBuilder
{
    /**
     * Defines the expectation which must occur before the current is valid.
     *
     * @param string $id The identification of the expectation that should
     *                   occur before this one.
     * @return ezcTestMockStubBuilder
     */
    public function after( $id );
}
?>
