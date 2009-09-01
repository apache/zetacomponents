<?php
/**
 * File containing the ezcDocumentOdtHeadlineFilter class
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
class ezcDocumentOdtElementListFilter extends ezcDocumentOdtElementBaseFilter
{
    /**
     * Mapping table for list elements.
     */
    protected $mapping = array(
        'list'      => 'itemizedlist',
        'list-item' => 'listitem',
    );

    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $element->setProperty( 'type', $this->mapping[$element->localName] );
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
            && isset( $this->mapping[$element->localName] ) );
    }
}

?>
