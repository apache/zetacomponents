<?php
/**
 * File containing the ezcDocumentRstNoteDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for RST note directives
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRstNoteDirective extends ezcDocumentRstDirective implements ezcDocumentRstXhtmlDirective
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
        $note = $document->createElement( 'note' );
        $root->appendChild( $note );

        $paragraph = $document->createElement( 'para' );
        $note->appendChild( $paragraph );

        $paragraph->appendChild( new DOMText( $this->node->parameters ) );
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
        $note->setAttribute( 'class', 'note' );
        $root->appendChild( $note );
    }
}

?>
