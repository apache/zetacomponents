<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when an invalid field name is requested.
 *
 * @package UserInput
 * @version //autogen//
 */
class ezcInputFormNoValidDataException extends ezcInputFormException
{
    function __construct( $fieldName )
    {
        parent::__construct( "Invalid field name <{$fieldName}> requested." );
    }
}
?>
