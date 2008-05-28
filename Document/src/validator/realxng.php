<?php
/**
 * File containing the ezcDocumentRelaxNgValidator class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * A tool class used by the XML based documents to validate their tree against
 * a RelaxNG schema.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRelaxNgValidator
{
    /**
     * Construct validator from schema
     * 
     * @param string $schema 
     * @return void
     */
    public function __construct( $schema )
    {
        $this->schemaFile = $schema;
    }

    /**
     * Set handler for format
     *
     * Set the format handler for $format to the specified handler class, which
     * should extend from ezcDocument.
     * 
     * @param DOMDocument $document
     * @return void
     */
    public static function validateDomDocument( DOMDocument $document )
    {
        // @TODO: Implement
    }
}
?>
