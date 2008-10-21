<?php

/**
 * File containing the ezcDocumentDocbookElementVisitorConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit paragraphs
 *
 * Visit docbook paragraphs and transform them into HTML paragraphs.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToWikiParagraphHandler extends ezcDocumentDocbookToWikiBaseHandler
{
    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     * 
     * @param ezcDocumentDocbookElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    public function handle( ezcDocumentDocbookElementVisitorConverter $converter, DOMElement $node, $root )
    {
        // Visit paragraph contents
        $contents = $converter->visitChildren( $node, '' );

        // Remove all line breaks inside the paragraph.
        $contents = trim( preg_replace( '(\s+)', ' ', $contents ) );
        $root .= ezcDocumentDocbookToWikiConverter::wordWrap( $contents ) . "\n\n";

        return $root;
    }
}

?>
