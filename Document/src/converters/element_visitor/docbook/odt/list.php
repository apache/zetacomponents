<?php
/**
 * File containing the ezcDocumentDocbookToOdtParagraphHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit lists.
 *
 * Visit docbook lists and transform them into ODT lists.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtListHandler extends ezcDocumentDocbookToOdtBaseHandler
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
        // $style = 'itemizedListStyle';
        // switch ( $node->localName )
        // {
            // case 'itemizedlist':
            // default:
                // $style = 'itemizedListStyle';
        // }

        $list = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'list'
        );
        // @TODO: Style.
        $list->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:style-name',
            'List_Numbered_Numeric'
        );
        
        $root->appendChild( $list );

        $converter->visitChildren( $node, $list );
        return $root;
    }
}

?>
