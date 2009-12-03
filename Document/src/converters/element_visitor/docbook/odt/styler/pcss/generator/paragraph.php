<?php
/**
 * File containing the ezcDocumentOdtParagraphStyleGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Class to generate styles for paragraph elements (<text:h/> and <text:p/>).
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtParagraphStyleGenerator extends ezcDocumentOdtStyleGenerator
{
    /**
     * Paragraph property generator. 
     * 
     * @var ezcDocumentOdtStyleParagraphPropertyGenerator
     */
    protected $paragraphPropertyGenerator;

    /**
     * Text property generator.
     * 
     * @var ezcDocumentOdtStyleTextPropertyGenerator
     */
    protected $textPropertyGenerator;

    /**
     * Creates a new style genertaor.
     * 
     * @param ezcDocumentOdtPcssConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtPcssConverterManager $styleConverters )
    {
        $this->paragraphPropertyGenerator = new ezcDocumentOdtStyleParagraphPropertyGenerator(
            $styleConverters
        );
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
            $odtElement->localName === 'h' || $odtElement->localName === 'p'
        );
    }
    
    /**
     * Creates the styles with $styleAttributes for the given $odtElement.
     * 
     * @param ezcDocumentOdtStyleInformation $styleInfo 
     * @param DOMElement $odtElement 
     * @param array $styleAttributes 
     */
    public function createStyle( ezcDocumentOdtStyleInformation $styleInfo, DOMElement $odtElement, array $styleAttributes )
    {
        $styleName = $this->getUniqueStyleName( $odtElement->localName );

        $style = $styleInfo->automaticStyleSection->appendChild(
            $styleInfo->automaticStyleSection->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'style:style'
            )
        );

        $style->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:family',
            'paragraph'
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

        $this->paragraphPropertyGenerator->createProperty(
            $style,
            $styleAttributes
        );
        $this->textPropertyGenerator->createProperty(
            $style,
            $styleAttributes
        );
    }
}

?>
