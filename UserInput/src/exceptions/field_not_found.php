<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when a specified field is not found
 *
 * @package UserInput
 * @version //autogen//
 */
class ezcInputFormFieldNotFoundException extends ezcInputFormException
{
    /**
     * Constructs a new ezcInputFormFieldNotFoundException.
     *
     * @param string $fieldName
     * @return void
     */
    function __construct( $fieldName )
    {
        parent::__construct( "The field '{$fieldName}' could not be found in the input source." );
    }
}
?>
