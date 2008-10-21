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
 * Visit external links
 *
 * Transform external docbook links (<ulink>) to common HTML links.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToWikiExternalLinkHandler extends ezcDocumentDocbookToWikiBaseHandler
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
        $root .= ' [[' . $node->getAttribute( 'url' ) . '|' . $converter->visitChildren( $node, '' ) . ']]';
        return $root;
    }
}

?>
