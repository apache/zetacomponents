<?php
/**
 * File containing the ezcDocumentXhtmlBlockquoteElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml blockquotes and blockquote attributions
 * 
 * The sematic meaning of the cite XHtml element is sometimes referenced as
 * blockquote attribution, and sometimes as inline quotes. We decide its
 * meaning depending on the parent node type.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlBlockquoteElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        if ( ( $element->parentNode->tagName === 'blockquote' ) ||
             // This is a special filter for the amrkup generated by the RST to
             // HTML conversion
             ( ( $element->parentNode->tagName === 'div' ) &&
               ( $element->parentNode->hasAttribute( 'class' ) ) &&
               ( strpos( $element->parentNode->getAttribute( 'class' ), 'attribution' ) !== false ) ) )
        {
            // Assume this is an attribution.
            $element->setProperty( 'type', 'attribution' );
        }
        elseif ( !$this->isInline( $element ) )
        {
            $element->setProperty( 'type', 'blockquote' );
        }
        else
        {
            $element->setProperty( 'type', 'quote' );
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
        return ( $element->tagName === 'cite' );
    }
}

?>
