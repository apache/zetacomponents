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
 * Visit eZXml table row
 *
 * Visit tables, which are quite similar to HTML tables and transform to
 * classic Docbook tables.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookTableRowHandler extends ezcDocumentElementVisitorHandler
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
        $element = $root->ownerDocument->createElement( 'row' );

        // Handle attributes
        $xpath = new DOMXPath( $node->ownerDocument );
        $isHeader = (bool) $xpath->query( './*[local-name() = "th"]', $node )->length;

        if ( $root->tagName === 'table' ) 
        {
            $tablePart = $root->ownerDocument->createElement( $isHeader ? 'thead' : 'tbody' );
            $root->appendChild( $tablePart );
            $root = $tablePart;
        }
        elseif ( $root->tagName !== ( $isHeader ? 'thead' : 'tbody' ) )
        {
            $tablePart = $root->ownerDocument->createElement( $isHeader ? 'thead' : 'tbody' );
            $root->parentNode->appendChild( $tablePart );
            $root = $tablePart;
        }

        $root->appendChild( $element );

        // Recurse
        $converter->visitChildren( $node, $element );
        return $root;
    }
}

?>
