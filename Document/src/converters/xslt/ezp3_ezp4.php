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
class ezcDocumentEzp3ToEzp4Converter extends ezcDocumentXsltConverter
{

    /**
     * Construct new document
     *
     * @param ezcDocumentEzp3ToEzp4ConverterOptions $options
     */
    public function __construct( ezcDocumentEzp3ToEzp4ConverterOptions $options = null )
    {
        $this->options = ( $options === null ?
            new ezcDocumentEzp3ToEzp4ConverterOptions() :
            $options );

        // Define the conversion file to use.
        parent::__construct( dirname( __FILE__ ) . '/ezp3_ezp4.xsl' );
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
        // Create XSLT processor, if not yet initialized
        if ( $this->xsltProcessor === null )
        {
            $stylesheet = new DOMDocument();
            $stylesheet->load( $this->xslt );

            $this->xsltProcessor = new XSLTProcessor();
            $this->xsltProcessor->importStyleSheet( $stylesheet );
            $this->xsltProcessor->registerPHPFunctions();
        }

        // Update list with custom static tags, to make option available for
        // static call from template
        self::$customInlineTags = $this->options->customInlineTags;

        // Transform input document
        $document = $this->xsltProcessor->transformToDoc( $doc->getDomDocument() );

        // Create destination document from DOMDocument
        $dest = new ezcDocumentEzp4Xml();
        $dest->loadDomDocument( $document );
        return $dest;
    }

    /**
     * Prepare expression for XSLT
     *
     * Prepare a or concatenation of name matches as an XPath query for the
     * XSLT stylesheet from the configured custom inline tags.
     * 
     * @return string
     */
    public static function getCustomInlineTags()
    {
        $tagList = '';
        foreach ( self::$customInlineTags as $tag )
        {
            $tagList .= "@name = '$tag' OR ";
        }

        return substr( $tagList, 0, -4 );
    }
}

?>
