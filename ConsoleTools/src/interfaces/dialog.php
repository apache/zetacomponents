<?php

/**
 * Interface that every console dialog class must implement.
 * Console dialogs can either be used on their own or using the
 * {@see ezcConsoleDialogViewer} (recommended). In the dialog viewer, a dialog
 * is instanciated and displayed in a loop, until it receives a valid result
 * value.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcConsoleDialog
{

    const TYPE_STRING   = "%s";
    const TYPE_INT      = "%d";
    const TYPE_FLOAT    = "%f";

    /**
     * Create a new dialog object.
     * This method retrieves an ezcConsoleOutput object for printing its
     * content.
     * 
     * @param ezcConsoleOutput $output Output object.
     * @return void
     */
    public function __construct( ezcConsoleOutput $output, ezcConsoleDialogOptions $options = null );

    /**
     * Returns if the dialog retrieved a valid result.
     * Dialogs are displayed in a loop until they return true here.
     * 
     * @return bool If a valid result was retrieved.
     */
    public function hasValidResult();

    /**
     * Returns the result retrieved.
     * If no valid result was retreived, yet, this method should throw an
     * ezcDialogNoValidResultException.
     * 
     * @return mixed The retreived result.
     */
    public function getResult();

    /**
     * Show the dialog.
     * Display the dialog and retreive the desired answer from the user.
     * 
     * @return void
     */
    public function display();

    /**
     * Resets the dialog to its initial state. 
     * 
     * @return void
     */
    public function reset();
}

?>
