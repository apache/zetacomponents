<?php
/**
 * File containing the ezcDocumentOdtTextStyleGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Class to generate styles for paragraph elements (<h> and <p>).
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtTextStyleGenerator extends ezcDocumentOdtStyleGenerator
{
    /**
     * Text property generator.
     * 
     * @var ezcDocumentOdtStyleTextPropertyGenerator
     */
    protected $textPropertyGenerator;

    /**
     * Creates a new style genertaor.
     * 
     * @param ezcDocumentOdtStyleConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtStyleConverterManager $styleConverters )
    {
        $this->textPropertyGenerator = new ezcDocumentOdtStyleTextPropertyGenerator(
            $styleConverters
        );
    }

    /**
     * Returns if the given $odtElement is handled by this generator.
     * 
     * @param DOMElement $odtElement 
     * @return bool
     */
    public function handles( DOMElement $odtElement )
    {
        return (
            $odtElement->localName === 'span'
        );
    }
    
    /**
     * Creates the styles with $styleAttributes for the given $odtElement.
     * 
     * @param DOMElement $odtElement 
     * @param array(string=>ezcDocumentPcssStyleValue) $styleAttributes 
     */
    public function createStyle( ezcDocumentOdtStyleInformation $styleInfo, DOMElement $odtElement, array $styleAttributes )
    {
        $styleName = $this->getUniqueStyleName( $odtElement->localName );

        $style = $styleInfo->styleSection->appendChild(
            $styleInfo->styleSection->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'style'
            )
        );

        $style->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:family',
            'text'
        );
        $style->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:name',
            $styleName
        );

        $odtElement->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:style-name',
            $styleName
        );

        $this->textPropertyGenerator->createProperty(
            $style,
            $styleAttributes
        );
    }
}

?>
