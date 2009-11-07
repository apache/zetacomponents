<?php

class ezcDocumentOdtEmphasisStyleFilterRule implements ezcDocumentOdtStyleFilterRule
{
    /**
     * Returns if the given $odtElement is handled by the rule.
     * 
     * @param DOMElement $odtElement 
     * @return bool
     */
    public function handles( DOMElement $odtElement )
    {
        return ( $odtElement->localName === 'span' );
    }

    /**
     * Filter the given $odtElement based on the given $style.
     *
     * This method will only be called when handles returned true for the given 
     * $odtElement. The method may manipulate the $odtElement, especially its 
     * attributes, based on the style information.
     * 
     * @param DOMElement $odtElement 
     * @param ezcDocumentOdtStyle $style 
     */
    public function filter( DOMElement $odtElement, ezcDocumentOdtStyle $style )
    {
        $textProps = $style->formattingProperties->getProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        if ( isset( $textProps['font-weight'] ) && ( $textProps['font-weight'] === 'bold' || $textProps['font-weight'] >= 700 ) )
        {
            $odtElement->setProperty(
                'type',
                'emphasis'
            );
        }
    }
}

?>
