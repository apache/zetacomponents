<?php
/**
 * File containing the ezcDatabaseSchemaUnsupportedTypeException class
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if an unsupported field type is encountered.
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
class ezcDbSchemaUnsupportedTypeException extends ezcDbSchemaException
{
    /**
     * Constructs an ezcDatabaseSchemaUnsupportedTypeException for the type $type.
     *
     * @param string $dbType
     * @param string $type
     */
    function __construct( $dbType, $type )
    {
        parent::__construct( "The field type '{$type}' is not supported with the '{$dbType}' handler." );
    }
}
?>
