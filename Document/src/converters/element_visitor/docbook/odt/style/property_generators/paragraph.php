<?php
/**
 * File containing the ezcDocumentOdtStyleParagraphPropertyGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Paragraph property generator.
 *
 * Creates and fills the paragraph-properties element.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtStyleParagraphPropertyGenerator extends ezcDocumentOdtStylePropertyGenerator
{
    /**
     * Creates a new paragraph-properties generator.
     * 
     * @param ezcDocumentOdtStyleConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtStyleConverterManager $styleConverters )
    {
        parent::__construct(
            $styleConverters,
            array(
                'text-align',
                'widows',
                'orphans',
                'text-indent',
                'margin',
                'border',
            )
        );
    }

    /**
     * Creates the paragraph-properties element.
     *
     * Creates the paragraph-properties element in $parent and applies the fitting $styles.
     * 
     * @param DOMElement $parent 
     * @param array $styles 
     * @return DOMElement The created property
     */
    public function createProperty( DOMElement $parent, array $styles )
    {
        $prop = $parent->appendChild(
            $parent->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'paragraph-properties'
            )
        );
        $this->applyStyleAttributes(
            $prop,
            $styles
        );
    }
}

?>
