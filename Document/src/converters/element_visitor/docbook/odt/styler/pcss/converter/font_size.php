<?php

class ezcDocumentOdtPcssFontSizeConverter extends ezcDocumentOdtPcssFontConverter
{
    /**
     * Converts the 'font-size' CSS style.
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
        parent::convert(
            $targetProperty,
            $styleName,
            new ezcDocumentPcssStyleStringValue(
                "{$styleValue->value}mm"
            )
        );
    }
}

?>
