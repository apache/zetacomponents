<?php

class ezcDocumentOdtColorStyleConverter implements ezcDocumentOdtStyleConverter
{
    /**
     * Converts the 'font-*' CSS styles.
     *
     * This method receives a $targetProperty DOMElement and converts the given 
     * style with $styleName and $styleValue to attributes on this 
     * $targetProperty.
     * 
     * @param DOMElement $targetProperty 
     * @param string $styleName 
     * @param ezcDocumentPcssStyleValue $styleValue 
     */
    public function convert( DOMElement $targetProperty, $styleName, ezcDocumentPcssStyleValue $styleValue )
    {
        $targetProperty->setAttributeNS(
            ezcDocumentOdt::NS_ODT_FO,
            "fo:{$styleName}",
            ezcDocumentOdtStyleConverterTools::serializeColor( $styleValue->value )
        );
    }
}

?>
