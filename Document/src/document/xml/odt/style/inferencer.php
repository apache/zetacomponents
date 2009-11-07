<?php

class ezcDocumentOdtStyleInferencer
{
    /**
     * ODT DOMDocument.
     * 
     * @var DOMDocument
     */
    protected $odtDocument;

    /**
     * Style extractor. 
     * 
     * @var ezcDocumentOdtStyleExtractor
     */
    protected $styleExtractor;

    /**
     * Style parser.
     * 
     * @var ezcDocumentOdtStyleParser
     */
    protected $styleParser;

    /**
     * Maps ODT DOMElements to style families.
     * 
     * @var array(string=>array(string=>const))
     */
    protected $styleFamilyMap = array(
        ezcDocumentOdt::NS_ODT_TEXT => array(
            'h'    => ezcDocumentOdtStyle::FAMILY_PARAGRAPH,
            'p'    => ezcDocumentOdtStyle::FAMILY_PARAGRAPH,
            'span' => ezcDocumentOdtStyle::FAMILY_TEXT,
        )
    );

    /**
     * Maps ODT namespaces to style name attributes 
     * 
     * @var array(const=>array(const,string))
     */
    protected $styleNameAttributeMap = array(
        ezcDocumentOdt::NS_ODT_TEXT => array(
            'namespace' => ezcDocumentOdt::NS_ODT_TEXT,
            'attribute' => 'style-name'
        )
    );

    /**
     * Create a new style inferencer for the given document.
     * 
     * @param ezcDocumentOdtStyleInformation $odtDocument 
     */
    public function __construct( DOMDocument $odtDocument )
    {
        $this->odtDocument    = $odtDocument;
        $this->styleExtractor = new ezcDocumentOdtStyleExtractor( $odtDocument );
        $this->styleParser    = new ezcDocumentOdtStyleParser();
    }

    /**
     * Returns the style for the given $odtElement.
     *
     * Inferences the complete styling information for the given $odtElement.
     * 
     * @param DOMElement $odtElement 
     * @return ezcDocumentOdtStyle
     */
    public function getStyle( DOMElement $odtElement )
    {
        $family = $this->getStyleFamily( $odtElement );
        $name   = $this->getStyleName( $odtElement );

        $styleDom = $this->styleExtractor->extractStyle( $family, $name );
        // @TODO: Inference parent / default styles

        return $this->styleParser->parse( $styleDom, $family, $name );
    }

    /**
     * Extracts the style family from $odtElement.
     *
     * Detects the style family the style for $odtElement resides in.
     * 
     * @param DOMElement $odtElement 
     * @return string
     */
    protected function getStyleFamily( DOMElement $odtElement )
    {
        if ( !isset( $this->styleFamilyMap[$odtElement->namespaceURI][$odtElement->localName] ) )
        {
            throw new RuntimeException( "Could not map style family for element '{$odtElement->localName}' in namespace '{$odtElement->namespaceURI}'." );
        }
        return $this->styleFamilyMap[$odtElement->namespaceURI][$odtElement->localName];
    }

    /**
     * Extracts the style name from the given $odtElement.
     *
     * Tries to determine the correct attribute for the style name from the 
     * given $odtElement. If a style name is specified, it is returned. 
     * Otherwise null is returned to indicate that the default style must be 
     * used. 
     * 
     * @param DOMElement $odtElement 
     * @return string|null
     */
    protected function getStyleName( DOMElement $odtElement )
    {
        if ( !isset( $this->styleNameAttributeMap[$odtElement->namespaceURI] ) )
        {
            throw new RuntimeException( "Could not map style name attribute for namespace '{$odtElement->namespaceURI}'." );
        }
        $styleAttrDef = $this->styleNameAttributeMap[$odtElement->namespaceURI];

        $styleName = null;
        if ( $odtElement->hasAttributeNS( $styleAttrDef['namespace'], $styleAttrDef['attribute'] ) )
        {
            $styleName = $odtElement->getAttributeNS(
                $styleAttrDef['namespace'],
                $styleAttrDef['attribute']
            );
        }
        return $styleName;
    }
}

?>
