<?php

/**
 * Interface for input validators used in ezcConsoleInput.
 *
 * An instance of this interface is used in {@link ezcConsoleInput} to validate 
 * options and arguments.
 * 
 * @package ConsoleTools
 * @version //autogen//
 *
 * @access private
 * @TODO Verify interface and make it public to replace the validation in 
 *       {@link ezcConsoleInput}.
 */
interface ezcConsoleInputValidator
{
    /**
     * Validates the given options.
     *
     * May throw an exception that derives from {@link ezcConsoleException}.  
     * Receives the array of $options defined for validation and $hasArguments 
     * to indicates if arguments have been submitted in addition.
     *
     * @param array(ezcConsoleOption) $options
     * @param bool $hasArguments
     */
    public function validateOptions( array $options, $hasArguments );

    // @TODO: validateArguments();
}

?>
