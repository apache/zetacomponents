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
}

?>
