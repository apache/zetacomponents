<?php
/**
 * File containing the ezcDocumentOdtStyler interface.
 *
 * @access private
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for ODT stylers.
 *
 * This interface must be implemented by stylers provided in the {@link 
 * ezcDocumentDocbookToOdtConverterOptions}.
 *
 * @access private
 * @package Document
 * @version //autogen//
 */
interface ezcDocumentOdtStyler
{
    /**
     * Initialize the styler with the given $styleInfo.
     *
     * This method *must* be called *before* {@link applyStyles()} is called 
     * at all. Otherwise an exception will be thrown. This method is called by 
     * the {@link ezcDocumentDocbookToOdtConverter} whenever a new ODT document 
     * is to be converted.
     * 
     * @param ezcDocumentOdtStyleInformation $styleInfo 
     * @TODO: Refactor to give ODT document here and only use the style info 
     *        struct in the PCSS styler.
     */
    public function init( ezcDocumentOdtStyleInformation $styleInfo );

    /**
     * Applies the style information associated with $docBookElement to 
     * $odtElement.
     *
     * This method must apply the style information associated with the given 
     * $docBookElement to the $odtElement given.
     * 
     * @param ezcDocumentLocateable $docBookElement 
     * @param DOMElement $odtElement 
     * @throws ezcDocumentOdtStylerNotInitializedException
     *         if the styler has not been initialized using the {@link init()} 
     *         method, yet. Initialization is performed in the {@link 
     *         ezcDocumentDocbookToOdtConverter}.
     */
    public function applyStyles( ezcDocumentLocateable $docBookElement, DOMElement $odtElement );
}

?>
