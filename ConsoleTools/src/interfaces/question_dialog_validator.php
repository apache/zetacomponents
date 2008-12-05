<?php
/**
 * File containing the ezcConsoleQuestionDialogValidator interface.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface that every console question dialog validator class must implement.
 *
 * @package ConsoleTools
 * @version //autogen//
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
