<?php

/**
 * File containing the ezcDocumentXsltConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for conversions between XML documents using XSLT.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentXsltConverter extends ezcDocumentConverter
{
    /**
     * Path to XSLT transformation file
     * 
     * @var string
     */
    protected $xslt;

    /**
     * XSLT processor created from the defined XSLT file.
     * 
     * @var XSLTProcessor
     */
    protected $xsltProcessor = null;

    /**
     * Array with custom inline tags, as a storage for static calls from the
     * template.
     *
     * @var array
     */
    protected static $customInlineTags;

    /**
     * Construct converter
     *
     * Construct converter from XSLT file, which is used for the actual
     * conversion.
     * 
     * @param string $xslt 
     * @return void
     */
    public function __construct( $xslt )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            throw new ezcBaseExtensionNotFoundException( 'xsl' );
        }

        if ( !file_exists( $xslt ) || !is_readable( $xslt ) )
        {
            throw new ezcBaseFileNotFoundException( $xslt );
        }

        $this->xslt = $xslt;
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
        }

        // Transform input document
        return $this->xsltProcessor->transformToDoc( $doc->getDomDocument() );
    }
}

?>
