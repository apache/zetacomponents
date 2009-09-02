<?php
/**
 * File containing the ezcDocumentOdtWhitespaceFilter class
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
class ezcDocumentOdtElementWhitespaceFilter extends ezcDocumentOdtElementBaseFilter
{
    /**
     * Filter a single element
     *
     * @param DOMElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $spaces = '';
        switch ( $element->localName )
        {
            case 's':
                $count = $element->getAttributeNS( ezcDocumentOdt::NS_ODT_TEXT, 'c' );
                $spaces = str_repeat(
                    ' ',
                    ( $count !== '' ? (int) $count : 1 )
                );
                break;
            case 'tab':
                $spaces = "\t";
                break;
            case 'line-break':
                $spaces = "\n";
                break;
        }
        $element->setProperty( 'spaces', $spaces );
    }

    /**
     * Returns if significant whitespaces occur in the paragraph.
     * 
     * @param DOMElement $element 
     * @return bool
     */
    protected function hasSignificantWhitespace( DOMElement $element ) 
    {
        $xpath = new DOMXpath( $element->ownerDocument );
        $xpath->registerNamespace( 'text', ezcDocumentOdt::NS_ODT_TEXT );

        // @TODO: Really count tabs as significant whitespaces => literal?
        $whitespaces = $xpath->evaluate(
            './/text:c|.//text:tab|.//line-break',
            $element
        );

        return ( $whitespaces instanceof DOMNodeList && $whitespaces->length > 0 );
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
            && ( $element->localName === 's' 
                 || $element->localName === 'tab' 
                 || $element->localName === 'line-break'
               )
        );
    }
}

?>
