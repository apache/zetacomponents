<?php
/**
 * File containing the ezcConsoleQuestionDialogValidator class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

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
