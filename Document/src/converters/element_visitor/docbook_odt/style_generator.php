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
     * Style converter manager. 
     * 
     * @var ezcDocumentOdtStyleConverterManager
     */
    protected $styleConverters;

    /**
     * Set of style generators to use. 
     * 
     * @var array(ezcDocumentOdtStyleGenerator)
     */
    protected $styleGenerators;

    /**
     * Creates a new style generator for the given $odtDocument using 
     * $styleConverters.
     *
     * Creates a new style generator for the given $odtDocument. The style 
     * generator will make use of the given $styleConverters to convert between 
     * CSS and ODT styles.
     * 
     * @param DOMDocument $odtDocument 
     * @param ezcDocumentOdtStyleConverterManager $styleConverters 
     */
    public function __construct( DOMDocument $odtDocument, ezcDocumentOdtStyleConverterManager $styleConverters )
    {

        $this->styleConverters = $styleConverters;
        $this->styleSection = $odtDocument->getElementByTagNameNS(
            ezcDocumentOdt::NS_ODT_OFFICE,
            'styles'
        );
        $this->fontFaceDecls = $odtDocument->getElementByTagNameNS(
            ezcDocumentOdt::NS_ODT_OFFICE,
            'font-face-decls'
        );

        // @TODO: Make configurable
        $this->styleGenerators[] = new ezcDocumentOdtParagraphStyleGenerator(
            $this->styleSection,
            $this->fontFaceDecls,
            $styleConverters
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
     * @param array $styles
     */
    public function applyStyle( DOMElement $odtElement, array $styles )
    {
        foreach ( $this->styleGenerators as $generator )
        {
            if ( $generator->handles( $odtElement ) )
            {
                $generator->createStyle( $odtElement, $styles );
            }
        }
    }
}

?>
