<?php
/**
 * Interface for classes which must verify a given expectation.
 */
interface ezcMockVerifiable
{
    /**
     * Verifies that the current expectation is valid. If everything is OK the
     * code should just return, if not it must throw an exception.
     *
     * @throw ezcMockExpectationFailedException
     */
    public function verify();
}
?>
