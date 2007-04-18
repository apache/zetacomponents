<?php

/**
 * Interface for ezcConsoleMenuDialog validator classes. 
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
