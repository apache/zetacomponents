<?php
/**
 * File containing the ezcConsoleMenuDialogValidator interface.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface that every console menu dialog validator class must implement.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
interface ezcConsoleMenuDialogValidator extends ezcConsoleQuestionDialogValidator
{

    /**
     * Returns an array of the elements to display. 
     * 
     * @return array(string=>string) Elements to display.
     */
    public function getElements();

}

?>
