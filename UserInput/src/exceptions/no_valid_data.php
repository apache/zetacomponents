<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
    /**
     * Constructs a new ezcInputFormNoValidDataException.
     *
     * @param string $fieldName
     * @return void
     */
    function __construct( $fieldName )
    {
        parent::__construct( "Invalid field name '{$fieldName}' requested." );
    }
}
?>
