<?php
/**
 * File containing the ezcDocumentDocbookToOdtSectionHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit docbook sections
 *
 *
 * @TODO: Implement.
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtSectionHandler extends ezcDocumentDocbookToOdtBaseHandler
{
    /**
     * Current section nesting level in the docbook document.
     *
     * @var int
     */
    protected $level = 0;

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
        if ( $node->localName === 'title' )
        {
            $h = $root->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'h'
            );
            $h->setAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'text:outline-level',
                $this->level
            );
            $root->appendChild( $h );

            $this->styler->applyStyles( $node, $h );

            $converter->visitChildren( $node, $h );
        }
        else
        {
            ++$this->level;
            
            // @TODO: Handling of ID and internal ref?
            $converter->visitChildren( $node, $root );

            --$this->level;
        }

        return $root;
    }
}

?>
