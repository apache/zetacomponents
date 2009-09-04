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
class ezcDocumentPdfListRenderer extends ezcDocumentPdfBlockRenderer
{
    /**
     * Process to render block contents
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    protected function process( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentPdfInferencableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        $childNodes = $block->childNodes;
        $nodeCount  = $childNodes->length;
        $listItem   = 1;

        $itemGenerator = $this->getListItemGenerator( $block );

        for ( $i = 0; $i < $nodeCount; ++$i )
        {
            $child = $childNodes->item( $i );
            if ( $child->nodeType !== XML_ELEMENT_NODE )
            {
                continue;
            }

            // Default to docbook namespace, if no namespace is defined
            $namespace = $child->namespaceURI === null ? 'http://docbook.org/ns/docbook' : $child->namespaceURI;
            if ( ( $namespace !== 'http://docbook.org/ns/docbook' ) ||
                 ( $child->tagName !== 'listitem' ) )
            {
                continue;
            }

            $renderer = new ezcDocumentPdfListItemRenderer( $this->driver, $this->styles, $itemGenerator, $listItem++ );
            $renderer->render( $page, $hyphenator, $tokenizer, $child, $mainRenderer );
        }
    }

    /**
     * Get list item generator
     *
     * Get list item generator for the list generator.
     * 
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @return ezcDocumentListItemGenerator
     */
    protected function getListItemGenerator( ezcDocumentPdfInferencableDomElement $block )
    {
        switch ( $block->tagName )
        {
            case 'itemizedlist':
                // @TODO: Select based on some configuration
                return new ezcDocumentBulletListItemGenerator();
            case 'orderedlist':
                if ( !$block->hasAttribute( 'numeration' ) )
                {
                    return new ezcDocumentNumberedListItemGenerator();
                }

                switch ( $block->getAttribute( 'numeration' ) )
                {
                    case 'arabic':
                        return new ezcDocumentNumberedListItemGenerator();
                    case 'loweralpha':
                        return new ezcDocumentAlphaListItemGenerator( ezcDocumentAlnumListItemGenerator::LOWER );
                    case 'lowerroman':
                        return new ezcDocumentRomanListItemGenerator( ezcDocumentAlnumListItemGenerator::LOWER );
                    case 'upperalpha':
                        return new ezcDocumentAlphaListItemGenerator( ezcDocumentAlnumListItemGenerator::UPPER );
                    case 'upperroman':
                        return new ezcDocumentRomanListItemGenerator( ezcDocumentAlnumListItemGenerator::UPPER );
                    default:
                        return new ezcDocumentNumberedListItemGenerator();
                }
            default:
                return new ezcDocumentNoListItemGenerator();
        }
    }
}

?>
