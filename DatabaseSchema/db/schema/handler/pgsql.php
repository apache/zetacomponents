<?php
/**
 * File containing the ezcPgSQLDBSchemaHandler class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Handler for PostgreSQL databases and SQL files.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcPgSQLDBSchemaHandler extends ezcDbSchemaHandler
{
    public function __construct( $params )
    {
        parent::__construct( $params );
    }

    /**
     * \reimp
     *
     * This handler supports saving/loading schema
     * to/from DB and saving to SQL files.
     */
    public function getSupportedSchemaTypes()
    {
        return array( 'pgsql-db', 'pgsql-file' );
    }

    /**
     * \reimp
     *
     *  Loads schema from a database, applying given hooks.
     */
    public function loadSchema( $src )
    {
    }

    /**
     * \reimp
     *
     * Saves schema to an SQL file, applying given hooks.
     */
    public function saveSchema( $schema, $dst )
    {
    }

    /**
     * \reimp
     *
     * Saves difference between schemas to an SQL file.
     */
    public function saveDelta ( $delta, $dst )
    {
    }
}

?>