<?php
/**
 * File containing the ezcDocumentXhtmlEnumeratedElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml enumerated lists.
 *
 * Enumerated lists may have additional information about the list type
 * they are numbered with (alpha, roman, ..), which is kept by this method.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlEnumeratedElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $element->setProperty( 'type', 'orderedlist' );

        $types = array(
            'a' => 'loweralpha',
            'A' => 'upperalpha',
            'i' => 'lowerroman',
            'I' => 'upperroman',
        );
        if ( $element->hasAttribute( 'type' ) &&
             isset( $types[$type = $element->getAttribute( 'type' )] ) )
        {
            $element->setProperty( 'attributes', array(
                'numeration' => $types[$type],
            ) );
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
        return  ( $element->tagName === 'ol' );
    }
}

?>
