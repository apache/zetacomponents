<?php
/**
 * File containing the ezcDocumentWiki class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Document handler for Dokuwiki wiki text documents.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDokuwikiWiki extends ezcDocumentWiki
{
    /**
     * Construct RST document.
     * 
     * @ignore
     * @param ezcDocumentWikiOptions $options
     * @return void
     */
    public function __construct( ezcDocumentWikiOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentWikiOptions() :
            $options );

        $this->options->tokenizer = new ezcDocumentWikiDokuwikiTokenizer();
    }

    /**
     * Create document from docbook document
     *
     * A document of the docbook format is provided and the internal document
     * structure should be created out of this.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     * 
     * @param ezcDocumentDocbook $document 
     * @return void
     */
    public function createFromDocbook( ezcDocumentDocbook $document )
    {
        throw new ezcDocumentMissingVisitorException( get_class( $document ) );
    }
}

?>
