<?php
/**
 * File containing the ezcDocumentXhtmlTextToParagraphFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml table cells.
 *
 * Tables, where the rows are nor structured into a tbody and thead are
 * restructured into those by this filter.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlTextToParagraphFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $aggregated = array();
        $processed  = array();
        for ( $i = ( $element->childNodes->length - 1 ); $i >= 0; --$i )
        {
            // Get type of current row, or set row type to null, if it is no
            // table row.
            $child   = $element->childNodes->item( $i );
            $childNr = $i;

            // There are three different actions, which need to be performed in
            // this loop:
            //  - Skip irrelevant nodes (whitespaces)
            //  - Aggregate text and inline nodes
            //  - Move text nodes to new paragraph nodes.
            if ( ( count( $aggregated ) ) &&
                   ( ( $i <= 0 ) ||
                     ( !$this->isInlineElement( $child ) ) ) )
            {
                // We only create a new paragraph node around the aggregated
                // elements, if they contain at least one text node, which does
                // not only consists of whitespaces.
                $wrap = false;
                foreach ( $aggregated as $node )
                {
                    $wrap |= (
                        ( $node->nodeType === XML_TEXT_NODE ) &&
                        ( trim( $node->wholeText ) !== '' )
                    );
                }

                if ( $wrap )
                {
                    // Move nodes to new subnode
                    $lastNode = end( $aggregated );
                    $newNode = new ezcDocumentXhtmlDomElement( 'p' );
                    $child->parentNode->insertBefore( $newNode, $lastNode );
                    $newNode->setProperty( 'type', 'para' );

                    // Append all aggregated nodes
                    foreach ( $aggregated as $node )
                    {
                        $cloned = $node->cloneNode( true );
                        $newNode->appendChild( $cloned );
                        $child->parentNode->removeChild( $node );
                    }

                    // Clean up
                    $aggregated = array();

                    // Maybe we need to handle the current element again.
                    ++$i;
                }
            }

            if ( ( $child->nodeType !== XML_ELEMENT_NODE ) &&
                 ( $child->nodeType !== XML_TEXT_NODE ) &&
                 ( $child->nodeType !== XML_COMMENT_NODE ) )
            {
                $child->parentNode->removeChild( $child );
                continue;
            }
            elseif ( $this->isInlineElement( $child ) &&
                     ( !isset( $processed[$childNr] ) ) )
            {
                // Aggregate nodes
                $aggregated[]        = $child;
                $processed[$childNr] = true;
            }
        }
    }

    /**
     * Check if filter handles the current element
     *
     * Returns a boolean value, indicating weather this filter can handle
     * the current element.
     *
     * @param DOMElement $element
     * @return void
     */
    public function handles( DOMElement $element )
    {
        return ( $element->tagName !== 'p' ) &&
               $this->isBlockLevelElement( $element );
    }
}

?>
