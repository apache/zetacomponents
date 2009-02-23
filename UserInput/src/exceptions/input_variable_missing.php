<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when a required input field is missing.
 *
 * @package UserInput
 * @version //autogen//
 */
class ezcInputFormVariableMissingException extends ezcInputFormException
{
    /**
     * Constructs a new ezcInputFormVariableMissingException.
     *
     * @param string $fieldName
     * @return void
     */
    function __construct( $fieldName )
    {
        parent::__construct( "Required input field '{$fieldName}' missing." );
    }
}
?>
