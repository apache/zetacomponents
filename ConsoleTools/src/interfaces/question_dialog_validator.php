<?php

interface ezcConsoleQuestionDialogValidator extends ezcConsoleDialogValidator
{

    /**
     * Returns a string of possible results to be displayed with the question. 
     * For example "(y/n) [y]" to indicate "y" and "n" are valid values and "y" is
     * preselected.
     *
     * @return string The result string.
     */
    public function getResultString();
}

?>
