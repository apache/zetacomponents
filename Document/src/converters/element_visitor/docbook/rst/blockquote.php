<?php
/**
 * File containing the ezcDocumentDocbookToRstBlockquoteHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit blockquotes
 *
 * Visit blockquotes and transform them their respective HTML elements,
 * including custom markup for attributions, as there is no defined element
 * in HTML for them.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstBlockquoteHandler extends ezcDocumentDocbookToRstBaseHandler
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
        // Locate optional attribution elements, and transform them below the
        // recursive quote visiting.
        $xpath = new DOMXPath( $node->ownerDocument );
        $attributionNodes = $xpath->query( '*[local-name() = "attribution"]', $node );
        $attributions = array();
        foreach ( $attributionNodes as $attribution )
        {
            $attributions[] = $attribution->cloneNode( true );
            $attribution->parentNode->removeChild( $attribution );
        }

        // Recursively decorate blockquote, after all attribution nodes are
        // removed
        ezcDocumentDocbookToRstConverter::$indentation += 4;
        $root = $converter->visitChildren( $node, $root );

        // Append attribution nodes, if any
        foreach ( $attributions as $attribution )
        {
            $attributionLine = '-- ' . trim( $converter->visitChildren( $attribution, '' ) );
            $root .= ezcDocumentDocbookToRstConverter::wordWrap( $attributionLine ) . "\n\n";
        }

        ezcDocumentDocbookToRstConverter::$indentation -= 4;
        return $root;
    }
}

?>
