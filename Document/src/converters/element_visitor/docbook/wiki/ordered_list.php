<?php

/**
 * File containing the ezcDocumentDocbookToWikiOrderedListHandler class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit ordered list / enumerated lists
 *
 * Visit ordered lists (enumerated list) and maintain the correct indentation for
 * list items.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToWikiOrderedListHandler extends ezcDocumentDocbookToWikiBaseHandler
{
    /**
     * Current list indentation level
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
     * @param ezcDocumentDocbookElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    public function handle( ezcDocumentDocbookElementVisitorConverter $converter, DOMElement $node, $root )
    {
        ++$this->level;

        foreach ( $node->childNodes as $child )
        {
            if ( ( $child->nodeType === XML_ELEMENT_NODE ) &&
                 ( $child->tagName === 'listitem' ) )
            {
                foreach ( $child->childNodes as $para )
                {
                    if ( $para->nodeType !== XML_ELEMENT_NODE )
                    {
                        continue;
                    }

                    if ( $para->tagName === 'para' )
                    {
                        $root .= str_repeat( '#', $this->level ) . ' ' .
                            trim( $converter->visitChildren( $para, '' ) ) . "\n\n";
                    }
                    else
                    {
                        $root = $converter->visitNode( $para, $root );
                    }
                }
            }
        }

        --$this->level;
        return $root;
    }
}

?>
