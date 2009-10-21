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
     * Mapping of property types to styles they contain.
     * 
     * @var array(string=>array(string))
     */
    protected $propertyStyleMap = array();

    /**
     * Mapping of CSS style names to converter objects.
     * 
     * @var array(string=>ezcDocumentOdtStyleConverter)
     */
    protected $styleConversionMap = array();

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

        $this->propertyStyleMap = array(
            'text' => array(
                'text-decoration',
                'font-size',
                'font-name',
                'font-weight',
                'color',
                'background-color',
            ),
            'paragraph' => array(
                'text-align',
                'widows',
                'orphans',
                'text-indent',
                'margin',
            ),
        );

        $this->styleConversionMap = array(
            'text-decoration'  => new ezcDocumentOdtTextDecorationStyleConverter(),
            'font-size'        => new ezcDocumentOdtFontSizeStyleConverter(),
            'font-name'        => ( $font = new ezcDocumentOdtFontStyleConverter() ),
            'font-weight'      => $font,
            'color'            => ( $color = new ezcDocumentOdtColorStyleConverter() ),
            'background-color' => $color,
            // misc conversions, automatically with this converter
            // 'text-align'       => ( $misc = new ezcDocumentOdtMiscStyleConverter() ),
            // 'widows'           => $misc,
            // 'orphans'          => $misc,
            // 'text-indent'      => $misc,
            // 'margin'           => new ezcDocumentOdtMarginStyleConverter(),
        );
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
