<?php
/**
 * File containing the ezcDocumentXhtmlImageElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml images.
 * 
 * Filter HTML image elements, and try to find optional captions
 * belonging to the image, and alt tags. Transforming the images into
 * correct media objects depending wheather they are inlined or not.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlImageElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        if ( !$element->hasAttribute( 'src' ) )
        {
            // If there is no actual file referenced, we have nothing to do.
            return;
        }

        if ( $this->isInlineElement( $element ) )
        {
            // Image inline in text.
            $element->setProperty( 'type', 'inlinemediaobject' );
        }
        else
        {
            $element->setProperty( 'type', 'mediaobject' );
        }

        // Create the descendant nodes
        $imageObject = new ezcDocumentXhtmlDomElement( 'span' );
        $element->appendChild( $imageObject );
        $imageObject->setProperty( 'type', 'imageobject' );

        $imageData = new ezcDocumentXhtmlDomElement( 'span' );
        $imageObject->appendChild( $imageData );
        $imageData->setProperty( 'type', 'imagedata' );
        $attributes = array(
            'fileref' => $element->getAttribute( 'src' ),
        );

        // Keep optionally specified image dimensions
        if ( $element->hasAttribute( 'width' ) )
        {
            $attributes['width'] = $element->getAttribute( 'width' );
        }

        if ( $element->hasAttribute( 'height' ) )
        {
            $attributes['depth'] = $element->getAttribute( 'height' );
        }

        // Store attributes for element
        $imageData->setProperty( 'attributes', $attributes );

        // Keep textual image annotations
        if ( $element->hasAttribute( 'alt' ) )
        {
            $textObject = new ezcDocumentXhtmlDomElement( 'span' );
            $element->appendChild( $textObject );
            $textObject->setProperty( 'type', 'textobject' );

            $phrase = new ezcDocumentXhtmlDomElement( 'span', $element->getAttribute( 'alt' ) );
            $textObject->appendChild( $phrase );
            $phrase->setProperty( 'type', 'phrase' );
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
        return ( strtolower( $element->tagName ) === 'img' );
    }
}

?>
