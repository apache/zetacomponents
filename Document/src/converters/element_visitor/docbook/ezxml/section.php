<?php
/**
 * File containing the section handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit docbook sections
 *
 * Updates the docbook sections, which give us information about the depth
 * in the document, and may also be reference targets.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToEzXmlSectionHandler extends ezcDocumentElementVisitorHandler
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
        $section = $root->ownerDocument->createElement( 'section' );
        $root->appendChild( $section );

        // Set internal cross reference target if section has an ID assigned
        if ( $node->hasAttribute( 'id' ) )
        {
            // $section->setAttribute( 'anchor_name', $node->getAttribute( 'id' ) );
        }

        // Recurse
        $converter->visitChildren( $node, $section );
        return $root;
    }
}

?>
