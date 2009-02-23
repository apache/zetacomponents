<?php
/**
 * File containing the itemized list handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit itemized list / bullet lists
 *
 * Visit itemized lists (bullet list) and maintain the correct indentation for
 * list items.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstItemizedListHandler extends ezcDocumentDocbookToRstBaseHandler
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
        ezcDocumentDocbookToRstConverter::$indentation += 2;

        foreach ( $node->childNodes as $child )
        {
            if ( ( $child->nodeType === XML_ELEMENT_NODE ) &&
                 ( $child->tagName === 'listitem' ) )
            {
                $root .= str_repeat( ' ', ezcDocumentDocbookToRstConverter::$indentation - 2 ) . $converter->options->itemListCharacter . ' ' .
                    trim( $converter->visitChildren( $child, '' ) ) . "\n\n";
            }
        }

        ezcDocumentDocbookToRstConverter::$indentation -= 2;
        return $root;
    }
}

?>
