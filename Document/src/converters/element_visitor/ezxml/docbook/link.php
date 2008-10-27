<?php

/**
 * File containing the ezcDocumentElementVisitorConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit links
 *
 * Transform links, internal or external, into the appropriate docbook markup.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookLinkHandler extends ezcDocumentEzXmlToDocbookBaseHandler
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
        if ( $node->hasAttribute( 'anchor_name' ) )
        {
            // This is an internal reference
            $link = $root->ownerDocument->createElement( 'link' );
            $link->setAttribute( 'linked', $node->getAttribute( 'anchor_name' ) );
            $root->appendChild( $link );
        }

        $converter->visitChildren( $node, $link );
        return $root;
    }
}

?>
