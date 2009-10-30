<?php
/**
 * File containing the ezcDocumentDocbookToOdtInlineHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit paragraphs.
 *
 * Visit docbook paragraphs and transform them into ODT paragraphs.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtInlineHandler extends ezcDocumentDocbookToOdtBaseHandler
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
        // @TODO: Determine style.
        $inline = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'span'
        );
        $this->styler->applyStyles( $node, $inline );

        $converter->visitChildren( $node, $inline );
        return $root;
    }
}

?>
