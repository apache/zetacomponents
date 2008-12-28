<?php
/**
 * File containing the anchor handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit anchor elements
 *
 * Anchor elements are manually added targets inside paragraphs.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookAnchorHandler extends ezcDocumentElementVisitorHandler
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
        $anchor = $root->ownerDocument->createElement( 'anchor' );
        $anchor->setAttribute( 'ID', $node->getAttribute( 'name' ) );
        $root->appendChild( $anchor );

        $converter->visitChildren( $node, $anchor );
        return $root;
    }
}

?>
