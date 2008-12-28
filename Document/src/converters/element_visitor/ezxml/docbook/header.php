<?php
/**
 * File containing the document header handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit eZXml header
 *
 * Visit the eZXml header, maintaining as much informatio as possible with
 * docbook, especially maintain anchor information.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookHeaderHandler extends ezcDocumentElementVisitorHandler
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
        $element = $root->ownerDocument->createElement( 'title' );
        $root->appendChild( $element );

        if ( $node->hasAttribute( 'anchor_name' ) )
        {
            $element->setAttribute( 'ID', $node->getAttribute( 'anchor_name' ) );
        }

        // Recurse
        $converter->visitChildren( $node, $element );
        return $root;
    }
}

?>
