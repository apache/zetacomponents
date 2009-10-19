<?php

class ezcDocumentOdtStyleGenerator
{
    /**
     * ODT <office:styles> element.
     * 
     * @var DOMElement
     */
    protected $styleSection;

    /**
     * ODT <office:font-face-decls> element. 
     * 
     * @var DOMElement
     */
    protected $fontFaceDecls;

    /**
     * Creates a new style generator for the given $styleSection.
     *
     * $styleSection must be the <office:styles> DOMElement, $odtFontFaceDecls 
     * the <office:font-face-decls> DOMElement. Styles will be generated into 
     * these 2 DOMElements.
     * 
     * @param DOMElement $odtStyleSection 
     * @param DOMElement $odtFontFaceDecls 
     */
    public function __construct( DOMElement $odtStyleSection, DOMElement $odtFontFaceDecls )
    {
        $this->styleSection  = $odtStyleSection;
        $this->fontFaceDecls = $odtFontFaceDecls;
    }

    /**
     * Applies the given $style to the $odtElement.
     *
     * $style is an array of style information as produced by {@link 
     * ezcDocumentPcssStyleInferencer::inferenceFormattingRules()}. The styling 
     * information given in this array is applied to the $odtElement by 
     * creating a new anonymous style in the ODT style section and applying the 
     * corresponding attributes to reference this style.
     * 
     * @param DOMElement $odtElement 
     * @param array $style 
     */
    public function applyStyle( DOMElement $odtElement, array $style )
    {
    }
}

?>
