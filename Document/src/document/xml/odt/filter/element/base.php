<?php
/**
 * File containing the abstract ezcDocumentOdtBaseFilter base class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Basic filter class for ODT element filters.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
abstract class ezcDocumentOdtElementBaseFilter
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
}

?>
