<?php

class ezcDocumentOdtStyleParser
{
    /**
     * Maps list-leve style XML elements to classes.
     *
     * @var array 
     */
    protected static $listClassMap = array(
        'list-level-style-number' => 'ezcDocumentOdtListLevelStyleNumber',
        'list-level-style-bullet' => 'ezcDocumentOdtListLevelStyleBullet',
    );

    /**
     * Maps XML attributes to object attributes.
     *
     * @var array 
     */
    protected static $listAttributeMap = array(
        'list-level-style-number' => array(
            ezcDocumentOdt::NS_ODT_STYLE => array(
                'num-format' => 'numFormat',
            ),
            ezcDocumentOdt::NS_ODT_TEXT => array(
                'display-levels' => 'displayLevels',
                'start-value'    => 'startValue'
            ),
        ),
        'list-level-style-bullet' => array(
            ezcDocumentOdt::NS_ODT_STYLE => array(
                'num-suffix'  => 'numSuffix',
                'num-prefix'  => 'numPrefix',
            ),
            ezcDocumentOdt::NS_ODT_TEXT => array(
                'bullet-char' => 'bulletChar',
            ),
        ),
    );

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
    public function parseStyle( DOMElement $odtStyle, $family, $name = null )
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
     * Parses the given $odtStyle.
     *
     * Parses the given $odtStyle and returns a list style with $name.
     * 
     * @param DOMElement $odtStyle 
     * @param mixed $name 
     * @return ezcDocumentOdtListStyle
     */
    public function parseListStyle( DOMElement $odtStyle, $name )
    {
        $listStyle = new ezcDocumentOdtListStyle( $name );

        foreach ( $odtStyle->childNodes as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE )
            {
                $listLevel = $this->parseListLevel( $child );
                $listStyle->listLevels[$listLevel->level] = $listLevel;
            }
        }

        return $listStyle;
    }

    /**
     * Parses a list level.
     *
     * Parses the given $listLevelElement and returns a corresponding 
     * list-level object.
     * 
     * @param DOMElement $listLevelElement 
     * @return ezcDocumentOdtListLevelStyle
     */
    protected function parseListLevel( DOMElement $listLevelElement )
    {
        if ( !isset( self::$listClassMap[$listLevelElement->localName] ) )
        {
            throw new RuntimeException( "Unknown list-level element {$listLevelElement->localName}." );
        }

        $listLevelClass = self::$listClassMap[$listLevelElement->localName];
        $listLevel = new $listLevelClass(
            $listLevelElement->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'level'
            )
        );

        foreach ( self::$listAttributeMap[$listLevelElement->localName] as $ns => $attrs )
        {
            foreach ( $attrs as $xmlAttr => $objAttr )
            {
                if ( $listLevelElement->hasAttributeNS( $ns, $xmlAttr ) )
                {
                    $listLevel->$objAttr = $listLevelElement->getAttributeNS(
                        $ns,
                        $xmlAttr
                    );
                }
            }
        }

        return $listLevel;
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
