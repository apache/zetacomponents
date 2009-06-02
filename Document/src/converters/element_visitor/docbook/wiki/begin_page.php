<?php
/**
 * File containing the page break handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit begin page elements
 *
 * Begin page elements are used for page breaks.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToWikiBeginPageHandler extends ezcDocumentDocbookToWikiBaseHandler
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
        $root .= "\n----\n\n";
        return $root;
    }
}

?>
