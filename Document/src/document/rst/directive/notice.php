<?php
/**
 * File containing the ezcDocumentRstDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for RST tip directives
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRstNoticeDirective extends ezcDocumentRstDirective implements ezcDocumentRstXhtmlDirective
{
    /**
     * Transform directive to docbook
     *
     * Create a docbook XML structure at the directives position in the
     * document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $media = $document->createElement( 'tip', htmlspecialchars( $this->node->parameters ) );
        $root->appendChild( $media );
    }

    /**
     * Transform directive to HTML
     *
     * Create a XHTML structure at the directives position in the document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toXhtml( DOMDocument $document, DOMElement $root )
    {
        $note = $document->createElement( 'p', htmlspecialchars( $this->node->parameters ) );
        $note->setAttribute( 'class', 'notice' );
        $root->appendChild( $note );
    }
}

?>
