<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
    function __construct( $fieldName )
    {
        parent::__construct( "Required input field <{$fieldName}> missing." );
    }
}
?>
