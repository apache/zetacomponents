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
 * Visit definition list entries
 *
 * Definition list entries are encapsulated in docbook, while the HTML
 * variant only consists of a list of terms and their description. This
 * method transforms the elements accordingly.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstDefinitionListEntryHandler extends ezcDocumentDocbookToRstBaseHandler
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
        foreach ( $node->childNodes as $child )
        {
            if ( ( $child->nodeType === XML_ELEMENT_NODE ) &&
                 ( ( $child->tagName === 'term' ) || 
                   ( $child->tagName === 'listitem' ) ) )
            {
                $entry = $root->ownerDocument->createElement( $child->tagName === 'term' ? 'dt' : 'dd' );
                $root->appendChild( $entry );
                $converter->visitChildren( $child, $entry );
            }
        }

        return $root;
    }
}

?>
