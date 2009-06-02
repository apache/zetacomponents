<?php
/**
 * File containing the non decorating recursing handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for elements, which are safe to ignore, but into which contents
 * should be recursed, so the childs are still converted.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstRecurseHandler extends ezcDocumentElementVisitorHandler
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
        return $converter->visitChildren( $node, $root );
    }
}

?>
