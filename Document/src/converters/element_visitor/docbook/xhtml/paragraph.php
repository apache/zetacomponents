<?php
/**
 * File containing the ezcDocumentDocbookToHtmlParagraphHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcDocumentDocbookToHtmlParagraphHandler extends ezcDocumentDocbookToHtmlBaseHandler
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
        // Do not stack paragraphs
        if ( $root->tagName !== 'p' )
        {
            $paragraph = $root->ownerDocument->createElement( 'p' );
            $root->appendChild( $paragraph );
            $converter->visitChildren( $node, $paragraph );
        }
        else
        {
            $converter->visitChildren( $node, $root );
        }

        return $root;
    }
}

?>
