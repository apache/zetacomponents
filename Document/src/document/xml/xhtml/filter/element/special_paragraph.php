<?php
/**
 * File containing the ezcDocumentXhtmlSpecialParagraphElementFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for XHtml table cells.
 *
 * Tables, where the rows are nor structured into a tbody and thead are
 * restructured into those by this filter.
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentXhtmlSpecialParagraphElementFilter extends ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        switch ( true )
        {
            case $this->hasClass( $element, 'note' ):
                $element->setProperty( 'type', 'note' );
                break;

            case $this->hasClass( $element, 'notice' ):
                $element->setProperty( 'type', 'tip' );
                break;

            case $this->hasClass( $element, 'warning' ):
                $element->setProperty( 'type', 'warning' );
                break;

            case $this->hasClass( $element, 'attention' ):
                $element->setProperty( 'type', 'important' );
                break;

            case $this->hasClass( $element, 'danger' ):
                $element->setProperty( 'type', 'caution' );
                break;

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
        return ( strtolower( $element->tagName ) === 'p' ) &&
               ( $element->hasAttribute( 'class' ) );
    }
}

?>
