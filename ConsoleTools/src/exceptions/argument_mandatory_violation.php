<?php
/**
 * File containing the ezcConsoleArgumentMandatoryViolationException.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An argument was marked to be mandatory but was not submitted.
 * This exception can be caught using {@link ezcConsoleArgumentException}.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleArgumentMandatoryViolationException extends ezcConsoleArgumentException
{

    /**
     * Creates a new exception object. 
     * 
     * @param ezcConsoleArgument $arg The argument object, the violation occured for.
     * @return void
     */
    public function __construct( ezcConsoleArgument $arg )
    {
        parent::__construct( "Argument with name '{$arg->name}' is mandatory but was not submitted." );
    }
}

?>
