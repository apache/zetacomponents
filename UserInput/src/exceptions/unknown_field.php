<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
    function __construct( $fieldName )
    {
        parent::__construct( "The field '{$fieldName}' is not defined." );
    }
}
?>
