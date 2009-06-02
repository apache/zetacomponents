<?php
/**
 * File containing the footnote handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit footnotes
 *
 * Footnotes in docbook are emebdded at the position, the reference should
 * occur. We store the contents, to be rendered at the end of the HTML
 * document, and only render a number referencing the actual footnote at
 * the position of the footnote in the docbook document.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToHtmlFootnoteHandler extends ezcDocumentDocbookToHtmlBaseHandler
{
    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     *
     * @param ezcDocumentElementVisitorConverter $converter
     * @param DOMElement $node
     * @param mixed $root
     * @return mixed
     */
    public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $number = $converter->appendFootnote( $node->cloneNode( true ) );

        $footnoteReference = $root->ownerDocument->createElement( 'a', $number );
        $footnoteReference->setAttribute( 'class', 'footnote' );
        $footnoteReference->setAttribute( 'href', '#__footnote_' . $number );
        $root->appendChild( $footnoteReference );

        return $root;
    }
}

?>
