<?php
/**
 * File containing the ezcDocumentOdtStyleInformation struct class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Struct class to cover style elements from an ODT document.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtStyleInformation extends ezcBaseStruct
{
    /**
     * Style section of the target ODT.
     * 
     * @var DOMElement
     */
    public $styleSection;

    /**
     * Font face declaration section of the target ODT. 
     * 
     * @var DOMElement
     */
    public $fontFaceDecls;

    /**
     * Creates a new ODT style information struct.
     *
     * The $styleSection and $fontFaceDecls must be from the target ODT 
     * DOMDocument.
     * 
     * @param DOMElement $styleSection 
     * @param DOMElement $fontFaceDecls 
     */
    public function __construct( DOMElement $styleSection, DOMElement $fontFaceDecls )
    {
        $this->styleSection  = $styleSection;
        $this->fontFaceDecls = $fontFaceDecls;
    }
}

?>
