<?php
/**
 * File containing the ezcDbSchemaFileWriter interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for database schema writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDbWriter
{
    public function getWriterType();
    public function saveToDb( ezcDbHandler $db, ezcDbSchema $schema );
}
?>
