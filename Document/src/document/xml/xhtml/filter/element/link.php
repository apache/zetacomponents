<?php
/**
 * File containing the ezcDocumentXhtmlLinkElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml links.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlLinkElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        if ( $element->hasAttribute( 'name' ) )
        {
            $span = new ezcDocumentXhtmlDomElement( 'span' );
            $element->parentNode->insertBefore( $span, $element );

            // The a element is an anchor
            $span->setProperty( 'type', 'anchor' );
            $span->setProperty( 'attributes', array(
                'ID' => $element->getAttribute( 'name' ),
            ) );
        }
        elseif ( $element->hasAttribute( 'href' ) &&
                 $element->getAttribute( 'href' ) )
        {
            // The element is a reference, but still may be internal or
            // external
            $target = $element->getAttribute( 'href' );
            if ( $target[0] === '#' )
            {
                // Internal target
                $element->setProperty( 'type', 'link' );
                $element->setProperty( 'attributes', array(
                    'linked' => substr( $target, 1 ),
                ) );
            }
            else
            {
                // External target
                $element->setProperty( 'type', 'ulink' );
                $element->setProperty( 'attributes', array(
                    'url' => $target,
                ) );
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
        // @TODO: Add support for xlink
        return ( $element->tagName === 'a' );
    }
}

?>
