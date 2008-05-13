<?php
/**
 * File containing the ezcDbSchemaCommonSqlReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An abstract class that implements some common functionality required by
 * multiple database backends.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
abstract class ezcDbSchemaCommonSqlReader implements ezcDbSchemaDbReader
{
    /**
     * Returns an ezcDbSchema created from the database schema in the database referenced by $db
     *
     * This method analyses the current database referenced by $db and creates
     * a schema definition out of this. This schema definition is returned as
     * an (@link ezcDbSchema) object.
     *
     * @param ezcDbHandler $db
     * @return ezcDbSchema
     */
    public function loadFromDb( ezcDbHandler $db )
    {
        $this->db = $db;
        return new ezcDbSchema( $this->fetchSchema() );
    }

    /**
     * Returns what type of schema reader this class implements.
     *
     * This method always returns ezcDbSchema::DATABASE
     *
     * @return int
     */
    public function getReaderType()
    {
        return ezcDbSchema::DATABASE;
    }
}
?>
