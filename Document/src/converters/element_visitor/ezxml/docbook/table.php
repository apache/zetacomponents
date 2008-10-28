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
 * Visit eZXml table
 *
 * Visit tables, which are quite similar to HTML tables and transform to
 * classic Docbook tables.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookTableHandler extends ezcDocumentElementVisitorHandler
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
        $element = $root->ownerDocument->createElement( 'table' );
        $root->appendChild( $element );

        // Handle attributes

        // Recurse
        $converter->visitChildren( $node, $element );
        return $root;
    }
}

?>
