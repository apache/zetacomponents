<?php
/**
 * File containing the ezcDbSchemaHandlerMysql class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Handler for MySQL databases and SQL files.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcDbSchemaHandlerMysql extends ezcDbSchemaHandler
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
        return array( 'mysql-db', 'mysql-file' );
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