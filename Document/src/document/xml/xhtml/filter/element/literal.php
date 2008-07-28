<?php
/**
 * File containing the ezcDocumentXhtmlLiteralElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml literals.
 * 
 * Literal blocks in HTML are not really differentiated between inline
 * literals and literal blocks, so we decide on the actual semantics based
 * on the parent node. If the parent node is a block level element, but not
 * a paragraph we assume a literal block, and an inliteral otherwise.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlLiteralElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        if ( !$this->isInlineElement( $element ) )
        {
            $element->setProperty( 'type', 'literallayout' );
        }
        else
        {
            $element->setProperty( 'type', 'literal' );
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
        return ( ( strtolower( $element->tagName ) === 'pre' ) ||
                 ( strtolower( $element->tagName ) === 'code' ) );
    }
}

?>
