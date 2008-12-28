<?php
/**
 * File containing the title handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit docbook section titles
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToEzXmlTitleHandler extends ezcDocumentElementVisitorHandler
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
        $header = $root->ownerDocument->createElement( 'header' );
        $root->appendChild( $header );

        if ( $node->hasAttribute( 'ID' ) )
        {
            $header->setAttribute( 'anchor_name', $node->getAttribute( 'ID' ) );
        }

        $converter->visitChildren( $node, $header );
        return $root;
    }
}

?>
