<?php
/**
 * File containing the ezcXMLDBSchemaHandler class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Handler for XML files.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcXMLDBSchemaHandler extends ezcDBSchemaHandler
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
        return array( 'xml-file' );
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