<?php
/**
 * File containing the ezcDocumentXhtmlBaseFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Filter for XHtml elements.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentXhtmlElementBaseFilter
{
    /**
     * Filter a single element
     * 
     * @param DOMElement $element 
     * @return void
     */
    abstract public function filterElement( DOMElement $element );

    /**
     * Check if filter handles the current element
     *
     * Returns a boolean value, indicating weather this filter can handle
     * the current element.
     * 
     * @param DOMElement $element 
     * @return void
     */
    abstract public function handles( DOMElement $element );

    /**
     * Is block level element
     *
     * Returns true, if the element is a block level element in XHtml, and
     * false otherwise.
     * 
     * @param DOMElement $element 
     * @return boolena
     */
    protected function isBlockLevelElement( DOMElement $element )
    {
        return in_array(
            strtolower( $element->tagName ),
            array(
                'address',
                'blockquote',
                'center',
                'del',
                'dir',
                'div',
                'dl',
                'fieldset',
                'form',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'hr',
                'ins',
                'li',
                'menu',
                'noframes',
                'noscript',
                'ol',
                'p',
                'pre',
                'table',
                'th',
                'td',
                'ul',
            )
        );
    }

    /**
     * Is current element an inline element
     *
     * Checks if the current element is placed inline, which means, it is
     * either a descendant of some other inline element, or part of a
     * paragraph.
     * 
     * @param DOMElement $element 
     * @return void
     */
    protected function isInlineElement( DOMElement $element )
    {
        return !(
            ( strtolower( $element->parentNode->tagName ) !== 'p' ) &&
            ( $this->isBlockLevelElement( $element->parentNode ) )
        );
    }

    /**
     * Check for element class
     *
     * Check if element has the given class in its class attribute. Returns
     * true, if it is contained, or false, if not.
     * 
     * @param DOMElement $element 
     * @param string $class 
     * @return bool
     */
    protected function hasClass( DOMElement $element, $class )
    {
        return ( $element->hasAttribute( 'class' ) &&
                 preg_match( 
                    '((?:^|\s)' . preg_quote( $class ) . '(?:\s|$))', 
                    $element->getAttribute( 'class' ) 
                 )
        );
    }
}

?>
