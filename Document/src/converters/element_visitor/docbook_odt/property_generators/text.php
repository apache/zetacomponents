<?php

class ezcDocumentOdtTextStylePropertyGenerator implements ezcDocumentOdtStylePropertyGenerator
{
    protected $attributeConverterMap = array(
        'text-decoration'  => 'convertTextDecoration',
        'font-size'        => 'convertFontSize',
        'font-name'        => 'convertFontProperty',
        'font-weight'      => 'convertFontProperty',
        'color'            => 'convertColorProperty',
        'background-color' => 'convertColorProperty',
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
     * @param ezcDocumentPcssStyleValue $styleValue 
     * @return void
     */
    protected function convertAttribute( DOMElement $prop, $styleName, ezcDocumentPcssStyleValue $styleValue )
    {
        if ( isset( $this->attributeConverterMap[$styleName] ) )
        {
            $method = $this->attributeConverterMap[$styleName];
            $this->$method( $prop, $styleName, $styleValue );
        }
    }

    /**
     * Converts the "text-decoration" style attribute.
     * 
     * @param DOMElement $prop 
     * @param string $styleName
     * @param ezcDocumentPcssStyleListValue $value 
     * @return void
     */
    protected function convertTextDecoration( DOMElement $prop, $styleName, ezcDocumentPcssStyleListValue $value )
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

    /**
     * Converts the "font-size" style attribute.
     * 
     * @param DOMElement $prop 
     * @param string $styleName
     * @param ezcDocumentPcssStyleMeasureValue $value 
     * @return void
     */
    protected function convertFontSize( DOMElement $prop, $styleName, ezcDocumentPcssStyleMeasureValue $value )
    {
        $this->convertFontProperty(
            $prop,
            $styleName,
            new ezcDocumentPcssStyleStringValue(
                "{$value->value}mm"
            )
        );
    }

    /**
     * Converts the "font-name" style attribute.
     * 
     * @param DOMElement $prop 
     * @param string $styleName
     * @param ezcDocumentPcssStyleStringValue $value 
     * @return void
     * @TODO Need to convert this from font-family before calling the text 
     *       property generator (register font decl)!
     */
    protected function convertFontName( DOMElement $prop, $styleName, ezcDocumentPcssStyleStringValue $value )
    {
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_FO,
            'fo:font-name',
            $value->value
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:font-name-asian',
            $value->value
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:font-name-complex',
            $value->value
        );
    }

    /**
     * Converts the "font-*" style attributes.
     * 
     * @param DOMElement $prop 
     * @param string $styleName
     * @param ezcDocumentPcssStyleStringValue $value 
     * @return void
     */
    protected function convertFontProperty( DOMElement $prop, $styleName, ezcDocumentPcssStyleStringValue $value )
    {
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_FO,
            "fo:{$styleName}",
            $value->value
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            "style:{$styleName}-asian",
            $value->value
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            "style:{$styleName}-complex",
            $value->value
        );
    }

    /**
     * Converts color style attributes.
     * 
     * @param DOMElement $prop 
     * @param string $styleName
     * @param ezcDocumentPcssStyleColorValue $value 
     * @return void
     */
    protected function convertColorProperty( DOMElement $prop, $styleName, ezcDocumentPcssStyleColorValue $value )
    {
        if ( $value->value['alpha'] >= .5 )
        {
            $prop->setAttributeNS(
                ezcDocumentOdt::NS_ODT_FO,
                "fo:{$styleName}",
                'transparent'
            );
        }
        else
        {
            $prop->setAttributeNS(
                ezcDocumentOdt::NS_ODT_FO,
                "fo:{$styleName}",
                sprintf(
                    '#%02x%02x%02x',
                    round( $value->value['red'] * 255 ),
                    round( $value->value['green'] * 255 ),
                    round( $value->value['blue'] * 255 )
                )
            );

        }
    }
}

?>
