<?php

class ezcDocumentOdtTextStylePropertyGenerator implements ezcDocumentOdtStylePropertyGenerator
{
    protected $attributeConverterMap = array(
        'text-decoration' => 'convertTextDecoration',
        ''
    );

    protected $attributeNameMap = array(
    );

    public function createProperty( DOMElement $parent, array $styles )
    {
        $prop = $parent->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'text-properties'
        );

        foreach ( $styles as $styleName => $styleValue )
        {
            $this->convertAttribute( $prop, $styleName, $styleValue );
        }
    }

    protected function convertAttribute( DOMElement $prop, $styleName, $styleValue )
    {
        if ( isset( $this->attributeConverterMap[$styleName] ) )
        {
            $method = $this->attributeConverterMap[$styleName];
            $this->$method( $prop, $styleValue );
        }
    }

    protected function convertTextDecoration( DOMElement $prop, $value )
    {
    }
}

?>
