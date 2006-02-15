<?php
/**
 * Defines the interface for classes that can return a description of itself.
 */
interface ezcMockSelfDescribing
{
    /**
     * Generates the description for the current object and returns it.
     *
     * @note The description should not include periods to end the sentence.
     * @return string
     */
    public function generateDescription();
}
?>
