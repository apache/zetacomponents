<?php

class ezcDocumentOdtStyler
{
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
     * Style inferencer on DocBook source. 
     * 
     * @var ezcDocumentPcssStyleInferencer
     */
    protected $styleInferencer;

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
    public function __construct()
    {
        // @TODO: Make configurable
        $this->styleInferencer   = new ezcDocumentPcssStyleInferencer();
        $this->styleConverters   = new ezcDocumentOdtStyleConverterManager();
        $this->styleGenerators[] = new ezcDocumentOdtParagraphStyleGenerator(
            $this->styleConverters
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
    public function applyStyles( ezcDocumentOdtStyleInformation $styleInfo, ezcDocumentLocateable $docBookElement, DOMElement $odtElement )
    {
        $styles = $this->styleInferencer->inferenceFormattingRules( $docBookElement );
        foreach ( $this->styleGenerators as $generator )
        {
            if ( $generator->handles( $odtElement ) )
            {
                $generator->createStyle( $styleInfo, $odtElement, $styles );
            }
        }
    }
}

?>
