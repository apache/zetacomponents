<?php
/**
 * File containing the rst XHtml text role interface
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for text roles also supporting HTML output
 * 
 * @package Document
 * @version //autogen//
 */
interface ezcDocumentRstXhtmlTextRole
{
    /**
     * Transform text role to HTML
     *
     * Create a XHTML structure at the text roles position in the document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toXhtml( DOMDocument $document, DOMElement $root );
}

?>
