<?php
/**
 * File containing the ezcDocumentRstDangerTextRole class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for RST emphasis text roles
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRstEmphasisTextRole extends ezcDocumentRstTextRole implements ezcDocumentRstXhtmlTextRole
{
    /**
     * Transform text role to docbook
     *
     * Create a docbook XML structure at the text roles position in the
     * document.
     *
     * @param DOMDocument $document
     * @param DOMElement $root
     * @return void
     */
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $emphasis = $document->createElement( 'emphasis' );
        $root->appendChild( $emphasis );

        $this->appendText( $emphasis );
    }

    /**
     * Transform text role to HTML
     *
     * Create a XHTML structure at the text roles position in the document.
     *
     * @param DOMDocument $document
     * @param DOMElement $root
     * @return void
     */
    public function toXhtml( DOMDocument $document, DOMElement $root )
    {
        $emphasis = $document->createElement( 'em' );
        $root->appendChild( $emphasis );

        $this->appendText( $emphasis );
    }
}

?>
