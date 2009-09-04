<?php
/**
 * File containing the ezcDocumentOdtFootnoteFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for ODT <text:p> elements.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentOdtElementFootnoteFilter extends ezcDocumentOdtElementBaseFilter
{
    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $element->setProperty( 'type', 'footnote' );
        $citations = $element->getElementsByTagNameNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'note-citation'
        );

        // Should be only 1, foreach to remove all
        foreach ( $citations as $cite )
        {
            $attrs = $element->getProperty( 'attributes' );
            if ( $attrs === false )
            {
                $attrs = array();
            }
            $attrs['label'] = $cite->nodeValue;
            $element->setProperty( 'attributes', $attrs );
            $element->removeChild( $cite );
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
        return ( $element->namespaceURI === ezcDocumentOdt::NS_ODT_TEXT
            && $element->localName === 'note' );
    }
}

?>
