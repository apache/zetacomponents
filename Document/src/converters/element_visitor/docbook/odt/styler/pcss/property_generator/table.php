<?php
/**
 * File containing the ezcDocumentOdtStyleTablePropertyGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Table property generator.
 *
 * Creates and fills the table-properties element.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtStyleTablePropertyGenerator extends ezcDocumentOdtStylePropertyGenerator
{
    /**
     * Creates a new table-properties generator.
     * 
     * @param ezcDocumentOdtPcssConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtPcssConverterManager $styleConverters )
    {
        parent::__construct(
            $styleConverters,
            array(
                'margin',
                'background-color',
            )
        );
    }

    /**
     * Creates the table-properties element.
     *
     * Creates the table-properties element in $parent and applies the fitting $styles.
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
                'table-properties'
            )
        );

        $this->applyStyleAttributes(
            $prop,
            $styles
        );
        $this->setFixedAttributes( $prop );
    }

    protected function setFixedAttributes( DOMElement $prop )
    {
        // Align table to margins specified
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table:align',
            'margins'
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table:border-model',
            'separating'
        );
    }
}

?>
