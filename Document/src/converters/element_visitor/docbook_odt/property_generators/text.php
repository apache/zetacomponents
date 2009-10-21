<?php

class ezcDocumentOdtTextStylePropertyGenerator implements ezcDocumentOdtStylePropertyGenerator
{
    protected $attributeConverterMap = array(
        'text-decoration' => 'convertTextDecoration',
        'font-size' => 'convertFontSize',
    );

    /**
     * Creates the style property as a child of $parent, having the appropriate 
     * style information from $styles attached.
     *
     * This method creates the "text-properties" style property and attaches 
     * all appropriate styling information from $styles to it. The property 
     * DOMElement ist appended as a child to $parent. $styles should be a PCSS 
     * inferenced style array.
     * 
     * @param DOMElement $parent 
     * @param array $styles 
     */
    public function createProperty( DOMElement $parent, array $styles )
    {
        $prop = $parent->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'text-properties'
        );
        $parent->appendChild( $prop );

        foreach ( $styles as $styleName => $styleValue )
        {
            $this->convertAttribute( $prop, $styleName, $styleValue );
        }
    }

    /**
     * Dispatches attribute conversion.
     * 
     * @param DOMElement $prop 
     * @param string $styleName 
     * @param mixed $styleValue 
     * @return void
     */
    protected function convertAttribute( DOMElement $prop, $styleName, $styleValue )
    {
        if ( isset( $this->attributeConverterMap[$styleName] ) )
        {
            $method = $this->attributeConverterMap[$styleName];
            $this->$method( $prop, $styleValue );
        }
    }

    /**
     * Converts the "text-decoration" style attribute.
     * 
     * @param DOMElement $prop 
     * @param mixed $value 
     * @return void
     */
    protected function convertTextDecoration( DOMElement $prop, $value )
    {
        foreach ( $value->value as $listElement )
        {
            switch ( $listElement )
            {
                case 'line-through':
                    // @TODO: ODF supports much more fine graned properties.
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-type',
                        'single'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-style',
                        'solid'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-width',
                        'auto'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-color',
                        'font-color'
                    );
                    break;
                case 'underline':
                    // @TODO: ODF supports much more fine graned properties.
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-type',
                        'single'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-style',
                        'solid'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-width',
                        'auto'
                    );
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-color',
                        'font-color'
                    );
                    break;
                case 'overline':
                    // @TODO: Not supported by ODF?
                    break;
                case 'blink':
                    $prop->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-blinking',
                        'true'
                    );
                    break;
            }
        }
    }

    protected function convertFontSize(  )
}

?>
