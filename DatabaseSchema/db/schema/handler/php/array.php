<?php
/**
 * File containing the ezcDbSchemaHandlerPhpArray class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Handler for files containing PHP arrays that represent DB schema.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcDbSchemaHandlerPhpArray extends ezcDbSchemaHandler
{
    public function __construct( $params )
    {
        parent::__construct( $params );
    }

    /**
     * \reimp
     *
     * This handler supports saving/loading schema
     * to/from XML files.
     */
    public function getSupportedSchemaTypes()
    {
        return array( 'php-file' );
    }

    /**
     * \reimp
     *
     * Load schema from an .xml file.
     */
    public function loadSchema( $src )
    {
    }

    /**
     * \reimp
     *
     * save schema to an .xml file
     */
    public function saveSchema( $schema, $dst )
    {
    }

    /**
     * \reimp
     *
     * Save difference between schemas to file
     */
    public function saveDelta ( $delta, $dst )
    {
    }
}

?>