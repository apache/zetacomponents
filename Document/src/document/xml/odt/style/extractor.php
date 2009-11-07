<?php

class ezcDocumentOdtStyleExtractor
{
    protected $odt;

    protected $xpath;

    public function __construct( DOMDocument $odt )
    {
        $this->odt = $odt;

        $this->xpath = new DOMXpath( $odt );
        $this->xpath->registerNamespace( 'style', ezcDocumentOdt::NS_ODT_STYLE );
    }

    /**
     * Extract the style identified by $family and $name. 
     *
     * Returns the DOMElement for the style identified by $family and $name. If 
     * $name is left out, the default style for $family will be extracted.
     * 
     * @param string $family 
     * @param string $name 
     * @return DOMElement
     */
    public function extractStyle( $family, $name = null )
    {
        $xpath = '//';
        if ( $name === null )
        {
            $xpath .= "style:default-style[@style:family='{$family}']";
        }
        else
        {
            $xpath .= "style:style[@style:family='{$family}' and @style:name='{$name}']";
        }
        $styles = $this->xpath->query( $xpath );

        if ( $styles->length !== 1 )
        {
            throw new RuntimeException( "Style of family '$family' with name '$name' not found." );
        }
        return $styles->item( 0 );
    }
}

?>
