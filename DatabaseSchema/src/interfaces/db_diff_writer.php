<?php
/**
 * File containing the ezcDbSchemaDbDiffWriter interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for database schema difference writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffDbWriter extends ezcDbSchemaDiffWriter
{
    public function applyDiffToDb( ezcDbHandler $db, ezcDbSchemaDiff $schemaDiff );
    public function convertDiffToDDL( ezcDbSchemaDiff $schemaDiff );
}
?>
