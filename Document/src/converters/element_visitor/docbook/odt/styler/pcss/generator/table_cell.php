<?php
/**
 * File containing the ezcDocumentOdtTableCellStyleGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Class to generate styles for table-cell elements.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtTableCellStyleGenerator extends ezcDocumentOdtStyleGenerator
{
    /**
     * TableCell property generator. 
     * 
     * @var ezcDocumentOdtStyleTableCellPropertyGenerator
     */
    protected $tableCellPropertyGenerator;

    /**
     * Paragraph property generator. 
     * 
     * @var ezcDocumentOdtStyleParagraphPropertyGenerator
     */
    protected $paragraphPropertyGenerator;

    /**
     * Creates a new style genertaor.
     * 
     * @param ezcDocumentOdtPcssConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtPcssConverterManager $styleConverters )
    {
        $this->tableCellPropertyGenerator = new ezcDocumentOdtStyleTableCellPropertyGenerator(
            $styleConverters
        );
        $this->paragraphPropertyGenerator = new ezcDocumentOdtStyleParagraphPropertyGenerator(
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
            $odtElement->localName === 'table-cell'
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

        $style = $styleInfo->automaticStyleSection->appendChild(
            $styleInfo->automaticStyleSection->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'style'
            )
        );

        $style->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:family',
            'table-cell'
        );
        $style->setAttributeNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'style:name',
            $styleName
        );

        $odtElement->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table:style-name',
            $styleName
        );

        $this->tableCellPropertyGenerator->createProperty(
            $style,
            $styleAttributes
        );
        $this->paragraphPropertyGenerator->createProperty(
            $style,
            $styleAttributes
        );
    }
}

?>
