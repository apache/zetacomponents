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
 * Class to generate styles for paragraph elements (<h> and <p>).
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtParagraphStyleGenerator
{
    /**
     * Style section.
     * 
     * @var DOMElement
     */
    protected $styles;

    /**
     * Font face declaration.
     * 
     * @var $fontFaceDecls
     */
    protected $fontFaceDecls;

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
     * Style counters.
     * 
     * @var array(string=>int)
     */
    protected $styleCounters = array(
        'h' => 0,
        'p' => 0,
    );

    /**
     * Creates a new style genertaor.
     * 
     * @param DOMElement $styles 
     * @param DOMElement $fontFaceDecls 
     */
    public function __construct( DOMElement $styles, DOMElement $fontFaceDecls, ezcDocumentOdtStyleConverterManager $styleConverters )
    {
        $this->styles        = $styles;
        $this->fontFaceDecls = $fontFaceDecls;

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
            $odtElement->tagName === 'h' || $odtElement->tagName === 'p'
        );
    }
    
    /**
     * Creates the styles with $styleAttributes for the given $odtElement.
     * 
     * @param DOMElement $odtElement 
     * @param array(string=>ezcDocumentPcssStyleValue) $styleAttributes 
     */
    public function createStyle( DOMElement $odtElement, array $styleAttributes )
    {
        $style = $this->styleSection->appendChild(
            $styleSection->documentElement->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'style'
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
            ( $styleName = $odtElement->tagName . ( ++$this->styleCounters[$odtElement->tagName] ) )
        );

        $odtElement->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:style',
            $styleName
        );

        $this->textPropertyGenerator->createProperty(
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
