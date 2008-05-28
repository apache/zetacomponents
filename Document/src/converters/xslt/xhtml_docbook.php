<?php
/**
 * File containing the ezcDocumentEzp3ToEzp4Converter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Converter for eZ Publish 3 document to eZ Publish 4 documents.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentXhtmlToDocbookConverter extends ezcDocumentXsltConverter
{
    /**
     * Construct converter
     *
     * @return void
     */
    public function __construct()
    {
        // Define the conversion file to use.
        parent::__construct( dirname( __FILE__ ) . '/xhtml_docbook.xsl' );
    }

    /**
     * Convert documents between two formats
     * 
     * Convert documents of the given type to the requested type.
     *
     * @param ezcDocumentXmlBase $doc 
     * @return ezcDocumentXmlBase
     */
    public function convert( $doc )
    {
        $document = parent::convert( $doc );

        // Create destination document from DOMDocument
        $dest = new ezcDocumentDocbook();
        $dest->loadDomDocument( $document );
        return $dest;
    }
}

?>
