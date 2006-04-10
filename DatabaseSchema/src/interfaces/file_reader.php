<?php
/**
 * File containing the ezcDbSchemaFileReader interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for database schema readers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaFileReader extends ezcDbSchemaReader
{
    public function loadFromFile( $file );
}
?>
