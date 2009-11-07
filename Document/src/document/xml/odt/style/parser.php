<?php

class ezcDocumentOdtStyleParser
{
    /**
     * Parses the given $odtStyle.
     *
     * Parses the given $odtStyle and returns a style of $family with $name.
     * 
     * @param string $family 
     * @param string $name 
     * @param DOMElement $odtStyle 
     * @return ezcDocumentOdtStyle
     */
    public function parse( DOMElement $odtStyle, $family, $name = null )
    {
        $style = new ezcDocumentOdtStyle( $family, $name );

        foreach ( $odtStyle->childNodes as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE )
            {
                $style->formattingProperties->setProperties(
                    $this->parseProperties( $child )
                );
            }
        }
        return $style;
    }

    /**
     * Parses the given property.
     * 
     * @param DOMElement $propElement 
     * @return ezcDocumentOdtFormattingProperties
     */
    protected function parseProperties( DOMElement $propElement )
    {
        $props = new ezcDocumentOdtFormattingProperties(
            $propElement->localName
        );
        // @TODO: Parse sub-property elements
        foreach ( $propElement->attributes as $attrNode )
        {
            // @TODO: Parse property values
            $props[$attrNode->localName] = $attrNode->value;
        }
        return $props;
    }
}

?>
