<?php
/**
 * File containing the ezcDocumentPdfTextBoxRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Renders a list
 *
 * Tries to render a list into the available space, and aborts if
 * not possible.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfBlockquoteRenderer extends ezcDocumentPdfBlockRenderer
{
    /**
     * Process to render block contents
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    protected function process( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        $childNodes   = $block->childNodes;
        $nodeCount    = $childNodes->length;
        $attributions = array();

        for ( $i = 0; $i < $nodeCount; ++$i )
        {
            $child = $childNodes->item( $i );
            if ( $child->nodeType !== XML_ELEMENT_NODE )
            {
                continue;
            }

            // Default to docbook namespace, if no namespace is defined
            $namespace = $child->namespaceURI === null ? 'http://docbook.org/ns/docbook' : $child->namespaceURI;
            if ( ( $namespace === 'http://docbook.org/ns/docbook' ) &&
                 ( $child->tagName === 'attribution' ) )
            {
                $attributions[] = $child;
                continue;
            }

            $mainRenderer->processNode( $child );
        }

        // Render attributions below the actual quotes
        $textRenderer = new ezcDocumentPdfTextBoxRenderer( $this->driver, $this->styles );
        foreach ( $attributions as $attribution )
        {
            $textRenderer->render( $page, $hyphenator, $tokenizer, $attribution, $mainRenderer );
        }
    }
}

?>
