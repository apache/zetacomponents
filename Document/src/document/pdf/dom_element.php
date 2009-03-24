<?php
/**
 * File containing the ezcDocumentPdfInferencableDomElement class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Custom DOMElement extension
 *
 * Extends the DOMElement class, to generate, store and cache the location ID
 * of the curretn element.
 *
 * The location ID is based on the parent elements ID, concatenated with the
 * current element name, together with relevant attributes, possible element
 * classes and a possible element ID.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfInferencableDomElement extends DOMElement
{
    /**
     * Calculated location Id
     * 
     * @var string
     */
    protected $locationId = null;

    /**
     * Get elements location ID
     *
     * Return the elements location ID, based on the factors described in the
     * class header.
     * 
     * @return void
     */
    public function getLocationId()
    {
        if ( $locationId !== null )
        {
            return $this->locationId;
        }

        // Calculate location ID...
    }
}

