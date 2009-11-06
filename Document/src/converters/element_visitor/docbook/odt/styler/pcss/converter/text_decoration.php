<?php

class ezcDocumentOdtPcssTextDecorationConverter implements ezcDocumentOdtPcssConverter
{
    /**
     * Converts the 'text-decoration' CSS style.
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
        foreach ( $styleValue->value as $listElement )
        {
            switch ( $listElement )
            {
                case 'line-through':
                    // @TODO: ODF supports much more fine graned properties.
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-type',
                        'single'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-style',
                        'solid'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-width',
                        'auto'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-color',
                        'font-color'
                    );
                    break;
                case 'underline':
                    // @TODO: ODF supports much more fine graned properties.
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-type',
                        'single'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-style',
                        'solid'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-width',
                        'auto'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-color',
                        'font-color'
                    );
                    break;
                case 'overline':
                    // @TODO: Not supported by ODF?
                    break;
                case 'blink':
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-blinking',
                        'true'
                    );
                    break;
            }
        }
    }
}

?>
