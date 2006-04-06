<?php
/**
 * File containing the ezcDbSchemaInvalidDiffReaderClassException class
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if an invalid class is passed as schema difference reader to the manager.
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
class ezcDbSchemaInvalidDiffReaderClassException extends ezcDbSchemaException
{
    function __construct( $readerClass )
    {
        parent::__construct( "Class <{$readerClass}> does not exist, or does not implement the <ezcDbSchemaDiffReader> interface." );
    }
}
?>
