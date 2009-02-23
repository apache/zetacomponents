<?php
/**
 * File containing the ezcDbSchemaDiffReader interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for database schema difference readers
 *
 * This interface is extended by a specific interface for schema difference
 * writers which read the difference from a file (@link
 * ezcDbSchemaDiffFileReader).
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffReader
{
    /**
     * Returns what type of schema difference reader this class implements.
     *
     * Depending on the class it either returns ezcDbSchema::DATABASE (for
     * reader that read difference information from a database) or
     * ezcDbSchema::FILE (for readers that read difference information from a
     * file).
     *
     * Because there is no way of storing differences in a database, the
     * effective return value of this method will always be ezcDbSchema::FILE.
     *
     * @return int
     */
    public function getDiffReaderType();
}
?>
