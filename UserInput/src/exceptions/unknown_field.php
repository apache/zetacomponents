<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when a fieldname is used that was not defined in a definition array.
 *
 * @package UserInput
 * @version //autogen//
 */
class ezcInputFormUnknownFieldException extends ezcInputFormException
{
    /**
     * Constructs a new ezcInputFormUnknownFieldException.
     *
     * @param string $fieldName
     * @return void
     */
    function __construct( $fieldName )
    {
        parent::__construct( "The field '{$fieldName}' is not defined." );
    }
}
?>
