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
        if ( $styleValue->value['alpha'] >= .5 )
        {
            $targetProperty->setAttributeNS(
                ezcDocumentOdt::NS_ODT_FO,
                "fo:{$styleName}",
                'transparent'
            );
        }
        else
        {
            $targetProperty->setAttributeNS(
                ezcDocumentOdt::NS_ODT_FO,
                "fo:{$styleName}",
                sprintf(
                    '#%02x%02x%02x',
                    round( $styleValue->value['red'] * 255 ),
                    round( $styleValue->value['green'] * 255 ),
                    round( $styleValue->value['blue'] * 255 )
                )
            );
        }
    }
}

?>
